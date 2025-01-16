<?php

function handlerError(string $error):string
{
    return "\033[31m".$error."\r\n \033[97m\n";
}

function handlerHelp():string
{

    $help = <<<HELP
    ДОСТУПНЫЕ КОМАНДЫ
    ------------------------------------
    help - вывод данной подсказки
    ------------------------------------
    настройка БД
    ------------------------------------
    init - инициализация структуры БД
    seed - заполнить БД фейковыми данными
    ------------------------------------
    действия с постами
    ------------------------------------
    add-post - создать новый пост
    read-posts - получить все посты
    read-post  - получить один пост (по id)
    clear-posts - удалить посты
    search-posts - поиск постов по заголовку
    delete-post - удалить пост (по id)
    ------------------------------------
    действия с категориями
    ------------------------------------
    add-category - создать новую категорию
    read-categories - получить все категории
    read-category  - получить одну категорию (по id)
    clear-categories - удалить категории
    search-categories - поиск категорий по названию категории
    delete-category - удалить категорию (по id)
    ------------------------------------
    прочее
    ------------------------------------
    quiz - игра-викторина
HELP;

    return $help;
}