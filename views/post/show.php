<?php

use App\Connection;
use App\Model\Category;
use App\Model\Post;
$title = "Post";

$id = (int)$params['id'];
$slug = $params['slug'];

$pdo = Connection::getPDO();

//Recuperons un article
$query = $pdo->prepare("SELECT * FROM post WHERE id = :id");
$query->execute(['id' => $id]);
$query->setFetchMode(PDO::FETCH_CLASS, Post::class);
/** @var Post|false */
$post = $query->fetch();

if ($post === false) {
    throw new \Exception("Aucun article ne correspond à cet ID");
}

if ($post->getSlug() !== $slug) {
    $url = $router->url('post', ['slug' => $post->getSlug(), 'id' => $id]);
    http_response_code(301);
    header('Location: ' . $url);
}

//Recuperons les categories
$query = $pdo->prepare(
    "SELECT c.id, c.slug, c.name FROM post_category pc
    JOIN category c ON pc.category_id = c.id WHERE pc.post_id = :id"
);
$query->execute(['id' => $post->getID()]);
$query->setFetchMode(PDO::FETCH_CLASS, Category::class);
/** @var Category[] */
$categories = $query->fetchAll();
?>

<h1><?= e($post->getName()) ?></h1>
<p class="mb-2 text-muted"><?= $post->getCreatedAt()->format('d F Y') ?></p>
<?php foreach($categories as $key => $categorie):
    if($key > 0):
        echo ', ';
    endif
    ?><a href="<?= $router->url('category', ['id' => $categorie->getId(), 'slug' => $categorie->getSlug()]) ?>"><?= e($categorie->getName()) ?></a>
<?php endforeach ?>

<p><?= $post->getFormattedContent() ?></p>

