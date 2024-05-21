<?php
$category = $result["data"]['category'];
$topics = $result["data"]['topics'];
?>

<section id="listTopics">

    <div class="listTopics__container container">

        <h1>Topics' list of <?= $category ?></h1>

        <table>
            <thead>
                <tr>
                    <th scope="col">SUBJECT</th>
                    <th scope="col">AUTHOR</th>
                    <th scope="col">NB MESSAGES</th>
                    <th scope="col">LAST MESSAGE</th>
                </tr>
            </thead>
            <?php
            if (!$topics == null) {
            ?> <tbody>
                    <tr> <?php
                            foreach ($topics as $topic) { ?>
                            <th scope="row"><a href="index.php?ctrl=forum&action=listPosts&id=<?= $topic->getId() ?>"><?= $topic ?></a></th>
                            <td>by <?= $topic->getUser() ?></td>
                            <td>150</td>
                            <td>Last message</td>
                    </tr>
                </tbody>
            <?php } ?>
        </table>
    <?php
            } else { ?>
        <p>There's no topic in this category.</p>
    <?php } ?>

    </div>

</section>