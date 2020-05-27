<?php

function dump(){
    foreach(func_get_args() as $arg){
        echo "<pre>";
        var_dump($arg);
        echo "</pre>";
    }
}

function dd(){
    dump(...func_get_args());
    exit;
}


function user(){
    return isset($_SESSION['user']) ? $_SESSION['user'] : false;
}

function go($url, $message = ""){
    echo "<script>";
    echo "location.href = '$url';";
    echo "alert('$message');";
    echo "</script>";
    exit;
}

function back($message = ""){
    echo "<script>";
    echo "history.back();";
    echo "alert('$message');";
    echo "</script>";
    exit;
}

function view($pageName, $data = [], $import = ""){   
    extract($data);
    
    $layoutPath = _VIEW.DS."layouts";
    $filePath = _VIEW . DS . $pageName . ".php";

    if(is_file($filePath)){
        require $layoutPath . DS . "header.php";
        require $filePath;
        require $layoutPath . DS . "footer.php";
    }
}

function json_response($message, $result = true, $data = []){
    header("Content-Type: application/json");
    echo json_encode(array_merge(["message" => $message, "result" => $result],  $data));
}

function checkInput($response = "javsacript"){
    foreach($_POST as $input){
        if($input === ""){
            updateCaptcha();
            if($response === "javsacript") back("모든 정보를 기입해 주세요!");
            else json_response("모든 정보를 기입해 주세요!", false);
        }
    }
}

function updateCaptcha(){
    $str = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890";
    $length = 5;
    $result = "";
    for($i = 0; $i < $length; $i ++){
        $result .= $str[rand(0, strlen($str) - 1)];
    }
    
    $_SESSION['captcha'] = $result;
}