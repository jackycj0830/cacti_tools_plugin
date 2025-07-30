<?php
$lang = $_GET['lang'] ?? 'en';
$strings = [
    'en' => [
        'title' => 'Host Real-time Monitor (PHP htop)',
        'cpu_usage' => 'CPU Usage:',
        'cpu_total' => 'CPU Total:',
        'cpu_details' => 'Show CPU Cores',
        'cpu_hide' => 'Hide CPU Cores',
        'mem_usage' => 'Memory Usage:',
        'top_processes' => 'Top 20 Processes:',
        'auto_refresh' => 'Auto-refresh every 10 seconds',
        'pid' => 'PID', 'user' => 'USER', 'pri' => 'PRI', 'ni' => 'NI', 'vsz' => 'VSZ', 'rss' => 'RSS',
        'cpu' => '%CPU', 'mem' => '%MEM', 'time' => 'TIME', 'command' => 'COMMAND', 'countdown' => 'Refresh in',
        'language' => 'Language:',
        'tasks' => 'Tasks',
        'threads' => 'thr',
        'kthreads' => 'kthr',
        'running' => 'running',
        'loadavg' => 'Load average',
        'uptime' => 'Uptime',
        'r10s'=>'10s','r30s'=>'30s','r1m'=>'1 min','r2m'=>'2 min','r3m'=>'3 min','r5m'=>'5 min','manual'=>'Manual'
    ],
    'zh-cn' => [
        'title' => '主机实时状态监控（PHP htop）',
        'cpu_usage' => 'CPU 使用率：',
        'cpu_total' => 'CPU总览：',
        'cpu_details' => '展开CPU核心',
        'cpu_hide' => '收起CPU核心',
        'mem_usage' => '内存使用：',
        'top_processes' => '前20个进程：',
        'auto_refresh' => '每10秒自动刷新一次',
        'pid' => 'PID', 'user' => '用户', 'pri' => '优先', 'ni' => 'NI', 'vsz' => '虚拟内存', 'rss' => '常驻内存',
        'cpu' => 'CPU%', 'mem' => '内存%', 'time' => '运行时间', 'command' => '命令', 'countdown' => '距离刷新',
        'language' => '语言：',
        'tasks' => '任务',
        'threads' => '线程',
        'kthreads' => '内核线程',
        'running' => '运行中',
        'loadavg' => '平均负载',
        'uptime' => '运行时间',
        'r10s'=>'10秒','r30s'=>'30秒','r1m'=>'1分钟','r2m'=>'2分钟','r3m'=>'3分钟','r5m'=>'5分钟','manual'=>'手动'
    ],
    'zh-tw' => [
        'title' => '主機即時狀態監控（PHP htop）',
        'cpu_usage' => 'CPU 使用率：',
        'cpu_total' => 'CPU總覽：',
        'cpu_details' => '展開CPU核心',
        'cpu_hide' => '收合CPU核心',
        'mem_usage' => '記憶體使用：',
        'top_processes' => '前20個進程：',
        'auto_refresh' => '每10秒自動刷新一次',
        'pid' => 'PID', 'user' => '用戶', 'pri' => '優先', 'ni' => 'NI', 'vsz' => '虛擬記憶體', 'rss' => '常駐記憶體',
        'cpu' => 'CPU%', 'mem' => '記憶體%', 'time' => '執行時間', 'command' => '命令', 'countdown' => '距離刷新',
        'language' => '語言：',
        'tasks' => '任務',
        'threads' => '執行緒',
        'kthreads' => '核心執行緒',
        'running' => '執行中',
        'loadavg' => '負載平均',
        'uptime' => '運作時間',
        'r10s'=>'10秒','r30s'=>'30秒','r1m'=>'1分鐘','r2m'=>'2分鐘','r3m'=>'3分鐘','r5m'=>'5分鐘','manual'=>'手動'
    ]
];

