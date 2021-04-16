<!DOCTYPE html>
<html lang="<?=$this->lang; ?>">

<head>
    <meta charset="utf-8">
    <title><?=$this->title; ?>
    </title>
    <meta name="description" value="<?=$this->description; ?>">
    <meta name="author" value="<?=$this->author; ?>">

    <link rel="icon" href="<?=$this->icon; ?>">
    <link rel="stylesheet" href="css/global.css">
</head>

<body>
    <header>
        <?=WEB_SITE_NAME; ?>
    </header>
    <nav>
        <a href="index.php?op=100">Home</a>
        <a href="index.php?op=110">Product List</a>
        <a href="index.php?op=111">Product Catalog</a>
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

</html>