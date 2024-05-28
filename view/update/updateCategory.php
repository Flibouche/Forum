<?php
$category = $result["data"]['category'];
?>

<section id="updateCategory">

    <div class="updateCategory__container container">

    <h1>Update the category : <?= $category->getName() ?></h1>

        <form action="index.php?ctrl=forum&action=updateCategory&id=<?= $category->getId() ?>" method="POST" id="update-category">

            <div class="form__group">
                <label for="name">Enter a new category name</label>
                <input type="name" name="name" id="name" aria-label="Category's Name" placeholder="Enter Name">
            </div>

            <button id="btn-update" type="submit" name="submit" value="Update category" aria-label="Update category">Update category</button>

        </form>

    </div>

</section>