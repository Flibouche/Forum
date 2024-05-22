<?php
$category = $result["data"]['category'];
$topics = $result["data"]['topics'];
?>

<section id="listTopics">

    <div class="listTopics__container container grid">

        <h1>Topics' list of <?= $category ?></h1>

        <table>
            <thead>
                <tr>
                    <th scope="col">SUBJECT</th>
                    <th scope="col">AUTHOR</th>
                    <th scope="col">NB MESSAGES</th>
                    <th scope="col">LAST MESSAGE</th>
                    <?php if (isset($_SESSION['user'])) { ?>
                        <th scope="col">DELETE</th>
                    <?php } ?>
                </tr>
            </thead>
            <?php
            if (!$topics == null) {
            ?> <tbody>
                    <tr> <?php
                            foreach ($topics as $topic) { ?>
                            <th scope="row"><a href="index.php?ctrl=forum&action=listPosts&id=<?= $topic->getId() ?>"><?= $topic ?></a></th>
                            <td>by <?= $topic->getUser() ?></td>
                            <!-- <td></td> -->
                            <td>Last message</td>
                            <?php if (isset($_SESSION['user'])) { ?>
                                <td><a href="index.php?ctrl=forum&action=deleteTopic&id=<?= $topic->getId() ?>"><i class="fa-solid fa-delete-left"></i></a></td>
                            <?php } ?>
                    </tr>
                </tbody>
            <?php } ?>
        </table>
    <?php
            } else { ?>
        <p>There's no topic in this category.</p>
    <?php } ?>

    <?php if (isset($_SESSION['user'])) { ?>

        <form action="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>&action=addTopic" method="POST" id="create-topic">
            <div class="form__group">
                <label for="title">Enter a title for the topic</label>
                <input type="title" name="title" id="title" aria-label="Topic's Title" placeholder="Enter title">
            </div>

            <div class="form__group">
                <textarea id="content" name="content" class="post" placeholder="Add message"></textarea>
            </div>

            <button id="btn-add" type="submit" name="submit" value="Add topic" aria-label="Add topic">Add topic</button>
        </form>

    <?php } ?>

    </div>

</section>