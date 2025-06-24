<?php

class Router{
    public static function handle($method = 'GET', $path='/', $filename ='')
    {
        $currentMethod = $_SERVER['REQUEST_METHOD'];
        $currentUri = $_SERVER['REQUEST_URI'];
        if($currentMethod != $method){
            return false;
        }
        $pattern = '#^'.$path.'$#siD';
        if(preg_match($pattern,$currentUri)){
            if(is_callable($filename)){
                $filename();
            }else{
                require_once $filename;
            }
            exit();
        }
        return false;
    }

    public static function get( $path='/', $filename ='')
    {
        return self::handle('GET',$path,$filename);
    }

    public static function post( $path='/', $filename ='')
    {
        return self::handle('POST',$path,$filename);
    }

    public static function put( $path='/', $filename ='')
    {
        return self::handle('PUT',$path,$filename);
    }

    public static function patch( $path='/', $filename ='')
    {
        return self::handle('PATCH',$path,$filename);
    }

    public static function delete( $path='/', $filename ='')
    {
        return self::handle('DELETE',$path,$filename);
    }
}