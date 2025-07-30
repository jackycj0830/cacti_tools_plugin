# Cacti Tools 多語言版本部署指南

## 更新內容概述

本次更新為 Cacti Tools 添加了完整的多語言支援，包括：
- 英文（預設）
- 簡體中文
- 繁體中文

## 主要改進

### 1. 用戶界面改進
- ✅ 右上角語言選擇器
- ✅ 左上角返回按鈕
- ✅ 響應式設計支援
- ✅ 語言偏好本地存儲

### 2. 已更新的頁面
- ✅ `index.php` - 主頁面和導航
- ✅ `home.php` - 首頁
- ✅ `view_logs_realtime_status.php` - 即時日誌狀態
- ✅ `documentation.php` - 知識庫
- ✅ `logs_content_kb.php` - 日誌內容知識庫
- ✅ `rrd_viewer.php` - RRD 檔案瀏覽器
- ✅ `documents.php` - 文件瀏覽器
- ✅ `view_logs_localflie_check.php` - 備份日誌檢查（部分更新）

### 3. 新增文件
- ✅ `includes/lang_nav.php` - 多語言和導航組件
- ✅ `test_lang.php` - 語言功能測試頁面
- ✅ `MULTILANG_README.md` - 多語言使用說明
- ✅ `DEPLOYMENT_GUIDE.md` - 本部署指南

## 部署步驟

### 1. 備份現有文件
在部署前，建議備份以下重要文件：
```bash
cp index.php index.php.backup
cp home.php home.php.backup
# ... 其他重要文件
```

### 2. 創建必要目錄
確保 `includes` 目錄存在：
```bash
mkdir -p includes
```

### 3. 文件權限
確保所有 PHP 文件具有適當的讀取權限：
```bash
chmod 644 *.php
chmod 644 includes/*.php
```

### 4. 測試功能
1. 訪問 `index.php` 確認主頁面正常載入
2. 測試語言切換功能
3. 訪問 `test_lang.php` 進行語言功能測試
4. 檢查各個功能頁面是否正常工作

## 兼容性檢查

### 瀏覽器要求
- Chrome 60+
- Firefox 55+
- Safari 12+
- Edge 79+

### 服務器要求
- PHP 7.0+
- 支援 `file_get_contents()` 和 `realpath()` 函數

## 故障排除

### 常見問題

1. **語言切換不工作**
   - 檢查 `includes/lang_nav.php` 是否存在
   - 確認瀏覽器支援 localStorage
   - 檢查 JavaScript 控制台錯誤

2. **頁面樣式異常**
   - 確認 CSS 樣式正確載入
   - 檢查瀏覽器緩存

3. **返回按鈕不工作**
   - 確認 JavaScript 正常執行
   - 檢查瀏覽器歷史記錄

### 調試步驟

1. 開啟瀏覽器開發者工具
2. 檢查 Console 標籤是否有錯誤
3. 檢查 Network 標籤確認文件正常載入
4. 檢查 Application > Local Storage 確認語言設定保存

## 回滾計劃

如果需要回滾到舊版本：

1. 恢復備份文件：
```bash
cp index.php.backup index.php
cp home.php.backup home.php
# ... 其他文件
```

2. 移除新增文件：
```bash
rm -rf includes/
rm test_lang.php
rm MULTILANG_README.md
rm DEPLOYMENT_GUIDE.md
```

## 後續開發建議

### 1. 待更新頁面
以下頁面尚未完全更新多語言支援，建議後續處理：
- `logs_content_kb_update.php`
- `main.php`
- `manage_thold_cacti.php`
- `rrd_graph_viewer.php`
- `setup.php`
- `tools.php`
- `updater.php`

### 2. 功能增強
- 添加更多語言支援
- 改進語言檢測（基於瀏覽器語言）
- 添加語言切換動畫效果
- 實現服務器端語言配置

### 3. 性能優化
- 壓縮 JavaScript 代碼
- 優化 CSS 載入
- 實現語言包懶加載

## 聯絡資訊

如有問題或建議，請聯絡：
- 開發者：Jacky Zou
- 郵箱：jacky.zou@tpv-tech.com
- 團隊：TPV IT Global Infrastructure Team

## 版本資訊

- 版本：v1.0.2 多語言版
- 更新日期：2025-01-30
- 兼容性：向後兼容 v1.0.1
