# 🌍 Cacti 文檔多語言 PHP 系統

## 📋 系統概述

這是一個基於 PHP 的多語言文檔系統，支持英文、簡體中文和繁體中文。與之前的即時翻譯系統不同，這個系統將所有翻譯內容存儲在 PHP 語言文件中，便於管理和維護。

## ✨ 主要特色

### 🔧 **PHP 語言管理**
- **語言文件分離** - 每種語言獨立的 PHP 文件
- **易於維護** - 直接編輯 PHP 文件修改翻譯
- **動態加載** - 根據用戶選擇動態加載語言
- **緩存支持** - 高效的語言內容緩存

### 🌐 **三語言支持**
- **English** (預設) - 完整英文內容
- **简体中文** - 完整簡體中文翻譯
- **繁體中文** - 完整繁體中文翻譯

### 💾 **持久化語言選擇**
- **Cookie 存儲** - 30天語言選擇記憶
- **Session 支持** - 會話期間語言保持
- **URL 參數** - 支持 URL 語言切換
- **瀏覽器檢測** - 自動檢測瀏覽器語言

### 📱 **響應式設計**
- **桌面優化** - 完美的桌面瀏覽體驗
- **移動友好** - 適配手機和平板設備
- **觸控支持** - 觸控友好的界面元素

## 🏗️ 系統架構

### 文件結構
```
cacti_tools_plugin/documentation/
├── 📁 includes/
│   ├── language.php           # 語言管理核心類
│   └── page_template.php      # 頁面模板系統
├── 📁 languages/
│   ├── en.php                 # 英文語言文件
│   ├── zh-cn.php             # 簡體中文語言文件
│   └── zh-tw.php             # 繁體中文語言文件
├── 📄 documentation.php       # 主文檔頁面
├── 📄 Requirements.php        # 系統要求頁面
├── 📄 convert_to_php.php      # HTML轉PHP工具
├── 📄 convert_to_multilingual.bat # 轉換批處理腳本
└── 📄 *.php                   # 其他轉換後的PHP頁面
```

### 核心組件

#### 1. LanguageManager 類
- **語言檢測** - 多源語言檢測邏輯
- **內容加載** - 動態語言文件加載
- **緩存管理** - 高效的翻譯內容緩存
- **UI 生成** - 自動生成語言選擇器和導航

#### 2. 語言文件系統
- **結構化存儲** - 分類組織的翻譯內容
- **鍵值對映射** - 簡單的翻譯鍵值系統
- **註釋支持** - 完整的文件註釋和說明

#### 3. 頁面模板系統
- **統一結構** - 所有頁面統一的結構
- **自動注入** - 自動注入語言控制元素
- **響應式樣式** - 內建響應式CSS樣式

## 🚀 快速開始

### 步驟 1: 運行轉換腳本
```bash
# 在文檔目錄下運行
convert_to_multilingual.bat
```

### 步驟 2: 設置 Web 服務器
```bash
# 使用 PHP 內建服務器（測試用）
php -S localhost:8000

# 或配置 Apache/Nginx 指向文檔目錄
```

### 步驟 3: 訪問文檔
```
http://localhost:8000/documentation.php
```

### 步驟 4: 測試功能
1. 使用右上角語言選擇器切換語言
2. 導航到不同頁面測試語言持久化
3. 在移動設備上測試響應式設計

## 🔧 內容管理

### 添加新翻譯

#### 1. 在語言文件中添加新鍵值對
```php
// languages/en.php
'new_feature' => 'New Feature',

// languages/zh-cn.php  
'new_feature' => '新功能',

// languages/zh-tw.php
'new_feature' => '新功能',
```

#### 2. 在 PHP 頁面中使用
```php
<h2><?php _e('new_feature'); ?></h2>
```

### 修改現有翻譯

直接編輯對應語言文件中的值：
```php
// 修改前
'requirements' => 'Requirements',

// 修改後  
'requirements' => 'System Requirements',
```

### 添加新頁面

#### 1. 創建 PHP 頁面
```php
<?php
require_once 'includes/language.php';
require_once 'includes/page_template.php';

generatePageHeader('page_title_new', 'new_page', true);
?>

<h1><?php _e('new_page_title'); ?></h1>
<p><?php _e('new_page_content'); ?></p>

<?php generatePageFooter(); ?>
```

#### 2. 添加對應翻譯
在所有語言文件中添加相應的翻譯鍵值對。

## 🎨 界面自定義

### 修改語言選擇器樣式

編輯 `includes/page_template.php` 中的 CSS：
```css
.language-controls {
    /* 自定義樣式 */
    background: your-custom-color;
    border-radius: your-custom-radius;
}
```

### 自定義返回按鈕

修改 `LanguageManager` 類中的 `generateBackButton` 方法：
```php
public function generateBackButton($showOnMainPage = false) {
    // 自定義返回按鈕邏輯
}
```

## 🧪 測試和驗證

### 功能測試清單

#### ✅ 語言切換測試
- [ ] 英文 → 簡體中文切換
- [ ] 英文 → 繁體中文切換  
- [ ] 簡體中文 → 繁體中文切換
- [ ] 語言選擇持久化

#### ✅ 導航測試
- [ ] 返回按鈕功能
- [ ] 跨頁面語言保持
- [ ] 頁面標題翻譯
- [ ] 鏈接正確性

