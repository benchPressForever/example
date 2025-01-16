<?php

function addPost():string
{
    $db = getDB();

    $stmt = $db->query("SELECT * FROM categories");
    $categories = $stmt->fetchAll();

    echo "Категории постов:\n";
    foreach ($categories as $category) {
        echo $category['id'].' - '.$category['category'].PHP_EOL;
    }

    $noValid = true;
    while($noValid){
        $id = (int)readline("\nВведите id категории: ");
        if(empty($id)) {continue;}

        foreach ($categories as $category) {
            if($category['id'] == $id) {
                $noValid = false;
                break;
            }
        }
    }


    do {
        $title = readline("Введите заголовок поста: ");
    } while (empty($title));

    do {
        $text = readline("Введите текст поста: ");
    } while (empty($text));


    $db->query("INSERT INTO posts  (title,text,id_category) VALUES ('$title','$text','$id')");
    return "Пост добавлен!";
}


function readAllPosts():string
{
    $db = getDB();
    $stmt = $db->query("SELECT p.id post_id, c.id cat_id, c.category, p.title, p.text FROM posts p JOIN categories c ON p.id_category = c.id;");

    $result = $stmt->fetchAll();

    foreach($result as $post){
        echo $post['post_id']." - ".$post['category']." - ".$post['title']." - ".$post['text']."\n";
    }

    return "\nВсе посты успешно получены!\n";
}

function readPost():string
{
    $db = getDB();

    do {
        $id = (int)readline("Введите id поста: ");
    } while (empty($id));

    $stmt = $db->prepare("SELECT p.id post_id, c.id cat_id, c.category, p.title, p.text FROM posts p JOIN categories c ON p.id_category = c.id WHERE p.id = :id;");

    $stmt->execute(['id' => $id]);
    $post = $stmt->fetch();

    if(empty($post)){
        return "Пост с id = $id не найден";
    }
    return $post['post_id']." - ".$post['category']." - ".$post['title']." - ".$post['text']."\n";

}

function clearPosts():string
{
    $db = getDB();
    $db->query("DELETE FROM posts;");
    return "Посты успешно удалены!";
}

function searchForPosts():string
{
    $db = getDB();

    do {
        $subTitle = readline("Введите часть текста заголовка для поиска постов: ");
    } while (empty($subTitle));

    $stmt = $db->prepare("SELECT * FROM posts WHERE title LIKE :title;");
    $stmt->execute(['title' => "%$subTitle%"]);
    $posts = $stmt->fetchAll();

    if(empty($posts)){
        return handlerError("Не удалось получить посты!");
    }

    foreach($posts as $post){
        echo $post['id']." - ".$post['title']." - ".$post['text']."\n";
    }
    return "Посты успешно получены!";
}



function deletePost():string{
    $db = getDB();

    do {
        $id = (int)readline("Введите id поста: ");
    } while (empty($id));

    $stmt = $db->prepare("DELETE FROM posts WHERE id = :id;");
    $stmt->execute(['id' => $id]);

    if($stmt->rowCount() > 0){
        return "Пост успешно удалён!";
    }
    return handlerError("Не удалось удалить пост!");

}

