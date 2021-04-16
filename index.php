
<!-- This is actual important stuff -->
<?php
session_start();
$index_loaded = true;
require_once 'web_page.php';
require_once 'tools.php';
require_once 'products.php';
require_once 'users.php';

$_SESSION['login_count'] = 0;
if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = 0;
}

switch ($op) {
    case 0:
        HomePage();
        break;

        case 1:
            if (isset($_SESSION['login_count']) and $_SESSION['login_count'] > 3) {
                $page = new web_page();
                $page->title = 'You are blocked';
                $page->content = 'You reached the max login attemp. Please visit later to try agin';
                $page->render();
            } else {
                $user = new users();
                $user->LoginPageDisplay();
            }
    break;

    case 2:
        $user = new users();
        $user->LoginPageVerify();
    break;

    case 3:
        $user = new users();
        $user->RegisterFormDisplay();
    break;

    case 4:
        $user = new users();
        $user->RegisterFormVerify();
    break;

    case 5:
        $user = new users();
        $user->Logout();
    break;

    case 15:
        $user = new users();
        $user->UsersWebService();
    break;

    case 7:
        // download word document test
        header('Content-type: application/msword');
        header('Content-Disposition: attachment; filename=HTTP_protocol.docx');
    break;

    case 100:
        $product = new products();
        $product->Product_Display();
        break;

    case 110:
        $product = new products();
        $product->Products_List();
    break;

    case 111:
        $product = new products();
        if (isset($_POST['search'])) {
            $search = $_POST['search'];
        } else {
            $search = '';
        }
        $product->Products_Catalog($search);
    break;

    case 115:
        $prod = new products();
        $prod->ProductsWebService();
    break;

    case 116:
        $prod = new products();
        $prod->ProductEditAddForm();
    break;

    case 117:
        $prod = new products();
        $prod->ProductEditAddFormVerify();
    break;

    case 118:
        $prod = new products();
        $prod->ProductEditAddFormVerify();
    break;

    case 50:
        if ($_SESSION['user_level'] == 'employee') {
            DisplayServerErrorLogs();
        } else {
            echo 'you are unauthorized';
        }
    break;

    case 51:
        $DB = new db_pdo();
        //$users = $DB->querySelect('SELECT * from users');
        $users = $DB->table('users');
        $table = table_display($users);
        $page = new web_page();
        $page->content = $table;
        $page->render();
    break;

    default:
    crash(400, 'Invalid op code in index.php');
       // http_response_code(400); //bad request
    //    header('HTTP/1.0 404 Invalid op code in index.php!');
    //    echo 'Invalid op code in index.php!';
    //    die();

    //redirect to home page
    //header('location:index.php');
        break;
}

// display home page
function HomePage()
{
    $home_page = new web_page();

    $home_page->title = 'Welcome!';
    $home_page->content = '<h1>Welcome my friends!</h1>';
    $home_page->render();
}

function DisplayServerErrorLogs()
{
    $page = new web_page();
    $page->title = 'Server error logs';
    $page->content = '';
    //get file content
    $page->content .= file_get_contents('logs/errors.log');
    $page->render();
}
