<?php

$ini_array = parse_ini_file(dirname(__DIR__)."/config.ini");
$GLOBALS['PathDb'] = $ini_array['path_db'];

function addPost()
{
    $postNoValid = true;
    $text = "";
    $title = "";

    while($postNoValid){
        $title = readline("Введите заголовок поста: ");
        $text = readline("Введите текст поста: ");

        if(!empty($title) and !empty($text)) $postNoValid = false;
        else echo handlerError("Ошибка!Пустая строка");
    }

    $DbFileName = dirname(__DIR__).$GLOBALS['PathDb'];

    if(is_readable($DbFileName)){
        $file = fopen($DbFileName, "a");
        fwrite($file, "$title;$text\n");
        fclose($file);
        return "Пост добавлен!";
    }
    return handlerError("Ошибка!Не удалось добавить пост");
}


function readAllPosts()
{
    $DbFileName = dirname(__DIR__).$GLOBALS['PathDb'];

    if(is_readable($DbFileName)) {
        $file = fopen($DbFileName, "r");

        $text = "";

        while(!feof($file)){
            $readArray = explode(";",fgets($file));
            $text .= $readArray[0].PHP_EOL;
        }

        echo $text;
        fclose($file);

        return "\nПосты успешно получены!";
    }
    else {
        return handlerError("Ошибка!Не удалось найти файл!");
    }

}

function readPost()
{
    $DbFileName = dirname(__DIR__).$GLOBALS['PathDb'];

    if(is_readable($DbFileName)) {
        $file = fopen($DbFileName, "r");

        $text = "";
        $numberPost = -1;


        if(count($_SERVER['argv']) > 2) $numberPost = (int)$_SERVER['argv'][2];
        else return handlerError("Ошибка!Не введён номер поста!");

        if($numberPost <= 0) return handlerError("Ошибка!Введён некорректный номер поста!");


        for($index = 1;!feof($file);$index++){
            $readArray = explode(";",fgets($file));
            if($index != $numberPost) continue;
            else {
                $text = implode("\n",$readArray);
                break;
            }
        }

        echo $text;
        fclose($file);

        if(empty($text)) return handlerError("Ошибка!Не удалось получить пост!");
        return "\nПост успешно получен!";
    }
    else {
        return handlerError("Ошибка!Не удалось найти файл!");
    }

}

function clearPosts()
{
    $DbFileName = dirname(__DIR__).$GLOBALS['PathDb'];
    if(is_readable($DbFileName)) {
        $file = fopen($DbFileName, "w");
        fwrite($file, "");
        fclose($file);
        return "База данных успешно очищена!";
    }
    return handlerError("Ошибка!Не удалось найти файл!");
}

function searchForPosts()
{
    $DbFileName = dirname(__DIR__).$GLOBALS['PathDb'];

    if(is_readable($DbFileName)) {
        $file = fopen($DbFileName, "r");

        $text = "";
        $title = "";

        while(empty($title)){
            $title = readline("Введите заголовок поста: ");
            if(empty($title)) echo handlerError("Ошибка!Пустая строка");
        }

        while(!feof($file)){
            $readArray = explode(";",fgets($file));
            if(strcmp($readArray[0],$title) == 0) $text .= implode("\n",$readArray);
        }

        echo $text;
        fclose($file);

        if(empty($text)) return handlerError("Ошибка!Не удалось найти пост!");
        return "\nПосты успешно найдены!";
    }
    else {
        return handlerError("Ошибка!Не удалось найти файл!");
    }
}



function deletePost(){
    $DbFileName = dirname(__DIR__).$GLOBALS['PathDb'];

    if(is_readable($DbFileName)) {
        $file = fopen($DbFileName, "r");

        $readArray = file($DbFileName, FILE_IGNORE_NEW_LINES);

        fclose($file);

        $numberPost = -1;

        if(count($_SERVER['argv']) > 2) $numberPost = (int)$_SERVER['argv'][2];
        else return handlerError("Ошибка!Не введён номер поста!");

        if($numberPost <= 0) return handlerError("Ошибка!Введён некорректный номер поста!");

        if(isset($readArray[$numberPost-1])){
            unset($readArray[$numberPost-1]);
        }
        else{
            return handlerError("Ошибка!Пост не существует!");
        }

        $readArray[] = "";

        file_put_contents($DbFileName, implode("\n",$readArray));


        return "\nПост успешно удалён!";
    }
    else {
        return handlerError("Ошибка!Не удалось найти файл!");
    }
}

