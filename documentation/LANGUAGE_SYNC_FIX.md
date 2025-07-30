# 語言同步問題修復說明

## 問題描述
用戶反映語言選擇器只在當前頁面生效，切換到其他頁面時語言不會聯動翻譯。

## 問題分析
經過分析，主要問題包括：

1. **初始化順序問題** - 頁面加載時沒有正確檢查和應用保存的語言設置
2. **事件處理不一致** - 不同頁面的語言切換處理邏輯不統一
3. **缺少調試信息** - 難以診斷語言同步失敗的原因
4. **函數調用不正確** - 某些頁面沒有正確調用語言設置函數

## 已實施的修復

### 1. 改進 i18n.js 核心功能
- ✅ 添加詳細的調試日誌
- ✅ 改進 `loadLanguage()` 函數，確保完整的語言加載流程
- ✅ 增強 `setLanguage()` 函數，包含存儲事件觸發
- ✅ 添加 `updatePageTitle()` 函數自動更新頁面標題

### 2. 改進 common.js 通用功能
- ✅ 統一 `changeLanguage()` 函數實現
- ✅ 改進 `initializeLanguage()` 函數，添加存儲事件監聽
- ✅ 添加跨標籤頁/框架同步支持

### 3. 更新所有頁面的初始化邏輯
- ✅ documentation.html - 主文檔頁面
- ✅ Requirements.html - 系統要求頁面
- ✅ Table-of-Contents.html - 目錄頁面
- ✅ test-multilingual.html - 測試頁面

### 4. 創建調試工具
- ✅ debug-multilingual.html - 調試頁面，包含詳細的狀態監控

## 修復後的工作流程

### 頁面加載時：
1. 載入 i18n.js 和 common.js
2. DOM 加載完成後觸發 DOMContentLoaded 事件
3. 調用 `initializeLanguage()` 函數
4. 從 localStorage 讀取保存的語言設置
5. 應用翻譯到所有帶有 `data-i18n` 屬性的元素
6. 更新語言選擇器的值
7. 設置存儲事件監聽器

### 語言切換時：
1. 用戶點擊語言選擇器
2. 觸發 `changeLanguage()` 函數
3. 調用 `setLanguage()` 函數
4. 保存語言設置到 localStorage
5. 應用翻譯到當前頁面
6. 觸發存儲事件（用於跨頁面同步）
7. 更新頁面標題

### 跨頁面同步：
1. 當 localStorage 中的語言設置改變時
2. 觸發 storage 事件
3. 其他頁面監聽到事件後自動更新語言
4. 重新應用翻譯

## 測試步驟

### 基本功能測試：
1. 打開 `debug-multilingual.html` 頁面
2. 觀察調試面板中的狀態信息
3. 測試語言切換功能
4. 檢查控制台日誌

### 跨頁面同步測試：
1. 在一個頁面選擇語言（如中文）
2. 導航到另一個頁面
3. 確認新頁面自動顯示為中文
4. 檢查語言選擇器是否正確顯示當前語言

### iframe 環境測試：
1. 在 Cacti Tools Plugin 的 iframe 中測試
2. 確認語言切換在 iframe 環境中正常工作
3. 檢查是否有沙盒限制影響功能

## 故障排除

### 如果語言仍然不同步：

1. **檢查控制台錯誤**
   ```javascript
   // 打開瀏覽器開發者工具，查看控制台是否有錯誤
   ```

2. **檢查 localStorage**
   ```javascript
   // 在控制台執行：
   console.log(localStorage.getItem('selectedLanguage'));
   ```

3. **檢查函數是否正確載入**
   ```javascript
   // 在控制台執行：
   console.log(typeof setLanguage);
   console.log(typeof loadLanguage);
   console.log(typeof initializeLanguage);
   ```

4. **手動測試語言設置**
   ```javascript
   // 在控制台執行：
   setLanguage('zh-cn');
   ```

### 常見問題和解決方案：

1. **JavaScript 文件載入失敗**
   - 檢查文件路徑是否正確
   - 確認 js/ 目錄存在且包含必要文件

2. **localStorage 被禁用**
   - 檢查瀏覽器設置
   - 確認不是在隱私模式下瀏覽

3. **iframe 沙盒限制**
   - 確認 iframe 的 sandbox 屬性包含 `allow-scripts` 和 `allow-same-origin`

4. **緩存問題**
   - 強制刷新頁面（Ctrl+F5）
   - 清除瀏覽器緩存

## 驗證修復是否成功

### 成功標準：
- ✅ 在任何頁面選擇語言後，所有其他頁面都會自動切換到相同語言
- ✅ 頁面刷新後語言設置保持不變
- ✅ 語言選擇器始終顯示正確的當前語言
- ✅ 頁面標題會根據語言自動更新
- ✅ 在 iframe 環境中功能正常

### 測試清單：
- [ ] 主文檔頁面語言切換正常
- [ ] Requirements 頁面語言切換正常
- [ ] Table of Contents 頁面語言切換正常
- [ ] 測試頁面語言切換正常
- [ ] 跨頁面語言同步正常
- [ ] 頁面刷新後語言保持
- [ ] iframe 環境中功能正常
- [ ] 調試頁面顯示正確狀態

## 後續改進建議

1. **批量更新其他頁面** - 使用提供的批處理腳本更新所有剩餘的 HTML 文件
2. **添加更多翻譯** - 為重要頁面添加完整的翻譯內容
3. **性能優化** - 考慮延遲加載翻譯內容
4. **用戶體驗改進** - 添加語言切換動畫效果
5. **自動檢測** - 基於瀏覽器語言自動選擇初始語言

## 聯繫支持

如果問題仍然存在，請：
1. 使用 debug-multilingual.html 頁面收集詳細信息
2. 檢查瀏覽器控制台的錯誤信息
3. 提供具體的重現步驟和環境信息
