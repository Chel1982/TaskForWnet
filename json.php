<?php
function __autoload ($class_name){
    include $class_name.'.php';
};

if($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'];
    $work = $_GET['w'];
    $connecting = $_GET['c'];
    $disconnected = $_GET['d'];
    }
        $_db = DB::getInstance();

        $arr = $_db -> getArray($id, $work, $connecting, $disconnected);

    echo json_encode($arr);

?>


