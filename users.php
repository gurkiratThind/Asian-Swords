<?php

require_once 'db_pdo.php';
if (!isset($index_loaded)) {
    die('Direct acces to this file is forbidden');
}
require_once 'web_page.php';
$Provinces = [
    ['id' => 0, 'code' => 'QC', 'name' => 'Québec'],
    ['id' => 1, 'code' => 'ON', 'name' => 'Ontario'],
    ['id' => 2, 'code' => 'NB', 'name' => 'New-Brunswick'],
    ['id' => 4, 'code' => 'NS', 'name' => 'Nova-Scotia'],
    ['id' => 5, 'code' => 'MN', 'name' => 'Manitoba'],
    ['id' => 6, 'code' => 'SK', 'name' => 'Saskatchewan'],
];

class users
{
    /**
     * Login page display.
     */
    //================================LoginPageDisplay()===================================
    public function LoginPageDisplay($err_msg = '', $prev_values = [])
    {
        if ($prev_values == []) {
            // initial values first time display
            $prev_values['email'] = '';
            $prev_values['pw'] = '';
        }
        if (isset($_COOKIE['user_name'])) {
            $welcome_msg = 'Welcome back '.$_COOKIE['user_name'].'!you last visited'.date('d-M-Y', $_COOKIE['last_login_time']);
        } else {
            $welcome_msg = '';
        }
        $LoginPage = new web_page();
        $LoginPage->title = 'Please login';
        $LoginPage->content = <<<HTML
        <div  class="alert alert-danger" >{$err_msg}</div>
        <div  class="alert alert-danger" >{$welcome_msg}</div>
    <form action="index.php?op=2" method="POST" style="width:300px">
    <!-- <input type="hidden" name="op" value="2"> -->
    <input type="email" name="email" required maxlength="126" size="25" placeholder="Email" value="{$prev_values['email']}" class="form-control"><br>
    <input type="password" name="pw" required maxlength="8" placeholder="Password" value="{$prev_values['pw']}" class="form-control"><br>
    <input type="submit" value="Continue" class="btn btn-primary">
    </form>
    HTML;
        $LoginPage->render();
    }

    //========================LoginPageVerify()===================================
    public function LoginPageVerify()
    {
        // would come from db query
        //     $Users = [
        //     ['id' => 0, 'email' => 'abc@test.com', 'pw' => '12345678', 'name' => 'Gurkirat Singh', 'level' => 'customer'],
        //     ['id' => 1, 'email' => 'dfg@test.com', 'pw' => '12345687', 'name' => 'Taranjot Singh', 'level' => 'customer'],
        //     ['id' => 2, 'email' => 'sdf@test.com', 'pw' => '11111111', 'name' => 'Chiranjeev Singh', 'level' => 'employee'],
        // ];

        $DB = new db_pdo();
        $Users = $DB->querySelect('SELECT * from users');

        // error messages
        $err_msg = '';

        //email
        if (isset($_POST['email'])) {
            $email_input = $_POST['email'];
        } else {
            crash(500, 'email not found in form login, class users.php');
        }
        if (!filter_var($email_input, FILTER_VALIDATE_EMAIL)) {
            $err_msg .= 'email wrong in form login, class users.php';
        }
        //password
        if (isset($_POST['pw'])) {
            $pw_input = $_POST['pw'];
        } else {
            crash(500, 'pw not found in form login, class users.php');
        }
        if (strlen($pw_input) != 8) {
            $err_msg .= 'Password must be 8 characters long ';
        }
        // data problem
        if ($err_msg != '') {
            // display form with error message and values previously entered
            $this->LoginPageDisplay($err_msg, $_POST);
        }

        // verify email & pw in the list of $Users
        $user_found = false;
        foreach ($Users as $one_user) {
            if ($email_input == $one_user['email'] & $pw_input == $one_user['pw']) {
                $current_user_info = $one_user;
                $user_found = true;

                break;
            }
        }

        if ($user_found) {
            $_SESSION['user_connected'] = true;
            $_SESSION['user_email'] = $current_user_info['email'];
            $_SESSION['user_name'] = $current_user_info['fullname'];
            $_SESSION['user_id'] = $current_user_info['id'];
            $_SESSION['user_level'] = $current_user_info['user_level'];
            $_SESSION['user_pic'] = $current_user_info['user_pic'];
            //setcookie
            setcookie('user_name', $current_user_info['fullname'], time() + (2 * 365 * 24 * 60 * 60));
            setcookie('user_email', $current_user_info['email'], time() + (2 * 365 * 24 * 60 * 60));
            setcookie('last_login_time', time(), time() + (2 * 365 * 24 * 60 * 60));

            $page = new web_page();
            $page->title = 'Welcome To';
            $page->content = 'You are loged in '.$_SESSION['user_name'];
            $page->render();
        } else {
            // display form with error message and values previously entered
            if (!isset($_SESSION['login_count'])) {
                $_SESSION['login_count'] = 1;
            } else {
                ++$_SESSION['login_count'];
            }
            if ($_SESSION['login_count'] > 3) {
                $page = new web_page();
                $page->title = 'You are blocked';
                $page->content = 'You reached the max login attemp. Please visit later to try agin';
                $page->render();
            } else {
                $this->LoginPageDisplay('email and/or password not found, try again', $_POST);
            }
        }
    }

