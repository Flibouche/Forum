<?php
$user = $result["data"]['user'];
?>

<section id="profile">

    <div class="profile__container container">

        <h1>Welcome home <?= $user->getNickName() ?></h1>

        <p><?= $user->getNickName() ?></p>
        <p><?= $user->getEmail() ?></p>
        <img src="<?= $user->getProfilePicture() ?>" alt="Profile picture of <?= $user->getNickName() ?>" aria-label="Profile picture of <?= $user->getNickName() ?>" loading="lazy">

        <form action="index.php?ctrl=security&action=uploadProfilePicture&id=<?= $user->getId() ?>" method="POST" enctype="multipart/form-data">

            <div class="form__group">
                <label for="file" aria-label="Upload profile picture">Profile picture upload :</label>
                <input type="file" name="file" accept=".jpg, .png, .jpeg, .webp" />
            </div>

            <button id="btn-add" type="submit" name="submit" value="Upload profile picture" aria-label="Upload profile picture">Upload profile picture</button>

        </form>

    </div>

</section>