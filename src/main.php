<?php


function main():string
{
    $command = parseComand();

    if(function_exists($command)){
        $result = $command();
    }
    else{
        $result = handlerError("Нет такой функции");
    }


    return $result;
}

//исправлено handlerHelp используется один раз
//Этот вариант использует ассоциативный массив для сопоставления аргументов командной строки с именами функций.
//Это, как правило, немного быстрее, чем `match`, особенно при большом количестве вариантов.
function parseComand(): string {
    $commands = [
        'add-post' => 'addPost',
        'read-posts' => 'readAllPosts',
        'read-post' => 'readPost',
        'clear-posts' => 'clearPosts',
        'search-posts' => 'searchForPosts',
        'delete-post' => 'deletePost',
    ];

    if (isset($_SERVER['argv'][1]) && isset($commands[$_SERVER['argv'][1]])) {
        $functionName = $commands[$_SERVER['argv'][1]];
    }
    return $functionName ?? "handlerHelp";
}