<?php
/**
 * Multilingual System Test Page
 * 
 * This page tests the PHP-based multilingual system functionality
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('', 'test', true);
?>

<h1>🧪 多語言系統測試頁面</h1>

<div style="background: #e3f2fd; padding: 20px; border-radius: 8px; margin: 20px 0;">
    <h2>🌍 系統狀態</h2>
    <p><strong>當前語言:</strong> <?php echo $languageManager->getCurrentLanguage(); ?></p>
    <p><strong>語言名稱:</strong> <?php echo $languageManager->getLanguageName($languageManager->getCurrentLanguage()); ?></p>
    <p><strong>支持的語言:</strong> <?php echo implode(', ', $languageManager->getSupportedLanguages()); ?></p>
</div>

<div style="background: #f3e5f5; padding: 20px; border-radius: 8px; margin: 20px 0;">
    <h2>📝 翻譯測試</h2>
    <table border="1" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #9c27b0; color: white;">
                <th style="padding: 10px;">翻譯鍵</th>
                <th style="padding: 10px;">翻譯結果</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="padding: 8px;">main_title</td>
                <td style="padding: 8px;"><?php _e('main_title'); ?></td>
            </tr>
            <tr style="background: #f5f5f5;">
                <td style="padding: 8px;">requirements</td>
                <td style="padding: 8px;"><?php _e('requirements'); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px;">navigating_ui_title</td>
                <td style="padding: 8px;"><?php _e('navigating_ui_title'); ?></td>
            </tr>
            <tr style="background: #f5f5f5;">
                <td style="padding: 8px;">management</td>
                <td style="padding: 8px;"><?php _e('management'); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px;">devices</td>
                <td style="padding: 8px;"><?php _e('devices'); ?></td>
            </tr>
            <tr style="background: #f5f5f5;">
                <td style="padding: 8px;">graphs</td>
                <td style="padding: 8px;"><?php _e('graphs'); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px;">data_sources</td>
                <td style="padding: 8px;"><?php _e('data_sources'); ?></td>
            </tr>
            <tr style="background: #f5f5f5;">
                <td style="padding: 8px;">templates</td>
                <td style="padding: 8px;"><?php _e('templates'); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px;">principles_operation_title</td>
                <td style="padding: 8px;"><?php _e('principles_operation_title'); ?></td>
            </tr>
            <tr style="background: #f5f5f5;">
                <td style="padding: 8px;">data_storage_title</td>
                <td style="padding: 8px;"><?php _e('data_storage_title'); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px;">extending_capabilities_title</td>
                <td style="padding: 8px;"><?php _e('extending_capabilities_title'); ?></td>
            </tr>
            <tr style="background: #f5f5f5;">
                <td style="padding: 8px;">graph_overview_title</td>
                <td style="padding: 8px;"><?php _e('graph_overview_title'); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px;">graph_management</td>
                <td style="padding: 8px;"><?php _e('graph_management'); ?></td>
            </tr>
            <tr style="background: #f5f5f5;">
                <td style="padding: 8px;">graph_template_single</td>
                <td style="padding: 8px;"><?php _e('graph_template_single'); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px;">how_to_graph_title</td>
                <td style="padding: 8px;"><?php _e('how_to_graph_title'); ?></td>
            </tr>
            <tr style="background: #f5f5f5;">
                <td style="padding: 8px;">creating_device_title</td>
                <td style="padding: 8px;"><?php _e('creating_device_title'); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px;">snmp_options_title</td>
                <td style="padding: 8px;"><?php _e('snmp_options_title'); ?></td>
            </tr>
            <tr style="background: #f5f5f5;">
                <td style="padding: 8px;">viewing_graphs_title</td>
                <td style="padding: 8px;"><?php _e('viewing_graphs_title'); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px;">graph_manipulation_title</td>
                <td style="padding: 8px;"><?php _e('graph_manipulation_title'); ?></td>
            </tr>
            <tr style="background: #f5f5f5;">
                <td style="padding: 8px;">graph_zooming_title</td>
                <td style="padding: 8px;"><?php _e('graph_zooming_title'); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px;">devices_title</td>
                <td style="padding: 8px;"><?php _e('devices_title'); ?></td>
            </tr>
            <tr style="background: #f5f5f5;">
                <td style="padding: 8px;">web_gui_option_title</td>
                <td style="padding: 8px;"><?php _e('web_gui_option_title'); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px;">snmp_credentials_title</td>
                <td style="padding: 8px;"><?php _e('snmp_credentials_title'); ?></td>
            </tr>
            <tr style="background: #f5f5f5;">
                <td style="padding: 8px;">sites_title</td>
                <td style="padding: 8px;"><?php _e('sites_title'); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px;">site_management</td>
                <td style="padding: 8px;"><?php _e('site_management'); ?></td>
            </tr>
            <tr style="background: #f5f5f5;">
                <td style="padding: 8px;">physical_location</td>
                <td style="padding: 8px;"><?php _e('physical_location'); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px;">trees_title</td>
                <td style="padding: 8px;"><?php _e('trees_title'); ?></td>
            </tr>
            <tr style="background: #f5f5f5;">
                <td style="padding: 8px;">tree_management</td>
                <td style="padding: 8px;"><?php _e('tree_management'); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px;">hierarchical_organization</td>
                <td style="padding: 8px;"><?php _e('hierarchical_organization'); ?></td>
            </tr>
            <tr style="background: #f5f5f5;">
                <td style="padding: 8px;">graphs_title</td>
                <td style="padding: 8px;"><?php _e('graphs_title'); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px;">graph_management_console</td>
                <td style="padding: 8px;"><?php _e('graph_management_console'); ?></td>
            </tr>
            <tr style="background: #f5f5f5;">
                <td style="padding: 8px;">modifying_graph_template_title</td>
                <td style="padding: 8px;"><?php _e('modifying_graph_template_title'); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px;">data_sources_title</td>
                <td style="padding: 8px;"><?php _e('data_sources_title'); ?></td>
            </tr>
            <tr style="background: #f5f5f5;">
                <td style="padding: 8px;">data_source_management</td>
                <td style="padding: 8px;"><?php _e('data_source_management'); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px;">storage_considerations_title</td>
                <td style="padding: 8px;"><?php _e('storage_considerations_title'); ?></td>
            </tr>
            <tr style="background: #f5f5f5;">
                <td style="padding: 8px;">aggregates_title</td>
                <td style="padding: 8px;"><?php _e('aggregates_title'); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px;">aggregate_graphs</td>
                <td style="padding: 8px;"><?php _e('aggregate_graphs'); ?></td>
            </tr>
            <tr style="background: #f5f5f5;">
                <td style="padding: 8px;">data_collectors_title</td>
                <td style="padding: 8px;"><?php _e('data_collectors_title'); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px;">main_data_collector_term</td>
                <td style="padding: 8px;"><?php _e('main_data_collector_term'); ?></td>
            </tr>
            <tr style="background: #f5f5f5;">
                <td style="padding: 8px;">remote_data_collector_term</td>
                <td style="padding: 8px;"><?php _e('remote_data_collector_term'); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px;">spine_title</td>
                <td style="padding: 8px;"><?php _e('spine_title'); ?></td>
            </tr>
            <tr style="background: #f5f5f5;">
                <td style="padding: 8px;">spine_data_collection</td>
                <td style="padding: 8px;"><?php _e('spine_data_collection'); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px;">multi_threaded</td>
                <td style="padding: 8px;"><?php _e('multi_threaded'); ?></td>
            </tr>
            <tr style="background: #f5f5f5;">
                <td style="padding: 8px;">data_input_methods_title</td>
                <td style="padding: 8px;"><?php _e('data_input_methods_title'); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px;">data_input_method</td>
                <td style="padding: 8px;"><?php _e('data_input_method'); ?></td>
            </tr>
            <tr style="background: #f5f5f5;">
                <td style="padding: 8px;">input_fields</td>
                <td style="padding: 8px;"><?php _e('input_fields'); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px;">data_queries_title</td>
                <td style="padding: 8px;"><?php _e('data_queries_title'); ?></td>
            </tr>
            <tr style="background: #f5f5f5;">
                <td style="padding: 8px;">data_query</td>
                <td style="padding: 8px;"><?php _e('data_query'); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px;">xml_file</td>
                <td style="padding: 8px;"><?php _e('xml_file'); ?></td>
            </tr>
            <tr style="background: #f5f5f5;">
                <td style="padding: 8px;">device_templates_title</td>
                <td style="padding: 8px;"><?php _e('device_templates_title'); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px;">device_template</td>
                <td style="padding: 8px;"><?php _e('device_template'); ?></td>
            </tr>
            <tr style="background: #f5f5f5;">
                <td style="padding: 8px;">automation_templates</td>
                <td style="padding: 8px;"><?php _e('automation_templates'); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px;">graph_templates_title</td>
                <td style="padding: 8px;"><?php _e('graph_templates_title'); ?></td>
            </tr>
            <tr style="background: #f5f5f5;">
                <td style="padding: 8px;">graph_template</td>
                <td style="padding: 8px;"><?php _e('graph_template'); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px;">graph_items</td>
                <td style="padding: 8px;"><?php _e('graph_items'); ?></td>
            </tr>
            <tr style="background: #f5f5f5;">
                <td style="padding: 8px;">data_source_templates_title</td>
                <td style="padding: 8px;"><?php _e('data_source_templates_title'); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px;">aggregate_templates_title</td>
                <td style="padding: 8px;"><?php _e('aggregate_templates_title'); ?></td>
            </tr>
            <tr style="background: #f5f5f5;">
                <td style="padding: 8px;">color_templates_title</td>
                <td style="padding: 8px;"><?php _e('color_templates_title'); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px;">aggregate_overview_title</td>
                <td style="padding: 8px;"><?php _e('aggregate_overview_title'); ?></td>
            </tr>
            <tr style="background: #f5f5f5;">
                <td style="padding: 8px;">color_templates_intro</td>
                <td style="padding: 8px;"><?php _e('color_templates_intro'); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px;">automation_networks_title</td>
                <td style="padding: 8px;"><?php _e('automation_networks_title'); ?></td>
            </tr>
            <tr style="background: #f5f5f5;">
                <td style="padding: 8px;">discovered_devices_title</td>
                <td style="padding: 8px;"><?php _e('discovered_devices_title'); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px;">device_rules_title</td>
                <td style="padding: 8px;"><?php _e('device_rules_title'); ?></td>
            </tr>
            <tr style="background: #f5f5f5;">
                <td style="padding: 8px;">snmp_options_title</td>
                <td style="padding: 8px;"><?php _e('snmp_options_title'); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px;">networks_title</td>
                <td style="padding: 8px;"><?php _e('networks_title'); ?></td>
            </tr>
            <tr style="background: #f5f5f5;">
                <td style="padding: 8px;">networks_automation_title</td>
                <td style="padding: 8px;"><?php _e('networks_automation_title'); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px;">data_profiles_title</td>
                <td style="padding: 8px;"><?php _e('data_profiles_title'); ?></td>
            </tr>
            <tr style="background: #f5f5f5;">
                <td style="padding: 8px;">cdefs_title</td>
                <td style="padding: 8px;"><?php _e('cdefs_title'); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px;">vdefs_title</td>
                <td style="padding: 8px;"><?php _e('vdefs_title'); ?></td>
            </tr>
            <tr style="background: #f5f5f5;">
                <td style="padding: 8px;">colors_title</td>
                <td style="padding: 8px;"><?php _e('colors_title'); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px;">gprints_title</td>
                <td style="padding: 8px;"><?php _e('gprints_title'); ?></td>
            </tr>
            <tr style="background: #f5f5f5;">
                <td style="padding: 8px;">import_template_title</td>
                <td style="padding: 8px;"><?php _e('import_template_title'); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px;">export_template_title</td>
                <td style="padding: 8px;"><?php _e('export_template_title'); ?></td>
            </tr>
        </tbody>
    </table>
</div>

<div style="background: #e8f5e8; padding: 20px; border-radius: 8px; margin: 20px 0;">
    <h2>🔗 連結測試</h2>
    <p>以下連結應該都指向 PHP 文件：</p>
    <ul>
        <li><a href="documentation.php">主文檔頁面 (documentation.php)</a></li>
        <li><a href="Requirements.php">系統要求 (Requirements.php)</a></li>
        <li><a href="Navigating-The-User-Interface.php">導航用戶界面 (Navigating-The-User-Interface.php)</a></li>
        <li><a href="Principles-of-Operation.php">操作原理 (Principles-of-Operation.php)</a></li>
        <li><a href="Graph-Overview.php">圖形概述 (Graph-Overview.php)</a></li>
        <li><a href="How-to-Graph-Your-Network.php">如何繪製網路圖形 (How-to-Graph-Your-Network.php)</a></li>
        <li><a href="Viewing-Graphs.php">檢視圖形 (Viewing-Graphs.php)</a></li>
        <li><a href="Devices.php">裝置管理 (Devices.php)</a></li>
        <li><a href="Sites.php">站點管理 (Sites.php)</a></li>
        <li><a href="Trees.php">樹管理 (Trees.php)</a></li>
        <li><a href="Graphs.php">圖形管理 (Graphs.php)</a></li>
        <li><a href="Data-Sources.php">資料來源管理 (Data-Sources.php)</a></li>
        <li><a href="Aggregates.php">聚合圖形 (Aggregates.php)</a></li>
        <li><a href="Data-Collectors.php">資料收集器 (Data-Collectors.php)</a></li>
        <li><a href="Spine-Data-Collection.php">Spine 資料收集 (Spine-Data-Collection.php)</a></li>
        <li><a href="Data-Input-Methods.php">資料輸入方法 (Data-Input-Methods.php)</a></li>
        <li><a href="Data-Queries.php">資料查詢 (Data-Queries.php)</a></li>
        <li><a href="Device-Templates.php">裝置範本 (Device-Templates.php)</a></li>
        <li><a href="Graph-Templates.php">圖形範本 (Graph-Templates.php)</a></li>
        <li><a href="Data-Source-Templates.php">資料來源範本 (Data-Source-Templates.php)</a></li>
        <li><a href="Aggregate-Templates.php">聚合範本 (Aggregate-Templates.php)</a></li>
        <li><a href="Color-Templates.php">顏色範本 (Color-Templates.php)</a></li>
        <li><a href="Automation-Networks.php">自動化網路 (Automation-Networks.php)</a></li>
        <li><a href="Discovered-Devices.php">發現裝置 (Discovered-Devices.php)</a></li>
        <li><a href="Device-Rules.php">裝置規則 (Device-Rules.php)</a></li>
        <li><a href="Graph-Rules.php">圖形規則 (Graph-Rules.php)</a></li>
        <li><a href="Tree-Rules.php">樹規則 (Tree-Rules.php)</a></li>
        <li><a href="SNMP-Options.php">SNMP 選項 (SNMP-Options.php)</a></li>
        <li><a href="Networks.php">網路 (Networks.php)</a></li>
        <li><a href="Data-Profiles.php">資料來源設定檔 (Data-Profiles.php)</a></li>
        <li><a href="CDEFs.php">CDEF (CDEFs.php)</a></li>
        <li><a href="VDEFs.php">VDEF (VDEFs.php)</a></li>
        <li><a href="Colors.php">顏色 (Colors.php)</a></li>
        <li><a href="GPRINTs.php">GPRINT (GPRINTs.php)</a></li>
        <li><a href="Import-Template.php">範本匯入 (Import-Template.php)</a></li>
        <li><a href="Export-Template.php">範本匯出 (Export-Template.php)</a></li>
    </ul>
</div>

<div style="background: #fff3e0; padding: 20px; border-radius: 8px; margin: 20px 0;">
    <h2>⚙️ 功能測試</h2>
    <h3>語言切換測試</h3>
    <p>使用右上角的語言選擇器測試以下功能：</p>
    <ol>
        <li><strong>英文切換:</strong> 選擇 "English" 查看英文內容</li>
        <li><strong>簡體中文切換:</strong> 選擇 "简体中文" 查看簡體中文內容</li>
        <li><strong>繁體中文切換:</strong> 選擇 "繁體中文" 查看繁體中文內容</li>
    </ol>
    
    <h3>持久化測試</h3>
    <p>測試語言選擇是否在頁面間保持：</p>
    <ol>
        <li>選擇一種語言</li>
        <li>點擊上面的連結導航到其他頁面</li>
        <li>確認語言選擇保持不變</li>
        <li>使用返回按鈕返回此頁面</li>
    </ol>
</div>

<div style="background: #ffebee; padding: 20px; border-radius: 8px; margin: 20px 0;">
    <h2>🐛 調試信息</h2>
    <h3>PHP 信息</h3>
    <ul>
        <li><strong>PHP 版本:</strong> <?php echo phpversion(); ?></li>
        <li><strong>服務器軟件:</strong> <?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown'; ?></li>
        <li><strong>當前腳本:</strong> <?php echo $_SERVER['SCRIPT_NAME']; ?></li>
        <li><strong>請求方法:</strong> <?php echo $_SERVER['REQUEST_METHOD']; ?></li>
    </ul>
    
    <h3>語言檢測信息</h3>
    <ul>
        <li><strong>URL 語言參數:</strong> <?php echo $_GET['lang'] ?? 'None'; ?></li>
        <li><strong>Cookie 語言:</strong> <?php echo $_COOKIE['cacti_doc_lang'] ?? 'None'; ?></li>
        <li><strong>Session 語言:</strong> <?php 
            if (session_status() == PHP_SESSION_NONE) session_start();
            echo $_SESSION['cacti_doc_lang'] ?? 'None'; 
        ?></li>
        <li><strong>瀏覽器語言:</strong> <?php echo $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'None'; ?></li>
    </ul>
    
    <h3>文件檢查</h3>
    <ul>
        <li><strong>語言管理器類:</strong> <?php echo class_exists('LanguageManager') ? '✅ 已加載' : '❌ 未加載'; ?></li>
        <li><strong>英文語言文件:</strong> <?php echo file_exists('languages/en.php') ? '✅ 存在' : '❌ 不存在'; ?></li>
        <li><strong>簡體中文語言文件:</strong> <?php echo file_exists('languages/zh-cn.php') ? '✅ 存在' : '❌ 不存在'; ?></li>
        <li><strong>繁體中文語言文件:</strong> <?php echo file_exists('languages/zh-tw.php') ? '✅ 存在' : '❌ 不存在'; ?></li>
        <li><strong>頁面模板文件:</strong> <?php echo file_exists('includes/page_template.php') ? '✅ 存在' : '❌ 不存在'; ?></li>
    </ul>
</div>

<div style="background: #f1f8e9; padding: 20px; border-radius: 8px; margin: 20px 0;">
    <h2>✅ 測試清單</h2>
    <h3>基本功能測試</h3>
    <ul>
        <li>□ 頁面正常加載</li>
        <li>□ 語言選擇器顯示正常</li>
        <li>□ 返回按鈕顯示正常</li>
        <li>□ 翻譯內容顯示正確</li>
    </ul>
    
    <h3>語言切換測試</h3>
    <ul>
        <li>□ 英文 → 簡體中文切換正常</li>
        <li>□ 英文 → 繁體中文切換正常</li>
        <li>□ 簡體中文 → 繁體中文切換正常</li>
        <li>□ 所有語言切換後內容正確顯示</li>
    </ul>
    
    <h3>導航測試</h3>
    <ul>
        <li>□ 連結指向正確的 PHP 文件</li>
        <li>□ 跨頁面語言選擇保持</li>
        <li>□ 返回按鈕功能正常</li>
        <li>□ 頁面標題翻譯正確</li>
    </ul>
    
    <h3>響應式測試</h3>
    <ul>
        <li>□ 桌面瀏覽器顯示正常</li>
        <li>□ 平板設備顯示正常</li>
        <li>□ 手機設備顯示正常</li>
        <li>□ 語言控制元素在小屏幕上正常工作</li>
    </ul>
</div>

<div style="background: #e1f5fe; padding: 20px; border-radius: 8px; margin: 20px 0;">
    <h2>📋 使用說明</h2>
    <ol>
        <li><strong>測試語言切換:</strong> 使用右上角的語言選擇器切換不同語言</li>
        <li><strong>檢查翻譯:</strong> 觀察頁面內容是否正確翻譯</li>
        <li><strong>測試導航:</strong> 點擊連結測試跨頁面功能</li>
        <li><strong>驗證持久化:</strong> 確認語言選擇在頁面間保持</li>
        <li><strong>檢查響應式:</strong> 在不同設備上測試界面</li>
    </ol>
    
    <p><strong>注意:</strong> 如果發現任何問題，請檢查上面的調試信息部分，確保所有必需的文件都存在且正確加載。</p>
</div>

<script>
// 添加一些客戶端測試功能
document.addEventListener('DOMContentLoaded', function() {
    console.log('🧪 Multilingual test page loaded');
    console.log('Current language:', '<?php echo $languageManager->getCurrentLanguage(); ?>');
    console.log('Available languages:', <?php echo json_encode($languageManager->getSupportedLanguages()); ?>);
    
    // 測試語言選擇器
    const languageSelector = document.getElementById('language-select');
    if (languageSelector) {
        console.log('✅ Language selector found');
        languageSelector.addEventListener('change', function() {
            console.log('🔄 Language changed to:', this.value);
        });
    } else {
        console.error('❌ Language selector not found');
    }
    
    // 測試返回按鈕
    const backButton = document.querySelector('.back-button a');
    if (backButton) {
        console.log('✅ Back button found');
    } else {
        console.log('ℹ️ Back button not shown (normal for test page)');
    }
});
</script>

<?php
// Generate page footer
generatePageFooter();
?>
