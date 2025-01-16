<?php


require_once "vendor/autoload.php";

try{
    $result = main();
    echo $result;
}catch (Exception $e){
    echo handlerError($e->getMessage());
}