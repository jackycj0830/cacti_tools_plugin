<?php
/**
 * 批量更新 PHP 文件以添加多語言支持
 * 這個腳本會自動為指定的 PHP 文件添加語言導航組件
 */

// 需要更新的文件列表
$files_to_update = [
    'documents.php',
    'graph_view.php',
    'install_sshpass.php',
    'logs_content_kb_update.php',
    'main.php',
    'manage_thold_cacti.php',
    'rrd_graph_viewer.php',
    'rrd_graph_viewer_daily.php',
    'rrd_viewer2.php',
    'rrd_viewer_daily.php',
    'setup.php',
    'tools.php',
    'tools_browse.php',
    'updater.php',
    'updater_processes.php',
    'view_logs_localflie_datebak_check.php'
];

// 檢查每個文件並更新
foreach ($files_to_update as $filename) {
    if (!file_exists($filename)) {
        echo "文件不存在: $filename\n";
        continue;
    }
    
    $content = file_get_contents($filename);
    
    // 檢查是否已經包含 lang_nav.php
    if (strpos($content, "require_once 'includes/lang_nav.php'") !== false) {
        echo "文件已更新: $filename\n";
        continue;
    }
    
    // 檢查是否是 PHP 文件
    if (strpos($content, '<?php') === false) {
        echo "不是 PHP 文件: $filename\n";
        continue;
    }
    
    // 添加 require_once 語句
    $updated_content = addLangNavSupport($content, $filename);
    
    if ($updated_content !== $content) {
        // 創建備份
        $backup_filename = $filename . '_BAK_' . date('Ymd_His');
        file_put_contents($backup_filename, $content);
        
        // 寫入更新的內容
        file_put_contents($filename, $updated_content);
        echo "已更新: $filename (備份: $backup_filename)\n";
    } else {
        echo "無需更新: $filename\n";
    }
}

/**
 * 為 PHP 文件添加語言導航支持
 */
function addLangNavSupport($content, $filename) {
    // 如果文件以 <?php 開始，在其後添加 require_once
    if (strpos($content, '<?php') === 0) {
        $content = str_replace('<?php', "<?php\nrequire_once 'includes/lang_nav.php';", $content);
    } else {
        // 如果 <?php 不在開頭，在第一個 <?php 後添加
        $content = preg_replace('/(<\?php)/', "$1\nrequire_once 'includes/lang_nav.php';", $content, 1);
    }
    
    // 檢查是否有 HTML 結構
    if (strpos($content, '<html') !== false) {
        // 更新 HTML lang 屬性
        $content = preg_replace('/<html[^>]*lang=["\'][^"\']*["\'][^>]*>/', '<html lang="en">', $content);
        $content = preg_replace('/<html(?![^>]*lang=)([^>]*)>/', '<html lang="en"$1>', $content);
        
        // 在 <body> 後添加語言導航組件
        if (strpos($content, 'outputLangNav') === false) {
            $content = preg_replace('/(<body[^>]*>)/', "$1\n    <?php outputLangNav(true, 'index.php'); ?>", $content);
        }
    }
    
    // 添加基本的頁面樣式（如果沒有的話）
    if (strpos($content, '<style>') === false && strpos($content, '.css') === false) {
        $basic_styles = '
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .page-header {
            background-color: #2d4b23;
            color: white;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .page-header h1 {
            margin: 0;
            font-size: 1.8em;
        }
    </style>';
        
        // 在 </head> 前添加樣式
        $content = str_replace('</head>', $basic_styles . "\n</head>", $content);
    }
    
    return $content;
}

echo "批量更新完成！\n";
?>
