<?php

function showTitle($title)
{
    echo "<br/><b>&#9830; $title</b><br/>";
    echo '<hr/>';
}

$users = [
    [
        'id' => 2135,
        'first_name' => 'John',
        'last_name' => 'Doe',
    ],
    [
        'id' => 3245,
        'first_name' => 'Sally',
        'last_name' => 'Smith',
    ],
    [
        'id' => 5342,
        'first_name' => 'Jane',
        'last_name' => 'Jones',
    ],
    [
        'id' => 5623,
        'first_name' => 'Peter',
        'last_name' => 'Doe',
    ],
];

showTitle('Exercise 1: Display firstnames without iterations using array_column()');
$newarray = array_column($users, 'first_name');
foreach ($newarray as $firstName) {
    echo $firstName.',';
}

showTitle('Exercise 2: Display values that are different between $firstArray and $secondArray using array_diff()');

$firstArray = ['a' => 'auto', 'b' => 'moto', 'c' => 'avion'];
$secondArray = ['a' => 'auto', 'b' => 'moto'];
$newarray = array_diff($firstArray, $secondArray);
foreach ($newarray as $arrayDiff) {
    echo $arrayDiff;
}

showTitle('Exercice 3: Reverse keys and values in $firstArray with array_flip()');
$newarray = array_flip($firstArray);
foreach ($newarray as $arrayRev) {
    echo $arrayRev.',';
}
