<?php
//Halaman Index API
$uri = $_SERVER['REQUEST_URI'];

$exp = explode('/', $uri);
$controller = $exp[3];
$params = $exp[4] ?? null;
$data = [
    'data' => null,
    'message' => null
];

require_once "./mysql_pdo.php";
$database = new Database($db_setting);
$database->connect();

$file_controller = 'controller/' . $controller . '.php';

if (file_exists($file_controller)) {
    require_once $file_controller;
} else {
    http_response_code(404);
    $data['message'] = '404 Not Found';
}

if (class_exists($controller)){
    $controller = new $controller($database, $params);
    $data['data'] = $controller->response['data'];
    $data['message'] = $controller->response['message'];

} else {
    http_response_code(404);
    $data['message'] = '404 Not Found';
}


$output = [
    'status' => http_response_code(),
    'data' => $data['data'],
    'message' => $data['message'],
];

header("Content-type: application/json");
echo json_encode($output);