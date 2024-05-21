<?php
$topic = $result["data"]['topic'];
$posts = $result["data"]['posts'];
?>

<section id="listPosts">

    <div class="listPosts__container container">

        <h1>Posts' list of : <?= $topic->getTitle() ?></h1>

        <?php
        foreach ($posts as $post) { ?>
            <p><?= $post->getUser() ?> le <?= $post->getPublicationDate() ?></p>
            <p><?= $post->getContent() ?></p>
            <br>
        <?php } ?>

        <form action="index.php?ctrl=forum&action=addPost&id=<?= $topic->getId() ?>" method="POST" id="add-message">

            <div class="form__group">
                <textarea id="content" name="content" class="post" placeholder="Add message"></textarea>
            </div>

            <button id="btn-add" type="submit" name="submit" value="Add message" aria-label="Add message">Add message</button>

        </form>

    </div>

</section>