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

    </div>

</section>