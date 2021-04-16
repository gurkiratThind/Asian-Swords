<!DOCTYPE html>
<html lang="<?=$this->lang; ?>">

<head>
    <meta charset="utf-8">
    <title><?=$this->title; ?>
    </title>
    <meta name="description" value="<?=$this->description; ?>">
    <meta name="author" value="<?=$this->author; ?>">

    <link rel="icon" href="<?=$this->icon; ?>">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="css/global.css">

</head>

<body>
    <header>
        <img src="images/header_logo.jpg" alt="head icon">
        <?=WEB_SITE_NAME; ?>
    </header>
    <nav>
        <ul>
            <li><a href="index.php?op=100">Home</a></li>
            <li><a href="index.php?op=110">Product List</a></li>
            <li><a href="index.php?op=111">Product Catalog</a></li>

            <!----Employee only------------->
            <?php
            if ($_SESSION['user_level'] == 'employee') {
                echo '<li><a href="index.php?op=50">Server Logs</a></li>';
                echo '<li><a href="index.php?op=51">List Users</a></li>';
            }
            ?>
            <?php
        if (isset($_SESSION['user_name'])) {
            echo '<li style="float:right"> <img src="user_image/'.$_SESSION['user_pic'].'"class="rounded-circle" style="width:40px"></li>';
            echo '<li style="float:right">'.$_SESSION['user_name'].'</li>';
            echo '<li><a href="index.php?op=5">Logout</a></li>';
        } else {
            echo '<li><a href="index.php?op=1">Login</a></li>';
            echo'<li><a href="index.php?op=3">Register</a></li>';
        }
        ?>
        </ul>

    </nav>
    <main>
        <h1><?=$this->title; ?>
        </h1>
        <?=$this->content; ?>
    </main>

    <footer>
        THIS IS A FOOTER
        <a href="index.php?op=7">Download</a>
    </footer>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
    integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
    integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
</script>

</html>