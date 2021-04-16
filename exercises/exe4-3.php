<?php

$Candidats = [
['Pierre', 22, '123 rue A', 'aa@ser.com', ['programming' => 5, 'teaching' => 2]],
['Julie', 65, '123 rue B', 'bb@ser.com', ['electronics' => 46]],
['Martin', 45, '123 rue C', 'cc@ser.com', ['programming' => 21, 'teaching' => 1]],
['Mélanie', 41, '123 rue D', 'dd@ser.com', ['welding' => 12, 'nutrition' => 6, 'restoration' => 1]],
];

// background black if age equal reference age, green when higher, blue when lower
const AGE_REFERENCE = 45;

// background yellow when years of experience higher or equal to MINIMUM_EXPERIENCE
const MINIMUM_EXPERIENCE = 5;

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Exercice 4-3 - Job Candidates</title>

    <style>
        table,
        td,
        th {
            border: 1px solid black;
            margin: auto;
        }

        ul {
            list-style-type: none;
            padding: 5px;
        }

        /* when egal age reference*/
        .age-reference {
            background-color: black;
            color: white;
        }

        /* when > age reference*/
        .age-over {
            background-color: green;
            color: white;
        }

        /* when < age reference */
        .age-under {
            background-color: blue;
            color: white;
        }

        /* when  < minimum experience */
        .experience-invalid {
            background-color: white;
            color: black;
        }

        /* when >= minimum experience */
        .experience-valid {
            background-color: yellow;
            color: black;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Age</th>
                <th>Address</th>
                <th>Email</th>
                <th>Experiences</th>
            </tr>
        </thead>

        <?php
            $sum = 0;
            foreach ($Candidats as $value) {
                $sum += $value[1];   //  addition of age

                echo'<tr class="';
                if ($value[1] == AGE_REFERENCE) {
                    echo 'age-reference';
                } elseif ($value[1] < AGE_REFERENCE) {
                    echo 'age-under';
                } else {
                    echo 'age-over';
                }
                echo'">';

                // one way
                /*foreach ($value as $key => $innerValue) {
                       if ($key < 4) {
                           echo '<td>'.$innerValue.'</td>';
                       } else {
                           echo '<td>';
                           foreach ($innerValue as $innerKey => $value1) {
                               echo $innerKey.':'.$value1.' Years<br>';
                           }
                           echo '</td>';
                       }
                } */

                //second way
                echo '<td>'.$value[0].'</td>';
                echo '<td>'.$value[1].'</td>';
                echo '<td>'.$value[2].'</td>';
                echo '<td>'.$value[3].'</td>';
                echo '<td>';
                echo '<ul>';

                foreach ($value[4] as $key => $value1) {
                    echo '<li class="';
                    if ($value1 < MINIMUM_EXPERIENCE) {
                        echo 'experience-invalid';
                    } else {
                        echo 'experience-valid';
                    }
                    echo'">'.$key.':'.$value1.' years</li>';
                }
                echo '</ul>';
                echo '</td>';
                echo '</tr>';
            }

            echo '<tr>';
            echo '<td>Average</td>';
            echo '<td>'.$sum / count($Candidats).'</td>';
            echo '<td colspan=3></td>';
            echo '</tr>';
            ?>

    </table>

</body>

</html>