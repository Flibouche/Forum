<?php
$user = $result["data"]['user'];
$topics = $result["data"]['topics'];
$posts = $result["data"]['posts'];
$lastTopic = $result["data"]['lastTopic'];
$lastPost = $result["data"]['lastPost'];
?>

<section id="displayUser">

    <div class="displayUser__container container">

        <h1>List of user informations</h1>

        <p><?= $user->getNickName() ?></p>
        <p><?= $user->getEmail() ?></p>

        <p>Number of topics : <?= $topics->getNbTopics() ?></p>
        <p>Number of posts : <?= $posts->getNbPosts() ?></p>

        <p>Last topic : <?= $lastTopic->getLastTopic() ?></p>
        <p>Last post : <?= $lastPost->getLastPost() ?></p>

    </div>

</section>