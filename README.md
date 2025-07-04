# Cacti Tools - 現代化企業數位工具平台

Cacti Tools 是一套現代化、模組化的企業數位工具平台，專為提升企業運營效率、數據整合與智能決策而設計。平台結合最新 Web 技術，提供響應式、直觀且智能化的用戶體驗，並支援 AI 輔助功能與高度擴展性。

---

## 🎯 專案目標

- **整合性**：統一管理企業多元數位工具與業務流程
- **現代化**：採用最新 Web 技術，提供優秀用戶體驗
- **智能化**：整合 AI 功能，支援智能搜尋與數據分析
- **模組化**：可擴展的模組設計，靈活滿足企業成長需求
- **安全性**：完善的權限控管與數據安全保護

---

## 🚀 核心功能

### 🏠 儀表板總覽
- 即時顯示關鍵業務指標（如任務進度、資源分配、數據分析等）
- 可自定義的數據視覺化圖表
- 業務趨勢分析與預警提醒

### 📁 工具模組管理
- 工具註冊與分類：集中管理各類企業工具（如專案管理、文件協作、流程自動化等）
- 模組啟用/停用：依需求彈性調整工具組合
- 權限分配：細緻控制各部門/用戶的工具存取權限

### 🔍 智能數據探索
- AI 智能搜尋：結合生成式 AI，提供智能查詢建議
- 自然語言查詢：支援中文自然語言業務查詢
- 智能報表推薦：根據用戶需求推薦適合的數據報表

### 🛡️ 安全認證系統
- JWT Token 認證機制
- 角色基礎訪問控制（RBAC）
- 操作日誌記錄

---

## 🛠️ 技術架構

### 前端技術
- **框架**：Next.js 15 (App Router) + React 18
- **語言**：TypeScript
- **UI 組件**：ShadCN UI
- **圖標**：Lucide React
- **樣式**：Tailwind CSS

### 後端與數據
- **API**：Next.js API Routes
- **資料庫**：SQLite（開發）/ PostgreSQL（生產）
- **ORM**：Prisma
- **認證**：JWT Token + bcrypt 密碼加密

### AI 與智能功能
- **AI 平台**：Firebase Genkit
- **AI 模型**：Google AI (Gemini)
- **自然語言處理**：支援中文業務查詢

### 狀態管理與表單
- **狀態管理**：Zustand + React Context API
- **表單處理**：React Hook Form
- **數據驗證**：Zod

### 開發與測試
- **測試框架**：Jest + React Testing Library
- **代碼品質**：ESLint + Prettier
- **版本控制**：Git + GitHub

---

## 📂 目錄結構概覽

```
/
├── src/
│   ├── app/                     # Next.js App Router: Pages and layouts
│   │   ├── dashboard/           # 儀表板頁面
│   │   ├── tools/               # 工具模組頁面
│   │   ├── smart-search/        # 智能搜尋頁面
│   │   ├── login/               # 登入頁面
│   │   ├── globals.css          # 全域樣式與 ShadCN 主題
│   │   ├── layout.tsx           # 根佈局
│   │   └── page.tsx             # 首頁
│   ├── components/              # 可重用 UI 元件
│   │   ├── layout/              # 佈局相關元件
│   │   ├── ui/                  # ShadCN UI 元件
│   │   └── smart-search-form.tsx # 智能搜尋 UI
│   ├── context/                 # React Context 提供者
│   ├── hooks/                   # 自訂 React hooks
│   ├── lib/                     # 工具函式與伺服器 actions
│   ├── ai/                      # Genkit AI 整合
│   │   ├── flows/               # AI 流程定義
│   │   ├── dev.ts               # Genkit 開發伺服器
│   │   └── genkit.ts            # Genkit 初始化
│   └── middleware.ts            # Next.js middleware
├── public/                      # 靜態資源
├── .env                         # 環境變數
├── components.json              # ShadCN UI 設定
├── next.config.ts               # Next.js 設定
├── package.json                 # 專案依賴與腳本
├── tailwind.config.ts           # Tailwind CSS 設定
├── tsconfig.json                # TypeScript 設定
└── README.md                    # 本文件
```

---

## 🚀 快速開始

### 📋 系統需求

