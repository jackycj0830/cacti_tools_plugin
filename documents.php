<?php
$dir = __DIR__ . '/Documents';
$files = scandir($dir);

// 過濾允許的副檔名
$allowed = ['pdf', 'docx', 'xlsx', 'pptx', 'png', 'jpg', 'jpeg', 'gif', 'bmp'];
$list = [];

foreach ($files as $file) {
    if ($file === '.' || $file === '..') continue;
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    if (in_array($ext, $allowed)) {
        $list[] = $file;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document Browser</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f7f7f7; margin: 0; padding: 0; }
        .container { max-width: 800px; margin: 40px auto; background: #fff; border-radius: 10px; box-shadow: 0 2px 8px #0001; padding: 30px; }
        h1 { font-size: 2em; }
        ul { list-style: none; padding: 0; }
        li { margin: 0.5em 0; }
        a { text-decoration: none; color: #2062a8; }
        a:hover { text-decoration: underline; }
        #viewer { margin-top: 30px; min-height: 400px; background: #eee; padding: 20px; border-radius: 8px; }
        .refresh { float: right; font-size: 0.9em; cursor: pointer; color: #007c3c; }
    </style>
    <script>
        function openFile(file) {
            let viewer = document.getElementById('viewer');
            let ext = file.split('.').pop().toLowerCase();
            let url = 'Documents/' + encodeURIComponent(file);

            // 檔案類型預覽方式
            if(['png','jpg','jpeg','gif','bmp'].includes(ext)) {
                viewer.innerHTML = `<img src="${url}" style="max-width:100%; max-height:600px;" alt="${file}">`;
            } else if(ext === 'pdf') {
                viewer.innerHTML = `<embed src="${url}" type="application/pdf" width="100%" height="600px">`;
            } else if(['docx','xlsx','pptx'].includes(ext)) {
                // 使用 Office Web Viewer 預覽
                let link = encodeURIComponent(window.location.origin + '/' + url);
                viewer.innerHTML = `<iframe src="https://view.officeapps.live.com/op/embed.aspx?src=${link}" width="100%" height="600px" frameborder="0"></iframe>`;
            } else {
                viewer.innerHTML = 'Preview not supported.';
            }
        }

        function refreshList() {
            location.reload();
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>
            Cacti Documents
            <span class="refresh" onclick="refreshList()">&#x21bb; Refresh</span>
        </h1>
        <ul>
        <?php foreach ($list as $file): ?>
            <li>
                <a href="javascript:void(0)" onclick="openFile('<?php echo addslashes($file); ?>')">
                    <?php echo htmlspecialchars($file); ?>
                </a>
            </li>
        <?php endforeach; ?>
        </ul>

        <div id="viewer">
            <!-- 文件預覽區域 -->
            <em>Please select a file to preview.</em>
        </div>
    </div>
</body>
</html>
