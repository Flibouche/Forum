<?php
$topic = $result["data"]['topic'];
$posts = $result["data"]['posts'];
?>

<h1>Liste des posts de : <?= $topic->getTitle() ?></h1>

<?php
foreach ($posts as $post) { ?>
    <p><?= $post->getUser() ?> le <?= $post->getPublicationDate() ?></p>
    <p><?= $post->getContent() ?></p>
    <br>
<?php }
