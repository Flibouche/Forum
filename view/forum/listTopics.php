<?php
$category = $result["data"]['category'];
$topics = $result["data"]['topics'];
?>

<h1>Liste des topics de <?= $category ?></h1>

<?php
if (!$topics == null) {
    foreach ($topics as $topic) { ?>
        <p><a href="index.php?ctrl=forum&action=listPosts&id=<?= $topic->getId() ?>"><?= $topic ?></a> par <?= $topic->getUser() ?></p>
    <?php }
} else { ?>
    <p>There's no topic in this category.</p>
<?php }
