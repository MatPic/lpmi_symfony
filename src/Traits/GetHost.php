<?php
namespace App\Traits;

trait GetHost {
    function getHost() { 
        $proto = strpos($_SERVER['SERVER_PROTOCOL'], "HTTP/") !== false ? "http://" : "https://";
        return $proto . $_SERVER['SERVER_NAME'] . "/";
    }
}