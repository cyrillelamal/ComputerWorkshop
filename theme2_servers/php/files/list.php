<?php
function wrap($x) {
    return '<li>'.$x.'</li>';
}

$list = '<ul>';
$f = fopen('log.txt', 'rt');
while (($line = fgets($f)) !== false) {
    $list .= wrap($line);
}
fclose($f);
$list .= '</ul>';

echo $list;