    //=========================RegisterFormDisplay()==============================

    public function RegisterFormDisplay($err_msg = '', $prev_values = [])
    {
        if ($prev_values == []) {
            // initial values first time display
            $prev_values = [
            'fullname' => '',
            'address_line1' => '',
            'address_line2' => '',
            'city' => '',
            'postal_code' => '',
            'lang' => 'en',
            'other_lang' => '',
            'email' => '',
            'pw' => '',
            'pw2' => '',
            'spam_ok' => '',
        ];
        }
        global $Provinces;
        $selectProvinces = '<Select class="form-control" name="province">';
        foreach ($Provinces as $one_province) {
            $selectProvinces .= '<option value="'.$one_province['code'].'">'.$one_province['name'].'</option>';
        }
        $selectProvinces .= '</select>';
        $RegisterPage = new web_page();
        $RegisterPage->title = 'Register Form';
        $RegisterPage->content = <<<HTML
    <div  class="alert alert-danger" >{$err_msg}</div>
    <form enctype="multipart/form-data" action="index.php?op=4" method="POST" style="width:350px">
    
    <fieldset>
    <legend>General Information</legend>
    <input type="text" class="form-control" name="fullname" maxlength="50" required placeholder="FirstName & LastName"  value="{$prev_values['fullname']}"><br>
    Address (optional)
    <input type="text" class="form-control" name="address_line1" maxlength="50" placeholder="Address Line 1"  value="{$prev_values['address_line1']}"><br>
    <input type="text" class="form-control" name="address_line2" maxlength="50" placeholder="Address Line 2"  value="{$prev_values['address_line2']}"><br>
    City (optional)
    <input type="text" class="form-control" name="city" maxlength="50"  value="{$prev_values['city']}"><br>
    Province (optional)<br>
    {$selectProvinces}<br>
    Postal Code (optional)<br>
    <input type="text" class="form-control" name="postal_code" maxlength="7" placeholder="eg.A1B-2D3"  value="{$prev_values['postal_code']}">
    </fieldset>
    
    <br>select a picture of you (max 500kb jpg, JPG, gif or png)<br>
    <input type="file" name="user_pic"> 
    <fieldset>
    <legend>Language</legend>
    <input type="radio" name="lang" value="fr" required>French<br>
    <input type="radio" name="lang" value="en" required checked>English<br>
    <input type="radio" name="lang" value="other" required>Other
    <input type="text" name="other_lang" maxlength="25"  value="{$prev_values['other_lang']}"><br>
    </fieldset>
    <fieldset>
    <legend>Interests</legend>
    <select class="form-control" name="interests[]" multiple size="3">
            <option value="se">scooter électrique</option>
            <option value="sg">scooter à essence</option>
            <option value="velo_el">vélo électrique</option>
            <option value="velo">velo régulier</option>
            <option value="moto">moto</option>
        </select>
    </fieldset>
    <fieldset>
    <legend>Connection Info(Requiered)</legend>
    <input type="email" class="form-control" name="email" maxlength="126" required placeholder="Email"  value="{$prev_values['email']}"><br>
    <input type="password" class="form-control" name="pw" maxlength="8" required placeholder="Password - max length 8"  value="{$prev_values['pw']}"><br>
    <input type="password" class="form-control" name="pw2" maxlength="8" required placeholder="Password - max length 8" value="{$prev_values['pw2']}"><br>
    <input class="form-check-input" type="checkbox" name="spam_ok" value="1" checked>
    I accept to periodically receive information about new product<br>
    <input type="submit" value="Continue" class="btn btn-primary">
    </fieldset>
    </form>
    HTML;
        $RegisterPage->render();
    }

