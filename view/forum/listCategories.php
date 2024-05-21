<?php
$categories = $result["data"]['categories'];
?>

<section id="listCategories">

    <div class="listCategories__container container">

        <h1>List of categories</h1>

        <?php
        foreach ($categories as $category) { ?>
            <p><a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>"><?= $category->getName() ?></a></p>
        <?php } ?>

        <button id="btn-show" onclick="showTopic()">Create a topic</button>

        <form action="" method="POST" id="create-topic">
            <div class="form__group">
                <label for="title">Enter a title for the topic</label>
                <input type="title" name="title" id="title" aria-label="Topic's Title">
            </div>

            <div class="form__group">
                <textarea class="post">Contenu du post à éditer</textarea>
            </div>

            <button id="btn-topic">Create the topic</button>
        </form>

    </div>

</section>