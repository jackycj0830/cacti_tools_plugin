# Cacti Tools 多語言支援說明

## 概述
Cacti Tools 現在支援三種語言：
- 英文 (English) - 預設語言
- 簡體中文 (简体中文)
- 繁體中文 (繁體中文)

## 功能特點

### 1. 語言選擇器
- 位於每個頁面的右上角
- 可以隨時切換語言
- 語言偏好會自動保存在瀏覽器中

### 2. 返回按鈕
- 位於每個頁面的左上角
- 可以返回上一頁或主頁
- 支援多語言顯示

### 3. 響應式設計
- 在手機和平板上自動調整佈局
- 語言選擇器和返回按鈕會自動縮小

## 已更新的文件

### 核心文件
- `index.php` - 主頁面，包含導航選單
- `includes/lang_nav.php` - 多語言和導航組件

### 功能頁面
- `home.php` - 首頁
- `view_logs_realtime_status.php` - 即時日誌狀態
- `documentation.php` - 知識庫
- `logs_content_kb.php` - 日誌內容知識庫
- `rrd_viewer.php` - RRD 檔案瀏覽器
- `documents.php` - 文件瀏覽器

### 測試頁面
- `test_lang.php` - 語言功能測試頁面

## 技術實現

### 1. 語言配置
所有翻譯都存儲在 JavaScript 對象中：
```javascript
const translations = {
    en: { /* 英文翻譯 */ },
    zhHans: { /* 簡體中文翻譯 */ },
    zhHant: { /* 繁體中文翻譯 */ }
};
```

### 2. 語言切換
使用 `data-lang-key` 屬性標記需要翻譯的元素：
```html
<span data-lang-key="home">Home</span>
```

### 3. 本地存儲
用戶的語言偏好保存在 `localStorage` 中：
```javascript
localStorage.setItem('cacti_tools_lang', lang);
```

## 使用方法

### 1. 基本使用
1. 打開任何頁面
2. 點擊右上角的語言選擇器
3. 選擇您偏好的語言
4. 頁面內容會立即更新

### 2. 開發者指南
如果您需要為新頁面添加多語言支援：

1. 在 PHP 文件開頭添加：
```php
<?php
require_once 'includes/lang_nav.php';
?>
```

2. 在 HTML body 開始處添加：
```php
<?php outputLangNav(true, 'index.php'); ?>
```

3. 為需要翻譯的元素添加 `data-lang-key` 屬性：
```html
<h1 data-lang-key="pageTitle">Page Title</h1>
```

4. 在頁面底部添加翻譯配置：
```javascript
<script>
if (typeof translations !== 'undefined') {
    translations.en.pageTitle = 'Page Title';
    translations.zhHans.pageTitle = '页面标题';
    translations.zhHant.pageTitle = '頁面標題';
}
</script>
```

## 文件結構
```
cacti_tools_plugin/
├── includes/
│   └── lang_nav.php          # 多語言和導航組件
├── index.php                 # 主頁面
├── home.php                  # 首頁
├── test_lang.php             # 語言測試頁面
└── [其他 PHP 文件]           # 各功能頁面
```

## 瀏覽器支援
- Chrome 60+
- Firefox 55+
- Safari 12+
- Edge 79+

## 注意事項
1. 語言偏好會在瀏覽器中持久保存
2. 如果瀏覽器不支援 localStorage，會回退到預設語言（英文）
3. 所有新增的文字都應該添加多語言支援
4. 建議在添加新功能時同時提供三種語言的翻譯

## 故障排除
如果語言切換不工作：
1. 檢查瀏覽器控制台是否有 JavaScript 錯誤
2. 確認 `includes/lang_nav.php` 文件存在且可讀
3. 檢查頁面是否正確包含了多語言腳本
4. 清除瀏覽器緩存並重新載入頁面
