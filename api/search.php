<?php
require_once("../vendor/Parsedown.php");
function searchDir($dir, $keyword, &$results) {
    foreach (scandir($dir) as $item) {
        if ($item === '.' || $item === '..') continue;
        $path = "$dir/$item";
        if (is_dir($path)) {
            searchDir($path, $keyword, $results);
        } else {
            $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            if (in_array($ext, ['md', 'txt'])) {
                $txt = file_get_contents($path);
                if (stripos($txt, $keyword) !== false) {
                    $results[] = [
                        'type' => 'file',
                        'name' => $item,
                        'path' => $path,
                        'snippet' => getSnippet($txt, $keyword)
                    ];
                }
            } else if ($ext === 'pdf') {
                $tmp_txt = "/tmp/".md5($path).".txt";
                if (!file_exists($tmp_txt) || filemtime($tmp_txt) < filemtime($path)) {
                    $cmd = "pdftotext ".escapeshellarg($path)." ".escapeshellarg($tmp_txt);
                    exec($cmd);
                }
                if (file_exists($tmp_txt)) {
                    $txt = file_get_contents($tmp_txt);
                    if (stripos($txt, $keyword) !== false) {
                        $results[] = [
                            'type' => 'file',
                            'name' => $item,
                            'path' => $path,
                            'snippet' => getSnippet($txt, $keyword)
                        ];
                    }
                }
            }
        }
    }
}

function getSnippet($txt, $keyword) {
    $pos = stripos($txt, $keyword);
    if ($pos === false) return '';
    $start = max(0, $pos-40);
    return '...'.substr($txt, $start, 80).'...';
}

$keyword = trim($_GET['q'] ?? '');
$results = [];
if ($keyword) {
    searchDir('../docs', $keyword, $results);
}
echo json_encode($results);
