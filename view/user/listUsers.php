<?php
$users = $result["data"]['users'];
?>

<section id="listUsers">

    <div class="listUsers__container container">

        <h1>List of users</h1>

        <?php
        foreach ($users as $user) { 
            ?>
            <p><a href="index.php?ctrl=user&action=displayUser&id=<?= $user->getId() ?>_<?= $user->getNickName() ?>"><?= $user ?></a></p>
        <?php } ?>

    </div>

</section>