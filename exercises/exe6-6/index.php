
<!-- This is actual important stuff -->
<?php
$index_loaded = true;
require_once 'web_page.php';
require_once 'tools.php';
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
        LoginPageDisplay();
    break;

    case 2:
        LoginPageVerify();
    break;

    case 7:
        // download word document test
        header('Content-type: application/msword');
        header('Content-Disposition: attachment; filename=HTTP_protocol.docx');
    break;

    case 100:
        Product_Display();
        break;

    case 110:
        Products_List();
    break;

    case 111:
        Products_Catalog();
    break;

    default:
       // http_response_code(400); //bad request
    //    header('HTTP/1.0 404 Invalid op code in index.php!');
    //    echo 'Invalid op code in index.php!';
    //    die();

    //redirect to home page
    header('location:index.php');
        break;
}

function Product_Display()
{
    $product = [
    'id' => 0,
    'name' => 'Black Dress',
    'description' => 'Little black evening dress',
    'price' => 99.99,
];
    $page = new web_page();
    $page->title = 'Product '.$product['name'];
    $page->content = array_display($product);
    $page->render();
}

// display home page
function HomePage()
{
    $home_page = new web_page();

    $home_page->title = 'ElectronicScooter.com - Welcome!';
    $home_page->content = '<h1>Welcome my friends!</h1>';
    $home_page->render();
}

function Products_List()
{
    // list of 6 products as it would be retrieved from database
    $products = [
        [
            'id' => 0,
            'name' => 'Red Jersey',
            'description' => 'Manchester United Home Jersey, red, sponsored by Chevrolet',
            'price' => 59.99,
            'pic' => 'red_jersey.jpg',
            'qty_in_stock' => 200,
        ],
        [
            'id' => 1,
            'name' => 'White Jersey',
            'description' => 'Manchester United Away Jersey, white, sponsored by Chevrolet',
            'price' => 49.99,
            'pic' => 'white_jersey.jpg',
            'qty_in_stock' => 133,
        ],
        [
            'id' => 2,
            'name' => 'Black Jersey',
            'description' => 'Manchester United Extra Jersey, black, sponsored by Chevrolet',
            'price' => 54.99,
            'pic' => 'black_jersey.jpg',
            'qty_in_stock' => 544,
        ],
        [
            'id' => 3,
            'name' => 'Blue Jacket',
            'description' => 'Blue Jacket for cold and raniy weather',
            'price' => 129.99,
            'pic' => 'blue_jacket.jpg',
            'qty_in_stock' => 14,
        ],
        [
            'id' => 4,
            'name' => 'Snapback Cap',
            'description' => 'Manchester United New Era Snapback Cap- Adult',
            'price' => 24.99,
            'pic' => 'cap.jpg',
            'qty_in_stock' => 655,
        ],
        [
            'id' => 5,
            'name' => 'Champion Flag',
            'description' => 'Manchester United Champions League Flag',
            'price' => 24.99,
            'pic' => 'champion_league_flag.jpg',
            'qty_in_stock' => 321,
        ],
    ];
    $page = new web_page();
    $page->title = 'Product List- Electric Scooter.Inc';
    $page->content = multiple_arrayDisplay($products);
    $page->render();
}

/**
 * Product Catalog Page.
 */
function Products_Catalog()
{
    // list of 6 products as it would be retrieved from database
    $products = [
        [
            'id' => 0,
            'name' => 'Red Jersey',
            'description' => 'Manchester United Home Jersey, red, sponsored by Chevrolet',
            'price' => 59.99,
            'pic' => 'red_jersey.jpg',
            'qty_in_stock' => 200,
        ],
        [
            'id' => 1,
            'name' => 'White Jersey',
            'description' => 'Manchester United Away Jersey, white, sponsored by Chevrolet',
            'price' => 49.99,
            'pic' => 'white_jersey.jpg',
            'qty_in_stock' => 133,
        ],
        [
            'id' => 2,
            'name' => 'Black Jersey',
            'description' => 'Manchester United Extra Jersey, black, sponsored by Chevrolet',
            'price' => 54.99,
            'pic' => 'black_jersey.jpg',
            'qty_in_stock' => 544,
        ],
        [
            'id' => 3,
            'name' => 'Blue Jacket',
            'description' => 'Blue Jacket for cold and raniy weather',
            'price' => 129.99,
            'pic' => 'blue_jacket.jpg',
            'qty_in_stock' => 14,
        ],
        [
            'id' => 4,
            'name' => 'Snapback Cap',
            'description' => 'Manchester United New Era Snapback Cap- Adult',
            'price' => 24.99,
            'pic' => 'cap.jpg',
            'qty_in_stock' => 655,
        ],
        [
            'id' => 5,
            'name' => 'Champion Flag',
            'description' => 'Manchester United Champions League Flag',
            'price' => 24.99,
            'pic' => 'champion_league_flag.jpg',
            'qty_in_stock' => 321,
        ],
    ];
    $page = new web_page();
    $page->title = 'Product Catalog- Electric Scooter.Inc';
    $page->content = catalog($products);
    $page->render();
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
        $r .= '</div>';
    }

    return $r;
}

/**
 * Login page display.
 */
function LoginPageDisplay()
{
    $LoginPage = new web_page();
    $LoginPage->title = 'Please login';
    $LoginPage->content = <<<HTML
    <form action="index.php?op=2" method="POST">
    <!-- <input type="hidden" name="op" value="2"> -->
    <input type="email" name="email" required maxlength="126" size="25" placeholder="Email"><br>
    <input type="password" name="pw" required maxlength="8" placeholder="Password"><br>
    <input type="submit" value="Continue">
    </form>
    HTML;
    $LoginPage->render();
}

function LoginPageVerify()
{
    // would come from db query
    $users = [
        ['id' => 0, 'email' => 'abc@test.com', 'pw' => '12345678'],
        ['id' => 1, 'email' => 'dfg@test.com', 'pw' => '12345678'],
        ['id' => 2, 'email' => 'sdf@test.com', 'pw' => '11111111'],
    ];
    $email_input = $_POST['email'];
    $pw_input = $_POST['pw'];
    // var_dump($_POST);
    // echo $email_input.'<br>';
    // echo $pw_input.'<br>';
    foreach ($users as $id) {
        if ($email_input == $id['email'] & $pw_input == $id['pw']) {
            echo 'Hello! you are logged in';
            break;
        } else {
            echo 'Error! please fill form.<br>';
            echo '<a href="index.php?op=1">Return</a>';
        }
    }
}
