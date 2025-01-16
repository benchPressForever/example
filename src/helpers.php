<?php

function handlerError(string $error):string
{
    return "\033[31m".$error."\r\n \033[97m\n";
}

function handlerHelp():string
{

    $help = <<<HELP
    Доступные команды
    help - вывод данной подсказки
    init - инициализация структуры БД
    seed - заполнить БД фейковыми данными
    quiz - игра-викторина
    add-post - создать новый пост
    read-posts - получить все посты
    read-post  - получить один пост (по id)
    clear-posts - удалить посты
    search-posts - поиск постов по заголовку
    delete-post - удалить пост (по id)
HELP;

    return $help;
}