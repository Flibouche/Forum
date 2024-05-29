<?php
$topic = $result["data"]['topic'];
$posts = $result["data"]['posts'];
?>

<section id="listPosts">

    <div class="listPosts__container container">

        <div class="listPosts-list">

            <h1>Posts' list of : <?= $topic->getTitle() ?>

                <?php
                if ($topic->getIsLocked() == 1) { ?>
                    - <i class="fa-solid fa-lock"></i>
                <?php } ?>
            </h1>

            <?php if (App\Session::isAdmin()) { ?>
                <div class="listPosts-options">
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
                    <?php } ?>
                </div>
            <?php }

            foreach ($posts as $post) { ?>
                <div class="listPosts-post">

                    <div class="listPosts-user">

                        <a href="index.php?ctrl=user&action=displayUser&id=<?= App\Session::getUser()->getId() ?>_<?= App\Session::getUser()->getNickName() ?>" class="profile-picture">
                            <img src="<?= App\Session::getUser()->getProfilePicture() ?>" alt="<?= App\Session::getUser()->getNickName() ?>'s profile picture" aria-label="<?= App\Session::getUser()->getNickName() ?>'s profile picture">
                        </a>
                        <p>
                            <a href="index.php?ctrl=user&action=displayUser&id=<?= App\Session::getUser()->getId() ?>_<?= App\Session::getUser()->getNickName() ?>">
                                <?= $post->getUser() ?>
                            </a>
                            le <?= $post->getPublicationDate() ?><?php if (App\Session::isAdmin()) { ?> - <a href="index.php?ctrl=forum&action=deletePost&id=<?= $post->getId() ?>"><i class="fa-solid fa-delete-left"></i></a><?php } ?>
                        </p>

                    </div>

                    <div class="listPosts-content">

                        <p><?= strip_tags(html_entity_decode($post->getContent()), "<b><i><span>") ?></p>

                        <?php if ($post->getUser() == App\Session::getUser()) { ?>
                            <p class="edit-pen"><i class="fa-solid fa-pen" onclick="show(this)"></i></p>
                            <div class="edit-post">
                                <form action="index.php?ctrl=forum&action=updatePost&id=<?= $post->getId() ?>" method="POST" id="edit-post">

                                    <div class="form__group">
                                        <textarea id="content" name="content" class="post"><?= $post->getContent() ?></textarea>
                                    </div>

                                    <button id="btn-edit" type="submit" name="submit" value="Edit message" aria-label="Edit message">Edit message</button>

                                </form>
                            </div>
                        <?php } ?>
                    </div>
                </div>

            <?php } ?>
        </div>

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