// 取得 Tasks, Load Average, Uptime
function getHtopBox() {
    $proc_stat = file_get_contents('/proc/stat');
    preg_match_all('/^procs_running\s+(\d+)/m', $proc_stat, $matches_running);
    $running = $matches_running[1][0] ?? 0;
    $threads = 0; $kthreads = 0;
    foreach (glob('/proc/[0-9]*/task') as $dir) {
        $threads += count(glob($dir . '/*'));
    }
    $proc = shell_exec("ps -eLf | wc -l");
    $tasks = intval($proc) - 1;
    $loadavg = explode(' ', file_get_contents('/proc/loadavg'));
    $load_string = $loadavg[0] . " " . $loadavg[1] . " " . $loadavg[2];
    $uptime = shell_exec("uptime -p");
    if (!$uptime) {
        $uptime_val = explode(" ", trim(file_get_contents('/proc/uptime')))[0];
        $days = floor($uptime_val / 86400);
        $hours = floor(($uptime_val % 86400) / 3600);
        $mins = floor(($uptime_val % 3600) / 60);
        $uptime = "$days days, $hours hours, $mins minutes";
    }
    return [
        'tasks' => $tasks,
        'threads' => $threads,
        'kthreads' => $kthreads,
        'running' => $running,
        'loadavg' => $load_string,
        'uptime' => trim($uptime)
    ];
}

// CPU 使用率
function getCpuUsages() {
    $stat1 = file('/proc/stat');
    usleep(500000);
    $stat2 = file('/proc/stat');
    $cpus = [];
    foreach ($stat1 as $i => $line) {
        if (preg_match('/^cpu[0-9]*/', $line, $matches)) {
            $cpu1 = preg_split('/\s+/', trim($line));
            $cpu2 = preg_split('/\s+/', trim($stat2[$i]));
            $diff = [];
            for ($j = 1; $j < count($cpu1); $j++) {
                $diff[$j] = $cpu2[$j] - $cpu1[$j];
            }
            $total = array_sum($diff);
            $idle = $diff[4] ?? 0;
            $usage = $total > 0 ? (100 - ($idle / $total * 100)) : 0;
            $cpus[] = round($usage, 2);
        }
    }
    return $cpus;
}

// 記憶體
function getMemoryUsage() {
    $data = file_get_contents('/proc/meminfo');
    preg_match('/MemTotal:\s+(\d+)/', $data, $total);
    preg_match('/MemAvailable:\s+(\d+)/', $data, $free);
    $used = $total[1] - $free[1];
    $percent = ($used / $total[1]) * 100;
    return [
        'total' => round($total[1] / 1024, 2),
        'used' => round($used / 1024, 2),
        'free' => round($free[1] / 1024, 2),
        'percent' => round($percent, 2)
    ];
}

// 進程
function getProcessList($limit = 20) {
    $output = [];
    exec("ps -eo pid,user,pri,ni,vsz,rss,pcpu,pmem,time,comm --sort=-pcpu | head -n ".($limit+1), $output);
    return $output;
}

$refresh = isset($_GET['refresh']) ? intval($_GET['refresh']) : 10; // 必須提前放，供JS使用
$cpuUsages = getCpuUsages();
$mem = getMemoryUsage();
$processList = getProcessList();
$htopBox = getHtopBox();
?>