#### ✅ 響應式測試
- [ ] 桌面瀏覽器 (Chrome, Firefox, Safari, Edge)
- [ ] 平板設備 (iPad, Android 平板)
- [ ] 手機設備 (iPhone, Android 手機)
- [ ] 不同屏幕尺寸

#### ✅ 性能測試
- [ ] 頁面加載速度
- [ ] 語言切換響應時間
- [ ] 內存使用情況
- [ ] 緩存效果

### 調試工具

#### 1. PHP 錯誤日誌
```php
// 啟用錯誤顯示
ini_set('display_errors', 1);
error_reporting(E_ALL);
```

#### 2. 語言檢測調試
```php
// 在頁面中添加調試信息
echo "Current Language: " . $languageManager->getCurrentLanguage();
echo "Available Languages: " . implode(', ', $languageManager->getSupportedLanguages());
```

## 🔧 高級配置

### 添加新語言支持

#### 1. 創建新語言文件
```php
// languages/ja.php (日文示例)
<?php
$lang = array(
    'page_title_main' => 'Cacti (tm) ドキュメント',
    // ... 其他翻譯
);
?>
```

#### 2. 更新語言管理器
```php
// 在 LanguageManager 類中添加
private $supportedLanguages = array('en', 'zh-cn', 'zh-tw', 'ja');
private $languageNames = array(
    'en' => 'English',
    'zh-cn' => '简体中文', 
    'zh-tw' => '繁體中文',
    'ja' => '日本語'
);
```

### 自定義語言檢測邏輯

修改 `LanguageManager` 類中的 `detectLanguage` 方法：
```php
private function detectLanguage() {
    // 自定義檢測邏輯
    // 1. URL 參數
    // 2. Cookie
    // 3. Session  
    // 4. 用戶設置
    // 5. 瀏覽器語言
    // 6. 默認語言
}
```

## 📊 系統優勢

### 與即時翻譯系統對比

| 特性 | PHP 語言系統 | 即時翻譯系統 |
|------|-------------|-------------|
| **翻譯準確性** | ⭐⭐⭐⭐⭐ 完全準確 | ⭐⭐⭐ 依賴字典匹配 |
| **內容管理** | ⭐⭐⭐⭐⭐ 直接編輯PHP文件 | ⭐⭐ 需要修改JS字典 |
| **性能** | ⭐⭐⭐⭐⭐ 服務器端渲染 | ⭐⭐⭐ 客戶端處理 |
| **SEO 友好** | ⭐⭐⭐⭐⭐ 完全支持 | ⭐⭐ 動態內容不利SEO |
| **維護性** | ⭐⭐⭐⭐⭐ 結構化管理 | ⭐⭐⭐ 需要技術知識 |
| **擴展性** | ⭐⭐⭐⭐⭐ 易於添加語言 | ⭐⭐⭐ 需要修改核心代碼 |

### 主要優勢

#### ✅ **完全控制**
- 每個翻譯都可以精確控制
- 支持複雜的語言結構
- 可以處理上下文相關的翻譯

#### ✅ **專業品質**
- 服務器端渲染，SEO 友好
- 快速的頁面加載速度
- 專業的多語言網站架構

#### ✅ **易於維護**
- 清晰的文件結構
- 直觀的翻譯管理
- 版本控制友好

#### ✅ **高度可定制**
- 完全的樣式控制
- 靈活的語言檢測邏輯
- 可擴展的功能架構

## 🚨 故障排除

### 常見問題

#### 1. 頁面顯示 PHP 代碼
**原因**: Web 服務器未正確配置 PHP
**解決方案**: 
- 確保安裝了 PHP
- 配置 Web 服務器支持 PHP
- 檢查文件擴展名為 .php

#### 2. 語言切換不工作
**原因**: Cookie 或 Session 問題
**解決方案**:
- 檢查瀏覽器 Cookie 設置
- 確保 PHP Session 正常工作
- 檢查文件權限

#### 3. 翻譯內容不顯示
**原因**: 語言文件路徑或語法錯誤
**解決方案**:
- 檢查語言文件路徑
- 驗證 PHP 語法
- 確認翻譯鍵存在

#### 4. 樣式顯示異常
**原因**: CSS 文件路徑問題
**解決方案**:
- 檢查 CSS 文件路徑
- 確認 Web 服務器可以訪問 CSS 文件
- 檢查瀏覽器緩存

## 📞 技術支持

### 獲取幫助
1. **檢查文檔** - 仔細閱讀本指南
2. **查看日誌** - 檢查 PHP 錯誤日誌
3. **測試環境** - 在不同環境中測試
4. **檢查配置** - 驗證所有配置設置

### 維護建議
- **定期備份** - 備份語言文件和配置
- **測試更新** - 在測試環境中驗證更改
- **監控性能** - 定期檢查系統性能
- **更新翻譯** - 根據用戶反饋更新翻譯

---

## 🏆 總結

這個基於 PHP 的多語言系統為 Cacti 文檔提供了專業級的多語言支持。通過將翻譯內容存儲在 PHP 文件中，系統提供了更好的控制性、維護性和擴展性。

**立即開始**: 運行 `convert_to_multilingual.bat` 並享受專業的多語言文檔體驗！🚀
