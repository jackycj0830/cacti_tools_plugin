#!/bin/bash

# 設置日誌存放的本地目錄
LOG_DIR="/var/www/html/remote_logs"

# 定义变量
SUDO_PASSWORD='4rfvBGT%654'

# 確保目錄存在
mkdir -p "$LOG_DIR"

# 定義每台主機的日誌同步（主機名稱、SSH 資訊、遠端日誌路徑）
declare -A HOSTS=(
    ["GIOS"]="root@172.17.32.18 /var/log/cacti/cacti.log '4rfvBGT%654'"
    # ["GIXM"]="root@172.20.2.35 /var/log/cacti/cacti.log '4rfvBGT%654'"
    ["XM"]="root@172.16.144.158 /var/log/cacti/cacti.log 'Nkdj19748*'"
    ["FQ"]="root@172.16.30.86 /var/log/cacti/cacti.log 'FqCacti086%'"
    ["TP"]="root@172.16.0.8 /var/log/cacti/cacti.log 'Ej04ru,6@1643'"
    ["GZ"]="root@172.26.61.62 /var/log/cacti/cacti.log 'Rumburak#55'"
    ["BRMAO"]="root@172.31.111.19 /var/log/cacti/cacti.log '4rfvBGT%654'"
    ["QD"]="root@172.16.223.77 /var/log/cacti/cacti.log '4rfvBGT%654'"
    # 在這裡添加更多主機
)

# 使用 sshpass 抓取日誌文件
for HOST_NAME in "${!HOSTS[@]}"; do
    # 解析主機配置
    IFS=' ' read -r SSH_USER_HOST REMOTE_PATH SSH_PASSWORD <<< "${HOSTS[$HOST_NAME]}"
    LOCAL_FILE="$LOG_DIR/cacti_${HOST_NAME}.log"

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
    # SCP_COMMAND="sshpass -p $SSH_PASSWORD scp -o StrictHostKeyChecking=no '$SSH_USER_HOST:$REMOTE_PATH' '$LOCAL_FILE'"
    SCP_COMMAND="sshpass -p $SSH_PASSWORD scp $SSH_USER_HOST:$REMOTE_PATH $LOCAL_FILE"

    # 打印 SCP 指令
    echo "執行 SCP 指令：$SCP_COMMAND"

    # 通过 sudo 执行 SCP 命令
    echo "$SUDO_PASSWORD" | sudo -S bash -c "$SCP_COMMAND"

    if [ $? -eq 0 ]; then
        echo "同步 $HOST_NAME 成功，文件已覆蓋保存到 $LOCAL_FILE"
    else
        echo "同步 $HOST_NAME 失敗" >&2
    fi
done
