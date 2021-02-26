<?php
require dirname(__DIR__) . '/vendor/autoload.php';

use App\Connection;
use Faker\Factory;


$faker = Factory::create('fr_FR');

$pdo = Connection::getPDO();

$pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
$pdo->exec("TRUNCATE TABLE post_category");
$pdo->exec("TRUNCATE TABLE post");
$pdo->exec("TRUNCATE TABLE category");
$pdo->exec("TRUNCATE TABLE user");
$pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

$posts = [];
$categories = [];

for ($i=0; $i <= 50; $i++) {
    $pdo->exec(
        "INSERT INTO post SET 
            name = 'Article #$i', 
            slug = 'article-$i', 
            created_at = '2020-02-17 18:44', 
            content = 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Id consequatur fugiat laboriosam ex 
                    quibusdam atque animi debitis nobis nam, quam nemo ipsum exercitationem deleniti aperiam dolore 
                    laudantium nisi! Ea, nisi.Lorem ipsum dolor sit amet consectetur adipisicing elit. Id consequatur 
                    fugiat laboriosam ex quibusdam atque animi debitis nobis nam, quam nemo ipsum exercitationem deleniti
                    aperiam dolore laudantium nisi! Ea, nisi.'
        "
    );
    $posts[] = $pdo->lastInsertId();

    // $pdo->exec("INSERT INTO post SET name='{$faker->sentence()}', 
    //         slug='{$faker->slug()}', 
    //         created_at='{$faker->date} {$faker->time}', 
    //         content='{Lorem ipsum}'"
    //         // content='{$faker->paragraphs(rand(3, 10), true)}'"
    //     );
}

for ($i = 0; $i < 5; $i++) {
    $pdo->exec("INSERT INTO category SET name='Category #$i', slug='category-$i'");
    $categories[] = $pdo->lastInsertId();
}

foreach ($posts as $post) {
    $randomCategories = $faker->randomElements($categories, rand(0, count($categories)));
    foreach ($randomCategories as $category) {
        $pdo->exec("INSERT INTO post_category SET post_id=$post, category_id=$category");
    }
}

$password = password_hash('admin', PASSWORD_BCRYPT);
$pdo->exec("INSERT INTO user SET username='admin', password = '$password'");