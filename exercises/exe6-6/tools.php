<?php
/**
 * prevent loading of tools.php directly
 * must go through index.php first.
 */
if (!isset($index_loaded)) {
    die('Direct acces to this file is forbidden');
}

/**
 * this file contain utility functions.
 */

/**
 * Display any one dimensional array.
 */
function array_display($array_name)
{
    $r = '';
    $r .= '<style> table,td,th{border: solid 2px black;}</style>';
    $r .= '<table>';
    $r .= '<tr>';
    $r .= '<th>Index/Key</th>';
    $r .= '<th>Value</th>';
    $r .= '</tr>';
    foreach ($array_name as $index => $value) {
        $r .= '<tr>';
        $r .= '<td> '.$index.' </td>';
        if ($index == 'price') {
            $r .= '<td> $'.$value.' </td>';
            $r .= '</tr>';
        } else {
            $r .= '<td>'.$value.' </td>';
            $r .= '</tr>';
        }
    }
    $r .= '</table>';

    return $r;
}

/**
 * Multi-Dimensional Array Display Function.
 */
function multiple_arrayDisplay($multiple_array)
{
    $r = '';
    $r .= '<style> td,th{border: solid 2px black;}</style>';
    $r .= '<table>';
    $r .= '<tr>';
    foreach ($multiple_array[0] as $key => $value) {
        $r .= '<th>'.$key.'</th>';
    }
    $r .= '</tr>';
    foreach ($multiple_array as $key => $value) {
        $r .= '<tr>';
        foreach ($value as $key1 => $value1) {
            if ($key1 == 'price') {
                $r .= '<td> $'.$value1.' </td>';
            } else {
                $r .= '<td>'.$value1.' </td>';
            }
        }
        $r .= '</tr>';
    }
    $r .= '</table>';

    return $r;
}
