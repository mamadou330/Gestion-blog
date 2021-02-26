<?php

use App\Connection;
use App\Model\Category;
use App\Model\Post;
use App\URL;

$id = (int)$params['id'];
$slug = $params['slug'];

$pdo = Connection::getPDO();

//Recuperons une categorie
$query = $pdo->prepare("SELECT * FROM category WHERE id = :id");
$query->execute(['id' => $id]);
$query->setFetchMode(PDO::FETCH_CLASS, Category::class);
/** @var Category|false */
$category = $query->fetch();

if ($category === false) {
    throw new \Exception("Aucune categorie ne correspond à cet ID");
}

if ($category->getSlug() !== $slug) {
    $url = $router->url('category', ['slug' => $category->getSlug(), 'id' => $id]);
    http_response_code(301);
    header('Location: ' . $url);
}

$title = "Ma categorie{$category->getName()}";

$currentPage = URL::getPositiveInt('page', 1);

$count = (int) $pdo
    ->query("SELECT COUNT(category_id) FROM post_category WHERE category_id = " . $category->getID())
    ->fetch(PDO::FETCH_NUM)[0];
$perPage = 12; //nombre d'article par page
$pages = ceil($count / $perPage); //nombre de pages = nombres d'articles / nbres d'article par pages

if ($currentPage > $pages) {
    throw new \Exception("Cette Page n'existe pas");
}
$offset = $perPage * ($currentPage - 1);
$query = $pdo->query(
    "SELECT p.* 
    FROM post p 
    JOIN post_category pc ON pc.post_id = p.id
    WHERE pc.category_id = {$category->getID()}
    ORDER BY created_at DESC 
    LIMIT  $perPage OFFSET $offset
    "
);
$posts = $query->fetchAll(PDO::FETCH_CLASS, Post::class);
$link = $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()]);

?>
<h1><?= e($title) ?></h1>

<div class="row">
    <?php foreach ($posts as $post) : ?>
        <div class="col-md-3">
            <?php require dirname(__DIR__). '/post/card.php' ?>
        </div>
    <?php endforeach ?>
</div>

<div class="d-flex justify-content-between my-4">
    <?php if ($currentPage > 1) : ?>
        <?php
        $l = $link;
        if ($currentPage > 2)
            $l = $link . '?page=' . ($currentPage - 1);
        ?>
        <a href="<?= $l ?>" class="btn btn-primary">&laquo; Page Précédent</a>
    <?php endif ?>
    <?php if ($currentPage < $pages) : ?>
        <a href="<?= $link ?>?page=<?= $currentPage + 1 ?>" class="btn btn-primary ml-auto">Page Suivant &raquo;</a>
    <?php endif ?>
</div>