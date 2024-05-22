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

        <form action="index.php?ctrl=forum&action=addCategory" method="POST" id="add-category">

            <div class="form__group">
                <label for="name">Enter a category name</label>
                <input type="name" name="name" id="name" aria-label="Category's Name" placeholder="Enter Name">
            </div>

            <button id="btn-add" type="submit" name="submit" value="Add category" aria-label="Add category">Add category</button>

        </form>

    </div>

</section>