- Node.js: v18.x 或更高版本
- 包管理器: npm、yarn 或 pnpm
- 瀏覽器: Chrome、Firefox、Safari、Edge（最新版）
- 記憶體: 建議 4GB 以上
- 硬碟空間: 至少 1GB 可用空間

### 📦 安裝步驟

1. **克隆專案**
   ```sh
   git clone https://github.com/jackycj0830/cacti-tools.git
   cd cacti-tools
   ```

2. **安裝依賴**
   ```sh
   npm install
   # 或
   yarn install
   # 或
   pnpm install
   ```

3. **環境變數設定**
   建立 `.env.local` 並設定必要環境變數：
   ```
   # Google AI API 金鑰（智能搜尋功能）
   GOOGLE_API_KEY=your_google_api_key_here

   # 資料庫連線（預設 SQLite）
   DATABASE_URL="file:./dev.db"

   # JWT 密鑰（認證用）
   JWT_SECRET=your_jwt_secret_here
   ```

### 🏃‍♂️ 運行應用

- 啟動開發伺服器
  ```sh
  npm run dev
  ```
  應用將於 http://localhost:9002 啟動

- 啟動 AI 服務（可選）
  ```sh
  npm run genkit:dev
  # 或監聽檔案變化
  npm run genkit:watch
  ```
  Genkit 服務將於 http://localhost:4000 啟動

### 🔑 登入資訊

- 內建演示帳號：
  - 用戶名: admin
  - 密碼: 123456

### 🗄️ 資料庫初始化

- 首次運行時自動建立 SQLite 資料庫
- 重置資料庫：
  ```sh
  npm run db:reset
  ```
  或手動刪除 `dev.db` 後重啟

### 🏗️ 生產環境部署

- 建置應用
  ```sh
  npm run build
  ```
- 啟動生產服務
  ```sh
  npm run start
  ```
- Docker 部署（可選）
  ```sh
  docker build -t cacti-tools .
  docker run -p 3000:3000 cacti-tools
  ```

- 生產環境需設定以下環境變數：
  ```
  NODE_ENV=production
  DATABASE_URL=postgresql://user:password@host:port/database
  GOOGLE_API_KEY=your_production_api_key
  JWT_SECRET=your_strong_jwt_secret
  ```

---

## 🎨 Styling Guidelines

- 主色：藍色 (#4681C4) - HSL: 205 65% 50%
- 背景色：淺灰 (#F0F4F8) - HSL: 220 25% 97%
- 強調色：藍綠 (#3E8A8A) - HSL: 175 50% 45%
- 標題字型：'Poppins', sans-serif
- 內文字型：'PT Sans', sans-serif

> 這些已於 `src/app/globals.css` 以 HSL CSS 變數設定，並用於 ShadCN UI 主題。

---

## 🤝 貢獻指南

1. Fork 專案
2. 建立功能分支（`git checkout -b feature/AmazingFeature`）
3. 依照開發規範與 `spec.md` 進行開發
4. 每次修改前確認規格文件
5. 完成後更新 `todolist.md`
6. 提交變更（`git commit -m 'Add some AmazingFeature'`）
7. 推送分支（`git push origin feature/AmazingFeature`）
8. 建立 Pull Request

### 開發規範

- 遵循 TypeScript 與 ESLint 規則
- 為新功能撰寫單元測試
- 更新相關文件
- 保持代碼整潔與註釋完整

---

## 📄 授權條款

本專案採用 MIT 授權條款 - 詳見 LICENSE 文件

---

## 📞 聯絡資訊

- 專案維護者: Jacky Zou
- GitHub: [@jackycj0830](https://github.com/jackycj0830)
- 專案連結: https://github.com/jackycj0830/cacti-tools

---

## 🙏 致謝

感謝以下開源專案的支持：

- Next.js
- ShadCN UI
- Tailwind CSS
- Firebase Genkit

⭐ 如果這個專案對您有幫助，請給我們一個 Star！

---

## ✅ 任務清單進度

- [x] 專案架構規劃與框架比較
- [ ] 撰寫完整 spec.md
- [ ] 撰寫 UML 圖
- [ ] 撰寫單元測試規劃
- [ ] 初始化專案程式碼
- [ ] 撰寫自動化單元測試
- [x] 完成 README.md