    //========================RegisterFormVerify()========================
    public function RegisterFormVerify()
    {
        // error messages
        $err_msg = '';
        $user_found;

        //email
        if (isset($_POST['email'])) {
            $email_input = $_POST['email'];
        } else {
            crash(500, 'email not found in Register form, class users.php');
        }
        if (!filter_var($email_input, FILTER_VALIDATE_EMAIL)) {
            $err_msg .= 'email wrong in Register form, class users.php';
        } else {
            $DB = new db_pdo();
            $record = $DB->querySelect("SELECT * FROM users WHERE email='".$_POST['email']."'");
            if (count($record) == 0) {
                $user_found = false;
            } else {
                $user_found = true;
            }
        }
        //password
        if (isset($_POST['pw'])) {
            $pw_input = $_POST['pw'];
        } else {
            crash(500, 'pw2 not found in Register form, class users.php');
        }
        // password2
        if (isset($_POST['pw2'])) {
            $pw2_input = $_POST['pw2'];
        } else {
            crash(500, 'pw2 not found in Register form, class users.php');
        }

        //password check
        if (strlen($pw_input) != 8) {
            $err_msg .= 'Password must be 8 characters long ';
        }

        //password check 2
        if (strlen($pw2_input) != 8) {
            $err_msg .= 'Password must be 8 characters long ';
        } elseif ($pw2_input != $pw_input) {
            $err_msg .= 'Both password not match';
        }

        // fullname
        // if (!isset($_POST['fullname'])) {
        //     crash(500, 'fullname not found in from register, class users.php');
        // }

        // address line1
        // $interests = $_POST['interests'];
        // var_dump($interests);
        // echo 'interet 0='.$_POST['interests'][0].'<br>';
        // echo 'interet 1='.$_POST['interests'][1].'<br>';
        // data problem
        if ($err_msg != '') {
            // display form with error message and values previously entered
            $err_msg .= '<br>Please try again';
            $this->RegisterFormDisplay($err_msg, $_POST);
        }

        if (!$user_found) {
            //All ok

            $result = Picture_Save_File('user_pic', 'user_image/');
            if ($result === 'ok') {
                $file_name = basename($_FILES['user_pic']['name']);
                //var_dump($file_name);
                $query = 'INSERT INTO users (fullname,address_line1,address_line2,city,province,postal_code,lang,other_lang,email,pw,spam_ok,user_pic) VALUES("'.$_POST['fullname'].'","'.$_POST['address_line1'].'","'.$_POST['address_line2'].'","'.$_POST['city'].'","'.$_POST['province'].'","'.$_POST['postal_code'].'","'.$_POST['lang'].'","'.$_POST['other_lang'].'","'.$_POST['email'].'","'.$_POST['pw'].'",'.$_POST['spam_ok'].',"'.$file_name.'")';
                $DB->query($query);
                $page = new web_page();
                $page->title = 'Welcome To';
                $page->content = 'You are registered- '.$_POST['fullname'];
                $page->render();
            } else {
                $err_msg .= $result;
                $this->RegisterFormDisplay($err_msg, $_POST);
            }
        } else {
            // display form with error message and values previously entered
            $this->LoginPageDisplay('user already exist', $_POST);
        }
    }

    //==================================Logout()=========================================
    public function Logout()
    {
        $_SESSION['user_connected'] = null;
        $_SESSION['user_email'] = null;
        $_SESSION['user_name'] = null;
        $_SESSION['user_id'] = null;
        $_SESSION['user_level'] = null;
        $_SESSION['user_pic'] = null;

        // display home page
        HomePage();
    }

    //=============================users data to json format=========================================
    public function UsersWebService()
    {
        $DB = new db_pdo();
        $products = $DB->table('users');
        $productsJson = json_encode($products, JSON_PRETTY_PRINT);
        $content_type = 'Content-Type: application/json; charset=UTF-8';
        header($content_type);
        http_response_code(200);
        echo $productsJson; // output the data in json format
    }
}
