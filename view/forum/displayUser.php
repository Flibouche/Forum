<?php
$user = $result["data"]['user'];
?>

<section id="displayUser">

    <div class="displayUser__container container">

        <h1>List of user informations</h1>

        <p><?= $user->getNickName() ?></p>
        <p><?= $user->getEmail() ?></p>

    </div>

</section>