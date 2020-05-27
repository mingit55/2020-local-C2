<?php

function classLoader($c){
    $className = str_replace("\\", DS, $c);
    $filePath = _SRC.DS.$className . ".php";
    if(is_file($filePath)) require($filePath);
}

spl_autoload_register("classLoader");