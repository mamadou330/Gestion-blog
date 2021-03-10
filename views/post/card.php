<?php
$categories = [];
foreach ($post->getCategories() as $category) {
    $url = $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()]);
    $categories[] = <<<HTML
        <a href="{$url}">{$category->getName()}</a>
HTML;
}
?>

<div class="card mb-3" style="width: 18rem;">
    <div class="card-body">
        <h5 class="card-title"><?= strip_tags(htmlentities($post->getName())) ?></h5>
        <!-- <h6 class="card-subtitle mb-2 text-muted"><= $post->getCreatedAt()->format('d F Y') ?></h6> -->
        <p class="text-muted">
            <?= $post->getCreatedAt()->format('d F Y') ?>
                <?php if (!empty($post->getCategories())): ?>
                    ::
                    <?= implode(', ', $categories) ?>
                <?php endif ?>
        </p>
        <p class="card-text"><?= $post->getExcerpt() ?></p>
        <a href="<?= $router->url('post', ['id' => $post->getID(), 'slug' => $post->getSlug()]) ?>" class="card-link btn btn-primary">Voir plus</a>
    </div>
</div>