<?php
$topic = $result["data"]['topic'];
?>

<section id="updateTopic">

    <div class="updateTopic__container container">

        <h1>Update the topic : <?= $topic->getTitle() ?></h1>

        <form action="index.php?ctrl=forum&action=updateTopic&id=<?= $topic->getId() ?>" method="POST" id="update-topic">

            <div class="form__group">
                <label for="title">Enter new title for the topic</label>
                <input type="title" name="title" id="title" aria-label="Topic's Title" placeholder="Enter title">
            </div>

            <button id="btn-update" type="submit" name="submit" value="Update topic" aria-label="Update topic">Update topic</button>

        </form>

    </div>

</section>