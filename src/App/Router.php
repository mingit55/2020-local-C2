<?php
namespace App;

class Router {
    static $get = [];
    static $post = [];

    static function __callStatic($name, $props){
        if(strtoupper($name) === $_SERVER['REQUEST_METHOD']){
            self::${strtolower($name)}[] = $props;
        }
    }

    static function execute(){
        $currentURL = explode("?", $_SERVER['REQUEST_URI'])[0];
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        
        foreach(self::${$method} as $page){
            if($page[0] === $currentURL){
                if(isset($page[2]) && $page[2] === 'user' && !user()) go("/", "로그인 해 주세요.");
                $action = explode("@", $page[1]);
                $conName = "Controller\\{$action[0]}";
                $con = new $conName();
                $con->{$action[1]}();
                exit;
            }
        }
        http_response_code(404);
    }
}