<?php
header('Content-Type: application/json');
function listFiles($dir) {
    $res = [];
    if (!is_dir($dir)) return $res;
    foreach(scandir($dir) as $item) {
        if ($item === '.' || $item === '..') continue;
        $path = $dir . DIRECTORY_SEPARATOR . $item;
        if (is_dir($path)) {
            $res[] = [
                'type' => 'folder',
                'name' => $item,
                'path' => substr($path, 2), // 去掉前面的'./'或'../'
                'children' => listFiles($path)
            ];
        } else {
            $res[] = [
                'type' => 'file',
                'name' => $item,
                'path' => substr($path, 2)
            ];
        }
    }
    return $res;
}
echo json_encode(listFiles(__DIR__ . '/../docs'));
