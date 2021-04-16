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

/**
 * table_display($table) display any 2d table.
 */
function table_display($table)
{
    $out = '';
    $out = '<style> td,th{border: solid 2px black;}</style>';
    if (count($table) == 0) {
        //table is empty
        return 'table is empty';
    }
    $out .= '<table>';

    //table header
    $col_names = array_keys($table[0]);
    $out .= '<tr>';
    foreach ($col_names as $col_name) {
        $out .= '<th>'.$col_name.'</th>';
    }
    $out .= '</tr>';
    //table data
    $out .= '</tr>';
    foreach ($table as $one_row) {
        $out .= '<tr>';
        foreach ($one_row as $key => $col_name) {
            if ($key == 'price' and gettype($key) != 'integer') {
                $out .= '<td> $'.$col_name.' </td>';
            } else {
                $out .= '<td>'.$col_name.' </td>';
            }
        }
        $out .= '</tr>';
    }
    $out .= '</table>';

    return $out;
}

function catalog($array)
{
    $r = '';
    foreach ($array as $key => $value) {
        $r .= '<div class=product>';
        $r .= '<img src="products_images/'.$value['pic'].'" alt="'.$value['description'].'">';
        $r .= '<p class= name>'.$value['name'].'</p>';
        $r .= '<p class= description>'.$value['description'].'</p>';
        $r .= '<p class= price>$'.$value['price'].'</p>';
        $r .= '<p class=edit><a href="index.php?op=116&id='.$value['id'].'">edit</a>';
        $r .= '<p class=edit><a href="index.php?op=118&id='.$value['id'].'">Delete</a>';
        $r .= '</div>';
    }

    return $r;
}

function crash($code, $message)
{
    http_response_code($code);

    //here we can send email to IT admin
    //mail(ADMIN_EMAIL, COMPANY_NAME.'Server crashed code ='.$code, $message);

    //write in log file
    $file = fopen('logs/errors.log', 'a+');
    $time_info = date('d-M-Y g:i:s');
    fwrite($file, $message.' '.$time_info.'<br>');
    fclose($file);
    die($message);
}

/**
 * Check that $_FILE (the uploaded file) contains a valid image
 * extension must be: .jpg , .JPG , .gif ou .png.
 *
 * $file_input the file input name on the HTML form
 * $Max_Size maximum file size in Kb, default 500kb
 * returns "OK" or error message
 */
function Photo_Uploaded_Is_Valid($file_input, $Max_Size = 500000)
{
    //Must havein HTML <form enctype="multipart/form-data" .. //otherwise $_FILE is undefined // $file_input is the file input name on the HTML form
    if (!isset($_FILES[$file_input])) {
        return 'No image uploaded';
    }
    if ($_FILES[$file_input]['error'] != UPLOAD_ERR_OK) {
        return 'Error picture upload: code='.$_FILES[$file_input]['error'];
    }

    // Check image size
    if ($_FILES[$file_input]['size'] > $Max_Size) {
        return 'Image too big, max file size is '.$Max_Size.' Kb';
    }

    // Check that file actually contains an image
    $check = getimagesize($_FILES[$file_input]['tmp_name']);
    if ($check === false) {
        return 'This file is not an image';
    }

    // Check extension is jpg,JPG,gif,png
    $imageFileType = pathinfo(basename($_FILES[$file_input]['name']), PATHINFO_EXTENSION);
    if ($imageFileType != 'jpg' && $imageFileType != 'JPG' && $imageFileType != 'gif' && $imageFileType != 'png') {
        return 'Invalid image file type, valid extensions are: .jpg .JPG .gif .png';
    }

    return 'OK';
}

    /**
     * Function to save uploaded image in folder
     * (and display image for testing).
     * $file_input is the file input name on the HTML form.
     * */
    function Picture_Save_File($file_input, $target_dir)
    {
        $message = Photo_Uploaded_Is_Valid($file_input); // voir fonction
        if ($message === 'OK') {
            // Check that there is no file with the same name
            // already exists in the target folder
            // using file_exists()
            $target_file = $target_dir.basename($_FILES[$file_input]['name']);
            if (file_exists($target_file)) {
                return 'This file already exists';
            }

            // Create the file with move_uploaded_file()
            if (move_uploaded_file($_FILES[$file_input]['tmp_name'], $target_file)) {
                // ALL OK display image for testing
                //echo '<img src="'.$target_file.'">';
                return 'ok';
            } else {
                return 'Error in move_upload_file';
            }
        } else {
            // upload error, invalid image or file too big
            return $message;
        }
    }
