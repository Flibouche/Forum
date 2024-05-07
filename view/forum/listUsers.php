<?php
    $users = $result["data"]['user']; 
?>

<h1>Liste des utilisateurs</h1>

<?php
foreach($users as $user ){ ?>
    <p><a href="#"><?= $user ?></a> par <?= $user->getUser() ?></p>
<?php }