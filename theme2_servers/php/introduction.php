<?php

header('Content-type: text/html; charset=utf-8');
header('Access-Control-Allow-Origin: *');

$str = $_GET['str'] ?? null;

echo '<h1>'.date('r').'</h1>';

if (null !== $str) {
    $md5 = md5($str);
    $sha1 = sha1($str);
    echo "<ul>";
    echo "<li>'$str'</li>";
    echo "<li>MD5: '$md5'</li>";
    echo "<li>SHA1: '$sha1'</li>";
    echo "</ul>";
} else {
    echo "<h2>Le vide c'est la forme.</h2>";
}
