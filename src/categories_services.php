<?php

function addСategory():string
{
    $db = getDB();

    do {
        $category = readline("Введите название категории: ");
    } while (empty($category));

    $stmt = $db->prepare("INSERT INTO categories (category) VALUES (:category)");
    $stmt->execute(['category' => $category]);

    return "Пост добавлен!";
}


function readAllСategories():string
{
    $db = getDB();
    $stmt = $db->query("SELECT * FROM categories;");

    $result = $stmt->fetchAll();

    foreach($result as $post){
        echo $post['id']." - ".$post['category']."\n";
    }

    return "\nВсе категории успешно получены!\n";
}

function readСategory():string
{
    $db = getDB();

    do {
        $id = (int)readline("Введите id категории: ");
    } while (empty($id));

    $stmt = $db->prepare("SELECT * FROM categories c WHERE id = :id;");
    $stmt->execute(['id' => $id]);

    $category = $stmt->fetch();

    if(empty($category)){
        return "Категория с id = $id не найден";
    }
    return $category['id']." - ".$category['category']."\n";

}

function clearСategories():string
{
    $db = getDB();
    $db->query("DELETE FROM posts;");
    $db->query("DELETE FROM categories;");
    return "Категории успешно удалены!";
}

function searchСategories():string
{
    $db = getDB();

    do {
        $subCategory = readline("Введите часть названия категории для поиска категории: ");
    } while (empty($subCategory));

    $stmt = $db->prepare("SELECT * FROM categories WHERE category LIKE :category;");
    $stmt->execute(['category' => "%$subCategory%"]);
    $categories = $stmt->fetchAll();

    if(empty($categories)){
        return handlerError("Не удалось получить категории!");
    }

    foreach($categories as $category){
        echo $category['id']." - ".$category['category']."\n";
    }
    return "Категории успешно получены!";
}



function deleteСategory():string{
    $db = getDB();

    do {
        $id = (int)readline("Введите id категории: ");
    } while (empty($id));

    $stmt = $db->prepare("DELETE FROM categories WHERE id = :id;");
    $stmt->execute(['id' => $id]);

    if($stmt->rowCount() > 0){
        return "Категория успешно удалёна!";
    }
    return handlerError("Не удалось удалить категорию!");

}
