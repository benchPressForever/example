<?php

function getDB():PDO
{
    static $db = null;
    if (is_null($db)) {
        $db = new PDO('sqlite:database.db');
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }
    return $db;
}

function initDB():string
{
    $db = getDB();

    $db->query("PRAGMA foreign_keys = ON;");
    $db->query("CREATE TABLE IF NOT EXISTS `categories` (
	`id` INTEGER PRIMARY KEY AUTOINCREMENT UNIQUE,
	`category` TEXT NOT NULL
    );");

    $db->query("CREATE TABLE IF NOT EXISTS `posts` (
	`id` INTEGER  PRIMARY KEY AUTOINCREMENT UNIQUE,
	`title` TEXT NOT NULL,
	`text` TEXT NOT NULL,
	`id_category` INTEGER,
    FOREIGN KEY(`id_category`) REFERENCES `categories`(`id`) ON DELETE RESTRICT
    );");

    return "Структура бд построена!";
}

function seedDB():string
{
    $db = getDB();

    initDB();

    $db->query("DELETE FROM posts;");
    $db->query("DELETE FROM categories;");

    for($i = 1;$i <= 5;$i++ ) {
        $db->query("INSERT INTO categories VALUES ($i, 'Category_Name_{$i}');");
        for($j = ($i-1)*10 + 1;$j <= $i*10;$j++ ) {
            $db->query("INSERT INTO posts (title, text, id_category) VALUES  ('Title_{$j}', 'Text text lorem_{$j}', $i);");
        }
    }
    return "Данные успешно добавлены!";
}