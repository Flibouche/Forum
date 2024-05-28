<?php
$topic = $result["data"]['topic'];
$posts = $result["data"]['posts'];
?>

<section id="listPosts">

    <div class="listPosts__container container">

        <h1>Posts' list of : <?= $topic->getTitle() ?>
            <?php
            if ($topic->getIsLocked() == 1) { ?>
                - <i class="fa-solid fa-lock"></i>
            <?php } ?>
        </h1>

        <?php if (App\Session::isAdmin()) { ?>
            <a href="index.php?ctrl=forum&action=updateTopic&id=<?= $topic->getId() ?>">
                <i class="fa-solid fa-pen"></i>
            </a>
            <?php if ($topic->getIsLocked() == 0) { ?>
                <a href="index.php?ctrl=forum&action=lockTopic&id=<?= $topic->getId() ?>">
                    <i class="fa-solid fa-lock"></i>
                </a>
            <?php } else { ?>
                <a href="index.php?ctrl=forum&action=unlockTopic&id=<?= $topic->getId() ?>">
                    <i class="fa-solid fa-unlock"></i>
                </a>
            <?php }
        }

        foreach ($posts as $post) { ?>
            <p><?= $post->getUser() ?> le <?= $post->getPublicationDate() ?><?php if (App\Session::isAdmin()) { ?> - <a href="index.php?ctrl=forum&action=deletePost&id=<?= $post->getId() ?>"><i class="fa-solid fa-delete-left"></i></a> <?php } ?></p>
            <p><?= strip_tags(html_entity_decode($post->getContent()), "<b><i><span>") ?></p>
            <br>

            <?php if ($post->getUser() == App\Session::getUser()) { ?>
                <p><i class="fa-solid fa-pen" onclick="show(this)"></i></p>
                <div class="edit-post">
                    <form action="index.php?ctrl=forum&action=updatePost&id=<?= $post->getId() ?>" method="POST" id="edit-post">

                        <div class="form__group">
                            <textarea id="content" name="content" class="post"><?= $post->getContent() ?></textarea>
                        </div>

                        <button id="btn-edit" type="submit" name="submit" value="Edit message" aria-label="Edit message">Edit message</button>

                    </form>
                </div>
        <?php }
        } ?>

        <?php if (isset($_SESSION['user']) && $topic->getIsLocked() == 0) { ?>
            <form action="index.php?ctrl=forum&action=addPost&id=<?= $topic->getId() ?>" method="POST" id="add-post">

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
<script>
    function show(element) {
        var editPostDiv = element.parentElement.nextElementSibling;
        if (editPostDiv.style.display === "none" || editPostDiv.style.display === "") {
            editPostDiv.style.display = "block";
        } else {
            editPostDiv.style.display = "none";
        }
    }
</script>