<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
    <meta charset="UTF-8">
    <title><?= $strings[$lang]['title'] ?></title>
    <style>
        body { background: #fff; color: #222; font-family: monospace; margin: 0; padding: 0; }
        .container { padding: 20px; }
        .bar { background: #eee; border: 1px solid #bbb; height: 22px; width: 400px; border-radius: 6px; display: inline-block; vertical-align: middle; margin-right: 6px;}
        .bar-fill { background: #5dbf4b; height: 100%; border-radius: 6px 0 0 6px; display: inline-block;}
        .title { font-size: 1.7em; margin-bottom: 15px; font-weight: bold; }
        .htopbox { background: #f5f7fa; border: 1.5px solid #bbb; border-radius: 6px; padding: 15px; margin-bottom: 22px; display:inline-block; }
        .htopbox span { display: block; font-size: 1.1em; margin-bottom: 4px;}
        table { border-collapse: collapse; width: 100%; background: #fff;}
        th, td { border: 1px solid #ddd; padding: 4px 8px; text-align: left;}
        th { background: #f5f5f5; cursor: pointer;}
        tr:nth-child(even) { background: #fafafa; }
        .lang-bar { margin-bottom: 12px;}
        .cpu-bars { margin-bottom: 10px; }
        .cpu-label { margin-right: 5px; font-size: 1em; }
        .countdown { color: #c00; font-size: 1em; font-weight: bold; margin-left: 15px;}
        .cpu-details { display: none; margin-left: 30px;}
        .toggle-btn { margin: 5px 0 10px 0; padding: 2px 12px; background: #e7e7e7; border: 1px solid #bbb; border-radius: 4px; cursor: pointer;}
        .sorted-asc::after { content: ' ▲'; }
        .sorted-desc::after { content: ' ▼'; }
    </style>
</head>
<body>
    <div class="container">
        <div class="lang-bar">
            <?php
            $refresh_intervals = [
                10 => $strings[$lang]['r10s'],
                30 => $strings[$lang]['r30s'],
                60 => $strings[$lang]['r1m'],
                120 => $strings[$lang]['r2m'],
                180 => $strings[$lang]['r3m'],
                300 => $strings[$lang]['r5m'],
                0 => $strings[$lang]['manual']
            ];
            ?>
            <form id="lang-refresh-form" method="get" style="display:inline;">
                <label><?= $strings[$lang]['language'] ?></label>
                <select id="langsel" name="lang">
                    <option value="en" <?= $lang == 'en' ? 'selected' : '' ?>>English</option>
                    <option value="zh-cn" <?= $lang == 'zh-cn' ? 'selected' : '' ?>>简体中文</option>
                    <option value="zh-tw" <?= $lang == 'zh-tw' ? 'selected' : '' ?>>繁體中文</option>
                </select>
                <label style="margin-left:12px;">Refresh:</label>
                <select id="refreshsel" name="refresh">
                    <?php foreach($refresh_intervals as $sec=>$label): ?>
                    <option value="<?=$sec?>" <?=$refresh==$sec?'selected':''?>><?=$label?></option>
                    <?php endforeach; ?>
                </select>
            </form>
            <span class="countdown">
            <?= $strings[$lang]['countdown'] ?>: <span id="countdown"><?= $refresh ? $refresh.'s':'∞' ?></span>
            </span>
        </div>
        <div class="title"><?= $strings[$lang]['title'] ?></div>
        <!-- htop info box -->
        <div class="htopbox">
            <span><b><?= $strings[$lang]['tasks'] ?>:</b> <?= $htopBox['tasks'] ?>, <?= $htopBox['threads'] ?> <?= $strings[$lang]['threads'] ?>, <?= $htopBox['kthreads'] ?> <?= $strings[$lang]['kthreads'] ?>; <?= $htopBox['running'] ?> <?= $strings[$lang]['running'] ?></span>
            <span><b><?= $strings[$lang]['loadavg'] ?>:</b> <?= $htopBox['loadavg'] ?></span>
            <span><b><?= $strings[$lang]['uptime'] ?>:</b> <?= $htopBox['uptime'] ?></span>
        </div>
        <div class="cpu-bars">
            <b><?= $strings[$lang]['cpu_usage'] ?></b><br>
            <span class="cpu-label"><?= $strings[$lang]['cpu_total'] ?></span>
            <span class="bar">
                <span class="bar-fill" style="width:<?= $cpuUsages[0] * 4 ?>px"></span>
            </span>
            <?= $cpuUsages[0] ?>%
            <button class="toggle-btn" id="toggleBtn"><?= $strings[$lang]['cpu_details'] ?></button>
            <div id="cpuDetails" class="cpu-details">
                <?php foreach ($cpuUsages as $i => $usage): if ($i == 0) continue; ?>
                    <span class="cpu-label">CPU<?= $i-1 ?>:</span>
                    <span class="bar">
                        <span class="bar-fill" style="width:<?= $usage * 4 ?>px"></span>
                    </span>
                    <?= $usage ?>%
                    <br>
                <?php endforeach; ?>
            </div>
        </div>
        <div>
            <b><?= $strings[$lang]['mem_usage'] ?></b>
            <span class="bar">
                <span class="bar-fill" style="width:<?= $mem['percent'] * 4 ?>px"></span>
            </span>
            <?= $mem['used'] ?> MB / <?= $mem['total'] ?> MB (<?= $mem['percent'] ?>%)
        </div>
        <hr>
        <b><?= $strings[$lang]['top_processes'] ?></b>
        <table id="procTable">
    <thead>
    <tr>
        <?php
            $headers = explode(" ", preg_replace('/\s+/', ' ', trim($processList[0])));
            foreach ($headers as $header) {
                $key = strtolower($header);
                $sortType = 'str';
                if (in_array($key, ['pid','pri','ni'])) $sortType = 'num';
                if (in_array($key, ['vsz','rss'])) $sortType = 'mem';
                if (in_array($key, ['cpu','mem'])) $sortType = 'float';
                if ($key === 'time') $sortType = 'time';
                echo "<th data-sort='$sortType'>".($strings[$lang][$key] ?? $header)."</th>";
            }
        ?>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=1; $i<count($processList); $i++) {
        $cols = preg_split('/\s+/', trim($processList[$i]), 11);
        echo "<tr>";
        foreach ($cols as $j => $col) {
            // VSZ=5, RSS=6
            if ($j == 5 || $j == 6) {
                $gb = floatval($col) / 1048576; // 1024*1024
                echo "<td data-raw='$col'>" . number_format($gb, 2) . " GB</td>";
            } elseif ($j == 7 || $j == 8) { // %CPU, %MEM
                echo "<td data-raw='$col'>" . number_format(floatval($col), 2) . "</td>";
            } else {
                echo "<td>$col</td>";
            }
        }
        echo "</tr>";
    }
    ?>
    </tbody>
</table>
        <br>
        <small><?= $strings[$lang]['auto_refresh'] ?></small>
    </div>
    <!-- ====== JS 必須放在 body 最下方！ ====== -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // 倒數計時
        var refreshTime = <?= $refresh ?>;
        var timer = refreshTime;
        var countdownEl = document.getElementById('countdown');
        function countdown() {
            if (refreshTime && timer > 0) {
                countdownEl.innerText = timer + "s";
                timer--;
                setTimeout(countdown, 1000);
            } else if (refreshTime === 0) {
                countdownEl.innerText = "∞";
            } else {
                location.reload();
            }
        }
        countdown();

        // 展開/收合 CPU Cores
        var toggleBtn = document.getElementById('toggleBtn');
        var cpuDetails = document.getElementById('cpuDetails');
        if(toggleBtn && cpuDetails){
            toggleBtn.addEventListener('click', function() {
                if(cpuDetails.style.display === 'none' || cpuDetails.style.display === ''){
                    cpuDetails.style.display = 'block';
                    toggleBtn.innerText = "<?= $strings[$lang]['cpu_hide'] ?>";
                } else {
                    cpuDetails.style.display = 'none';
                    toggleBtn.innerText = "<?= $strings[$lang]['cpu_details'] ?>";
                }
            });
        }

        // 表格排序
        function parseTimeToSec(str) {
            if (!str) return 0;
            var d = 0, h = 0, m = 0, s = 0;
            var d_split = str.split('-');
            if (d_split.length == 2) {
                d = parseInt(d_split[0]);
                str = d_split[1];
            }
            var t = str.split(':');
            if (t.length == 3) {
                h = parseInt(t[0]);
                m = parseInt(t[1]);
                s = parseInt(t[2]);
            }
            return ((d*24+h)*60+m)*60+s;
        }
        function sortTable(tableId, col, type) {
            var table = document.getElementById(tableId);
            var tbody = table.tBodies[0];
            var rows = Array.prototype.slice.call(tbody.rows, 0);
            var asc = !table.sortedCol || table.sortedCol !== col || !table.sortedAsc;
            Array.from(table.tHead.rows[0].cells).forEach(th => th.classList.remove('sorted-asc', 'sorted-desc'));
            table.tHead.rows[0].cells[col].classList.add(asc ? 'sorted-asc' : 'sorted-desc');
            rows.sort(function(a, b) {
                var cellA = a.cells[col];
                var cellB = b.cells[col];
                var rawA = cellA.getAttribute('data-raw') || cellA.innerText.trim();
                var rawB = cellB.getAttribute('data-raw') || cellB.innerText.trim();
                if(type === 'num'){
                    return asc ? (parseInt(rawA)-parseInt(rawB)) : (parseInt(rawB)-parseInt(rawA));
                } else if(type === 'float'){
                    return asc ? (parseFloat(rawA)-parseFloat(rawB)) : (parseFloat(rawB)-parseFloat(rawA));
                } else if(type === 'mem') {
                    return asc ? (parseFloat(rawA)-parseFloat(rawB)) : (parseFloat(rawB)-parseFloat(rawA));
                } else if(type === 'time') {
                    return asc ? (parseTimeToSec(rawA)-parseTimeToSec(rawB)) : (parseTimeToSec(rawB)-parseTimeToSec(rawA));
                } else {
                    return asc ? rawA.localeCompare(rawB) : rawB.localeCompare(rawA);
                }
            });
            rows.forEach(row => tbody.appendChild(row));
            table.sortedCol = col; table.sortedAsc = asc;
        }
        // 綁定表格排序事件
        var table = document.getElementById('procTable');
        Array.from(table.tHead.rows[0].cells).forEach(function(th, idx) {
            th.onclick = function() {
                var name = th.getAttribute('data-sort');
                sortTable('procTable', idx, name);
            }
        });
    });
    </script>
</body>
</html>
