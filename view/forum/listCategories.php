<?php
$categories = $result["data"]['categories'];
?>

<section id="listCategories">

    <div class="listCategories__container container">

        <div class="listCategories-list">

            <h1>List of categories</h1>

            <?php
            foreach ($categories as $category) { ?>
                <div class="listCategories-category">

                    <div class="listCategories-category-name">
                        <p>
                            <a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>"><?= $category->getName() ?></a>
                            <?php if (App\Session::isAdmin()) { ?>
                                <a href="index.php?ctrl=forum&action=updateCategory&id=<?= $category->getId() ?>">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <a href="index.php?ctrl=forum&action=deleteCategory&id=<?= $category->getId() ?>" class="delete-btn">
                                    <i class="fa-solid fa-delete-left"></i>
                                </a>
                            <?php } ?>
                        </p>
                    </div>

                    <div class="listCategories-category-nbTopics">
                        <p><?= $category->getNbTopics() ?></p>
                    </div>

                </div>
                <hr>

            <?php } ?>
        </div>

        <?php if (isset($_SESSION['user'])) { ?>

            <div class="listCategories-add">

                <form action="index.php?ctrl=forum&action=addCategory" method="POST" id="add-category">

                    <div class="form__group">
                        <label for="name">Enter a category name</label>
                        <input type="name" name="name" id="name" aria-label="Category's Name" placeholder="Enter Name">
                    </div>

                    <button id="btn-add" type="submit" name="submit" value="Add category" aria-label="Add category">Add category</button>

                </form>

            </div>

        <?php } ?>

    </div>

</section>