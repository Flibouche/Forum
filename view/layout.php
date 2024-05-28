<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $meta_description ?>">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tiny.cloud/1/zg3mwraazn1b2ezih16je1tc6z7gwp5yd4pod06ae5uai8pa/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= PUBLIC_DIR ?>/css/style.css">
    <title>GameWorld</title>
</head>

<body>
    <div id="wrapper">
        <div id="mainpage">
            <!-- C'est ici que les messages (erreur ou succès) s'affichent -->
            <h3 class="message" style="color: red"><?= App\Session::getFlash("error") ?></h3>
            <h3 class="message" style="color: green"><?= App\Session::getFlash("success") ?></h3>

            <header>
                <nav>

                    <a href="index.php?ctrl=home&action=index" class="nav__logo" aria-label="Logo GameWorld"><i class="fa-solid fa-gamepad"></i></a>

                    <div id="nav-menu" class="nav__menu" aria-label="Main Navigation">
                        <ul class="nav__list">

                            <li class="nav__item">
                                <a href="index.php?ctrl=home&action=index">Home</a>
                            </li>

                            <li class="nav__item">
                                <a href="index.php?ctrl=forum&action=index">Categories</a>
                            </li>

                            <?php
                            if (App\Session::isAdmin()) {
                            ?>
                                <li class="nav__item">
                                    <a href="index.php?ctrl=user&action=listUsers">See users</a>
                                </li>
                            <?php } ?>
                        </ul>

                        <div class="nav__close" id="nav-close">
                            <i class="fa-solid fa-xmark" aria-label="Close Navigation"></i>
                        </div>

                    </div>
                    <div class="nav__actions">
                        <?php
                        // Si l'utilisateur est connecté 
                        if (App\Session::getUser()) {
                            $user = App\Session::getUser()->getId();
                        ?>
                            <a href="index.php?ctrl=security&action=profile"><span class="fas fa-user"></span>&nbsp;<?= App\Session::getUser() ?></a>
                            <a href="index.php?ctrl=security&action=logout"><i class="fa-solid fa-arrow-right-from-bracket"></i></a>
                        <?php
                        } else {
                        ?>
                            <a href="index.php?ctrl=security&action=login"><i class="fa-solid fa-user"></i></a>
                            <a href="index.php?ctrl=security&action=register"><i class="fa-solid fa-user-plus"></i></a>
                        <?php
                        }
                        ?>

                        <!-- Toggle Button -->
                        <div class="nav__toggle" id="nav-toggle" aria-label="Toggle Navigation">
                            <i class="fa-solid fa-bars" aria-label="Toggle Navigation"></i>
                        </div>
                        
                    </div>
                </nav>
            </header>

            <main id="forum">
                <?= $page ?>
            </main>

        </div>

        <footer class="footer__container container">
            <p><a href="#">Règlement du forum</a> - <a href="#">Mentions légales</a> - <a href="#">Contact</a> - <a href="#">Need help ?</a></p>
            <p>&copy; Flibouche <?= date_create("now")->format("Y") ?></p>
        </footer>

    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {
            $(".message").each(function() {
                if ($(this).text().length > 0) {
                    $(this).slideDown(500, function() {
                        $(this).delay(3000).slideUp(500)
                    })
                }
            })
            $(".delete-btn").on("click", function() {
                return confirm("Etes-vous sûr de vouloir supprimer?")
            })
            tinymce.init({
                selector: '.post',
                menubar: false,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount'
                ],
                toolbar: 'undo redo | formatselect | ' +
                    'bold italic | backcolor alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | help',
                content_css: '//www.tiny.cloud/css/codepen.min.css'
            });
        })
    </script>
    <script src="<?= PUBLIC_DIR ?>/js/script.js"></script>
</body>

</html>