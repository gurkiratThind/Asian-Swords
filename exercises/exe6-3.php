<?php

function showTitle($title)
{
    echo "<h2>&#9830; $title</h2>";
    echo '<hr/>';
}

$phrase = 'Hello my friends! How are you today?';

showTitle('Exercise 1: number of characters with strlen()');
echo strlen($phrase);

showTitle('Exercise 2: word count with str_word_count()');
echo str_word_count($phrase);

showTitle('Exercise 3: uppercase with strtoupper()');
echo strtoupper($phrase);

showTitle('Exercise 4: First character of each word capitalized with ucwords()');
echo ucwords($phrase);

showTitle('Exercise 5: one word per line with explode() et foreach');
$p = explode(' ', $phrase);
foreach ($p as $index => $mess) {
    echo $mess.'<br>';
}

showTitle('Exercise 6: reverse the array with array_reverse()');
$revers = array_reverse($p);
foreach ($revers as $index => $mess) {
    echo $mess.'<br>';
}

showTitle('Exercise 7 character count without whitespaces');
echo strlen(str_replace(' ', '', $phrase));

showTitle('Exercise 8 change a for b, c for d, e for f with strtr()');
$wordSwap = ['a' => 'b', 'c' => 'd', 'e' => 'f'];
echo strtr($phrase, $wordSwap);
