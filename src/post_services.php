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


    $stmt =  $db->prepare("INSERT INTO posts  (title,text,id_category) VALUES (:title,:text,:id)");
    $stmt->execute(['title' => $title,'text' => $text,'id' => $id]);
    return "Пост добавлен!";
}


function readAllPosts():string
{
    $db = getDB();
    $stmt = $db->query("SELECT p.id post_id, c.id cat_id, 
                                     c.category, p.title, p.text 
                                     FROM posts p 
                                     JOIN categories c 
                                     ON p.id_category = c.id;");

    $posts = $stmt->fetchAll();

    $result = "";

    foreach($posts as $post){
        $result .= $post['post_id']." - ".$post['title']." - ".$post['text']." - ".$post['cat_id']." - ".$post['category']."\n";
    }

    return $result."\nВсе посты успешно получены!\n";
}

function readPost():string
{
    $db = getDB();

    do {
        $id = (int)readline("Введите id поста: ");
    } while (empty($id));

    $stmt = $db->prepare("SELECT p.id post_id,c.id cat_id, 
                                       c.category, p.title, p.text 
                                       FROM posts p 
                                       JOIN categories c 
                                       ON p.id_category = c.id 
                                       WHERE p.id = :id;");
    $stmt->execute(['id' => $id]);
    $post = $stmt->fetch();

    if(empty($post)){
        return "Пост с id = $id не найден";
    }
    return $post['post_id']." - ".$post['title']." - ".$post['text']." - ".$post['cat_id']." - ".$post['category']."\n";

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

    $result = "";

    foreach($posts as $post){
        $result .= $post['id']." - ".$post['title']." - ".$post['text']."\n";
    }
    return $result."\nПосты успешно получены!";
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

