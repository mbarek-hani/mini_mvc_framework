<?php

class Router{

    public static function handle($method = 'GET', $path='/', $controller ='', $action = null): bool
    {
        $currentMethod = $_SERVER['REQUEST_METHOD'];
        $currentUri = $_SERVER['REQUEST_URI'];
        if($currentMethod != $method){
            return false;
        }
        
        $pattern = '#^'.$path.'$#siD';
        $matches = null;
        if(preg_match(pattern: $pattern, subject: $currentUri, matches: $matches)){
            if(is_callable(value: $controller)){

                array_shift($matches);
                $controller(...$matches);
            }else{
                require_once "../controllers/$controller.php";
                $controller = new $controller();

                array_shift($matches);
                $controller->$action(...$matches);
            }
        }else{
            return false;
        }
        exit();
    }

    public static function get( $path='/', $controller ='', $action = null)
    {
        return self::handle('GET',$path,$controller, $action);
    }

    public static function post( $path='/', $controller ='', $action = null)
    {
        return self::handle('POST',$path,$controller, $action);
    }

    public static function put( $path='/', $controller ='', $action = null)
    {
        return self::handle('PUT',$path,$controller, $action);
    }

    public static function patch( $path='/', $controller ='', $action = null)
    {
        return self::handle('PATCH',$path,$controller, $action);
    }

    public static function delete( $path='/', $controller ='', $action = null)
    {
        return self::handle('DELETE',$path,$controller, $action);
    }
}