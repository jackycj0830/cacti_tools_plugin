-- --------------------------------------------------------
-- 新增的 MySQL 資料表結構 (遷移自舊的反覆運算 SQLite `vt_cache.db`)
-- --------------------------------------------------------

-- 1. faz_raw_events: 用於記錄原始的每一次登入失敗日誌，做為計算連線次數的基礎。
CREATE TABLE IF NOT EXISTS faz_raw_events (
    ip VARCHAR(45) NOT NULL COMMENT '來源IP位址',
    timestamp DATETIME NOT NULL COMMENT '日誌事件發生的時間',
    UNIQUE KEY unique_ip_ts (ip, timestamp),
    INDEX idx_ts (timestamp)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='FortiAnalyzer VPN 登入失敗原始事件記錄';

-- 2. faz_logs: 單次排程計算結果摘要，將 >= 50 次錯誤的 IP 統計起來做為批次處置依據。
CREATE TABLE IF NOT EXISTS faz_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    run_id VARCHAR(50) NOT NULL COMMENT '執行批次的 UUID',
    ip VARCHAR(45) NOT NULL COMMENT '統計的惡意來源IP',
    count INT NOT NULL COMMENT '登入失敗的總次數',
    first_seen DATETIME NOT NULL COMMENT '該批次內最早發現的時間',
    last_seen DATETIME NOT NULL COMMENT '該批次內最後發現的時間',
    imported_at DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT '匯入時間記錄',
    INDEX idx_run_id (run_id),
    INDEX idx_ip (ip)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='FortiAnalyzer 高頻登入失敗分析摘要';
