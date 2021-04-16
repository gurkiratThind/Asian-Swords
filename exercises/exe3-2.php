<?php

const HOME = 'Welcome';
const PRODUCT = 'Product Catalogue';
const ABOUT = 'About Us';
const IDEA = 'Gift Ideas';

// the selected item
$selected = ABOUT;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Exercice 3-2 variable attribut</title>
    <style>
        #navigation ul {
            width: 150px;
        }

        .menu-item {
            background-color: #e1f4f3;
            color: #0000cc;
        }

        .selected {
            background-color: #fea799;
        }
    </style>
</head>

<body>
    <h1>Display active item in menu</h1>
    <nav id="navigation">
        <ul>
            <?php
            echo'<a href=""><li class="menu-item">'.HOME.'</li></a>';
            echo'<a href=""><li class="menu-item">'.PRODUCT.'</li></a>';
            echo'<a href=""><li class="selected">'.$selected.'</li></a>';
            echo'<a href=""><li class="menu-item">'.IDEA.'</li></a>';
           ?>
        </ul>
    </nav>
</body>

</html>