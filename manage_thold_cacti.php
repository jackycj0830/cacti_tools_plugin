<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && isset($_POST['password'])) {
    $action = $_POST['action'];
    $password = $_POST['password'];
    $cmd = '';
    // 指令對應
    switch ($action) {
        case 'restart_thold':
            $cmd = 'systemctl restart thold';
            break;
        case 'enable_thold':
            $cmd = 'systemctl enable thold && systemctl start thold';
            break;
        case 'disable_thold':
            $cmd = 'systemctl disable thold && systemctl stop thold';
            break;
        case 'restart_cacti':
            $cmd = 'reboot now';
            break;
        default:
            $cmd = '';
    }
    if ($cmd !== '') {
        $full_cmd = 'echo ' . escapeshellarg($password) . ' | sudo -S ' . $cmd . ' 2>&1';
        $output = shell_exec($full_cmd);
        echo "<pre>" . htmlspecialchars($output) . "</pre>";
    } else {
        echo "Unknown operation.";
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Thold / Cacti Service Management</title>
    <style>
        .btn-action { margin: 10px; padding: 8px 20px; font-size: 15px; }
        #output { margin-top: 30px; background: #f9f9f9; padding: 16px; border: 1px solid #aaa; min-height: 50px;}
        #password-dialog { display: none; position: fixed; left:0; top:0; right:0; bottom:0; background: rgba(0,0,0,0.3);}
        #password-box { background: #fff; margin: 100px auto; width: 320px; padding: 24px 24px 16px 24px; border-radius: 8px; box-shadow:0 0 10px #aaa;}
        #password-box input[type="password"]{width: 90%; padding:6px;}
        #password-box button{margin: 6px;}
    </style>
</head>
<body>
    <h3>Thold / Cacti Service Management</h3>
    <button class="btn-action" onclick="manage('restart_thold')">Restart Thold Service</button>
    <button class="btn-action" onclick="manage('enable_thold')">Enable Thold Service</button>
    <button class="btn-action" onclick="manage('disable_thold')">Disable Thold Service</button>
    <button class="btn-action" onclick="manage('restart_cacti')">Reboot Cacti System</button>

    <div id="output">Please select an action above to execute.</div>

    <!-- 密碼輸入對話框 -->
    <div id="password-dialog">
        <div id="password-box">
            <div><b>Please enter sudo password:</b></div>
            <input type="password" id="sudo-password" autocomplete="off" />
            <button onclick="submitPassword()">OK</button>
            <button onclick="closePasswordDialog()">Cancel</button>
        </div>
    </div>

    <script>
        let pendingAction = null;

        function manage(action) {
            pendingAction = action;
            document.getElementById('sudo-password').value = '';
            document.getElementById('password-dialog').style.display = 'block';
            document.getElementById('sudo-password').focus();
        }

        function closePasswordDialog() {
            document.getElementById('password-dialog').style.display = 'none';
            pendingAction = null;
        }

        function submitPassword() {
            var password = document.getElementById('sudo-password').value;
            closePasswordDialog();
            var formData = new FormData();
            formData.append('action', pendingAction);
            formData.append('password', password);

            fetch(window.location.href, {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(html => { document.getElementById('output').innerHTML = html; })
            .catch(err => { document.getElementById('output').innerHTML = 'Error: ' + err; });
        }
    </script>
</body>
</html>
