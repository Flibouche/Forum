<?php
$user = $result["data"]['user'];
?>

<h1>Liste des information de l'utilisateur</h1>

    <p><?= $user->getNickName() ?></p>
    <p><?= $user->getEmail() ?></p>