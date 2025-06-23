<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>安裝 sshpass 工具說明</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }
        h1, h2, h3 {
            color: #333;
        }
        pre {
            background: #f4f4f4;
            padding: 10px;
            border: 1px solid #ddd;
            overflow-x: auto;
        }
        code {
            background: #f4f4f4;
            padding: 2px 4px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <h1>安裝 <code>sshpass</code> 的中文說明文件</h1>
    <hr>
    <h2>安裝 <code>sshpass</code> 工具</h2>
    <h3>安裝步驟</h3>
    <ol>
        <li>打開終端機（Terminal）。</li>
        <li>執行以下命令以安裝 <code>sshpass</code>：</li>
    </ol>
    <pre><code>sudo yum install sshpass</code></pre>
    <h3>安裝過程</h3>
    <pre><code>Last metadata expiration check: 1:22:01 ago on Wed 15 Jan 2025 09:30:43 AM CST.
Dependencies resolved.
================================================================================
 Package         Architecture   Version             Repository             Size
================================================================================
Installing:
 sshpass         x86_64         1.09-4.el9          ol9_appstream          33 k

Transaction Summary
================================================================================
Install  1 Package

Total download size: 33 k
Installed size: 47 k
Is this ok [y/N]:y

Downloading Packages:
sshpass-1.09-4.el9.x86_64.rpm                   162 kB/s |  33 kB     00:00
--------------------------------------------------------------------------------
Total                                           161 kB/s |  33 kB     00:00
Running transaction check
Transaction check succeeded.
Running transaction test
Transaction test succeeded.
Running transaction
    Preparing        :                                                        1/1
    Installing       : sshpass-1.09-4.el9.x86_64                              1/1
    Running scriptlet: sshpass-1.09-4.el9.x86_64                              1/1
    Verifying        : sshpass-1.09-4.el9.x86_64                              1/1

Installed:
    sshpass-1.09-4.el9.x86_64

Complete!</code></pre>
    <h3>將 Tools 資料夾透過 WinSCP 複製到 <code>/var/www/html/</code> 下</h3>
    <h3>設定 Crontab 任務</h3>
    <ol>
        <li>編輯 Crontab 文件：</li>
    </ol>
    <pre><code>crontab -e</code></pre>
    <ol start="2">
        <li>在 Crontab 文件中添加以下行以設置定時任務：</li>
    </ol>
    <pre><code>0 3 * * * root /var/www/html/remote_logs/cacti_log_sync.sh</code></pre>
    <h3>使用 <code>sshpass</code> 進行 SCP 操作</h3>
    <ol>
        <li>使用 <code>sshpass</code> 從遠程伺服器複製文件：</li>
    </ol>
    <pre><code>sshpass -p '4rfvBGT%654' scp root@172.20.2.35:/var/log/cacti/cacti.log /var/www/html/tools/cacti_GIXM.log</code></pre>
    <ol start="2">
        <li>再次執行同步腳本：</li>
    </ol>
    <pre><code>sudo /var/www/html/tools/cacti_log_sync.sh</code></pre>
    <ol start="3">
        <li>使用 <code>sshpass</code> 從另一個遠程伺服器複製文件：</li>
    </ol>
    <pre><code>sshpass -p '4rfvBGT%654' scp root@172.17.32.18:/var/log/cacti/cacti.log /var/www/html/tools/cacti_GIOS.log</code></pre>
    <ol start="4">
        <li>列出目錄內容以確認文件已同步：</li>
    </ol>
    <pre><code>ls -ld /var/www/html/remote_logs</code></pre>
    <hr>
    <h1>Install <code>sshpass</code> Tool</h1>
    <h2>Installation Steps</h2>
    <ol>
        <li>Open the terminal.</li>
        <li>Run the following command to install <code>sshpass</code>:</li>
    </ol>
    <pre><code>sudo yum install sshpass</code></pre>
    <h2>Installation Process</h2>
    <pre><code>Last metadata expiration check: 1:22:01 ago on Wed 15 Jan 2025 09:30:43 AM CST.
Dependencies resolved.
================================================================================
 Package         Architecture   Version             Repository             Size
================================================================================
Installing:
 sshpass         x86_64         1.09-4.el9          ol9_appstream          33 k

Transaction Summary
================================================================================
Install  1 Package

Total download size: 33 k
Installed size: 47 k
Is this ok [y/N]:y

Downloading Packages:
sshpass-1.09-4.el9.x86_64.rpm                   162 kB/s |  33 kB     00:00
--------------------------------------------------------------------------------
Total                                           161 kB/s |  33 kB     00:00
Running transaction check
Transaction check succeeded.
Running transaction test
Transaction test succeeded.
Running transaction
    Preparing        :                                                        1/1
    Installing       : sshpass-1.09-4.el9.x86_64                              1/1
    Running scriptlet: sshpass-1.09-4.el9.x86_64                              1/1
    Verifying        : sshpass-1.09-4.el9.x86_64                              1/1

Installed:
    sshpass-1.09-4.el9.x86_64

Complete!</code></pre>
    <h2>Setting Up Crontab Task</h2>
    <ol>
        <li>Edit the Crontab file:</li>
    </ol>
    <pre><code>crontab -e</code></pre>
    <ol start="2">
        <li>Add the following line to the Crontab file to set up a scheduled task:</li>
    </ol>
    <pre><code>0 3 * * * root /var/www/html/remote_logs/cacti_log_sync.sh</code></pre>
    <h2>Using <code>sshpass</code> for SCP Operations</h2>
    <ol>
        <li>Use <code>sshpass</code> to copy files from a remote server:</li>
    </ol>
    <pre><code>sshpass -p '4rfvBGT%654' scp root@172.20.2.35:/var/log/cacti/cacti.log /var/www/html/tools/cacti_GIXM.log</code></pre>
    <ol start="2">
        <li>Run the sync script again:</li>
    </ol>
    <pre><code>sudo /var/www/html/tools/cacti_log_sync.sh</code></pre>
    <ol start="3">
        <li>Use <code>sshpass</code> to copy files from another remote server:</li>
    </ol>
    <pre><code>sshpass -p '4rfvBGT%654' scp root@172.17.32.18:/var/log/cacti/cacti.log /var/www/html/tools/cacti_GIOS.log</code></pre>
    <ol start="4">
        <li>List the directory contents to verify the files have been synced:</li>
    </ol>
    <pre><code>ls -ld /var/www/html/remote_logs</code></pre>
</body>
</html>

