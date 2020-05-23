<?php
require_once './vendor/autoload.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');

$client = new MongoDB\Client('mongodb://student_account:Qwerty.123@kodaktor.ru/experimental');

$collection = $client->experimental->users;

$cur = $collection->find();

$json = [];
foreach ($cur as $doc) {
    // Authentication failed.
    // $json[] = $doc['name'];
}


echo json_encode(['users' => $json]);
