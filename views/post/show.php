<?php

use App\Connection;
use App\Table\CategoryTable;
use App\Table\PostTable;

$title = "Post";
$id = (int)$params['id'];
$slug = $params['slug'];

$pdo = Connection::getPDO();
//Recuperons un article
$post = (new PostTable($pdo))->find($id);
(new CategoryTable($pdo))->hydratePosts([$post]);

if ($post->getSlug() !== $slug) {
    $url = $router->url('post', ['slug' => $post->getSlug(), 'id' => $id]);
    http_response_code(301);
    header('Location: ' . $url);
}
?>

<h1><?= e($post->getName()) ?></h1>
<p class="mb-2 text-muted"><?= $post->getCreatedAt()->format('d F Y') ?></p>
<?php foreach($post->getCategories() as $key => $categorie):
    if($key > 0):
        echo ', ';
    endif
    ?><a href="<?= $router->url('category', ['id' => $categorie->getId(), 'slug' => $categorie->getSlug()]) ?>"><?= e($categorie->getName()) ?></a>
<?php endforeach ?>
<p><?= $post->getFormattedContent() ?></p>
