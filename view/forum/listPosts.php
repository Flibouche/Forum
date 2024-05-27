<?php
$topic = $result["data"]['topic'];
$posts = $result["data"]['posts'];
?>

<section id="listPosts">

    <div class="listPosts__container container">

        <h1>Posts' list of : <?= $topic->getTitle() ?></h1>

        <?php
        foreach ($posts as $post) { ?>
            <p><?= $post->getUser() ?> le <?= $post->getPublicationDate() ?><?php if (App\Session::isAdmin()) { ?> - <a href="index.php?ctrl=forum&action=deletePost&id=<?= $post->getId() ?>"><i class="fa-solid fa-delete-left"></i></a> <?php } ?></p>
            <p><?= strip_tags(html_entity_decode($post->getContent()), "<b><i><span>") ?></p>
            <br>
        <?php } ?>

        <?php if (isset($_SESSION['user']) && $topic->getIsLocked() == 0) { ?>
            <form action="index.php?ctrl=forum&action=addPost&id=<?= $topic->getId() ?>" method="POST" id="add-message">

                <div class="form__group">
                    <textarea id="content" name="content" class="post" placeholder="Add message"></textarea>
                </div>

                <button id="btn-add" type="submit" name="submit" value="Add message" aria-label="Add message">Add message</button>

            </form>
        <?php } elseif ($topic->getIsLocked() == 1) { ?>
            <p>Topic locked.</p>
        <?php } ?>

    </div>

</section>