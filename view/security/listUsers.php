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
            <?php if (!$user->getRole() == $user->hasRole("ROLE_ADMIN")) { ?>
                <p><?= $user->getIsBanned() ?></p>
                <?php if ($user->getIsBanned() == 0) { ?>
                    <a href="index.php?ctrl=security&action=ban&id=<?= $user->getId() ?>">
                        <i class="fa-solid fa-ban"></i>
                    </a>
                <?php } else { ?>
                    <a href="index.php?ctrl=security&action=unban&id=<?= $user->getId() ?>">
                        <i class="fa-solid fa-user-lock"></i>
                    </a>
                <?php } ?>
                <br>
                <br>
                <br>
                <br>
                <br>
        <?php }
        } ?>

    </div>

</section>