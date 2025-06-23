#!/bin/bash

# 設置日誌存放的本地目錄
LOG_DIR="/var/www/html/remote_logs"
BACKUP_DIR="$LOG_DIR/BAK"

# 定義變量
SUDO_PASSWORD='4rfvBGT%654'

# 確保目錄存在
mkdir -p "$LOG_DIR/log"
mkdir -p "$BACKUP_DIR"

# 定義日期格式
TODAY=$(date +"%Y-%m-%d")
TARGET_BACKUP_DIR="$BACKUP_DIR/$TODAY"

# 確保備份目錄存在
mkdir -p "$TARGET_BACKUP_DIR"

# 保存現有的日誌文件到備份目錄
echo "開始備份現有的日誌文件到 $TARGET_BACKUP_DIR"
if [ -d "$LOG_DIR/log" ]; then
    cp -r "$LOG_DIR/log/"* "$TARGET_BACKUP_DIR" 2>/dev/null
    echo "日誌文件已備份到 $TARGET_BACKUP_DIR"
else
    echo "日誌目錄 $LOG_DIR/log 不存在，跳過備份步驟"
fi

# 清理超過 7 天的備份
echo "開始清理超過 7 天的備份資料..."
find "$BACKUP_DIR" -mindepth 1 -maxdepth 1 -type d -mtime +7 -exec rm -rf {} \;
echo "清理完成"

# 定義每台主機的日誌同步（主機名稱、SSH 資訊、遠端日誌路徑）
declare -A HOSTS=(
    ["GIOS"]="root@172.17.32.18 /var/log/cacti/cacti.log '4rfvBGT%654'"
    ["XM"]="root@172.16.144.158 /var/log/cacti/cacti.log 'Nkdj19748*'"
    ["FQ"]="root@172.16.30.86 /var/log/cacti/cacti.log 'FqCacti086%'"
    ["TP"]="root@172.16.0.8 /var/log/cacti/cacti.log 'Ej04ru,6@1643'"
    ["GZ"]="root@172.26.61.62 /var/log/cacti/cacti.log 'Rumburak#55'"
    ["BRMAO"]="root@172.31.111.19 /var/log/cacti/cacti.log '4rfvBGT%654'"
    ["QD"]="root@172.16.223.77 /var/log/cacti/cacti.log '4rfvBGT%654'"
)

# 使用 sshpass 抓取日誌文件
for HOST_NAME in "${!HOSTS[@]}"; do
    # 解析主機配置
    IFS=' ' read -r SSH_USER_HOST REMOTE_PATH SSH_PASSWORD <<< "${HOSTS[$HOST_NAME]}"
    LOCAL_FILE="$LOG_DIR/log/cacti_${HOST_NAME}.log"

    # 提取主機 IP 或域名
    HOST=$(echo "$SSH_USER_HOST" | awk -F'@' '{print $2}')

    # 確保主機鍵值在 known_hosts 中
    echo "檢查主機 $HOST 的指紋..."
    ssh-keygen -F "$HOST" > /dev/null 2>&1
    if [ $? -ne 0 ]; then
        echo "添加主機 $HOST 的指紋到 known_hosts..."
        ssh-keyscan -H "$HOST" >> ~/.ssh/known_hosts 2>/dev/null
    fi

    echo "調試信息："
    echo "主機: $SSH_USER_HOST"
    echo "遠端路徑: $REMOTE_PATH"
    echo "本地文件: $LOCAL_FILE"
    echo "密碼: $SSH_PASSWORD"

    # 構造 SCP 指令
    SCP_COMMAND="sshpass -p $SSH_PASSWORD scp $SSH_USER_HOST:$REMOTE_PATH $LOCAL_FILE"

    # 打印 SCP 指令
    echo "執行 SCP 指令：$SCP_COMMAND"

    # 通過 sudo 執行 SCP 命令
    echo "$SUDO_PASSWORD" | sudo -S bash -c "$SCP_COMMAND"

    if [ $? -eq 0 ]; then
        echo "同步 $HOST_NAME 成功，文件已覆蓋保存到 $LOCAL_FILE"
    else
        echo "同步 $HOST_NAME 失敗" >&2
    fi
done
