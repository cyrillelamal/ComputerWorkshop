<?php
require_once './Date.php';

header('Content-type: text/plain; charset=utf-8');

if (isset($_GET['public'])) {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, DELETE');
}
if (isset($_GET['print'])) {
    echo file_get_contents(basename('./Date.php'));
    echo file_get_contents(basename(__FILE__));
} else {
    echo (new Date());
}
