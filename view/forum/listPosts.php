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

        <form action="index.php?ctrl=addPost" method="POST" id="add-message">

            <div class="form__group">
                <textarea id="content" name="content" class="post">Contenu du post à éditer</textarea>
            </div>

            <button id="btn-topic" type="submit" value="Add message" aria-label="Add message">Add message</button>

        </form>

    </div>

</section>