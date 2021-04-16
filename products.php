<?php

require_once 'db_pdo.php';
if (!isset($index_loaded)) {
    die('Direct acces to this file is forbidden');
}
class products
{
    public function Product_Display()
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

    public function Products_List()
    {
        // list of 6 products as it would be retrieved from database
        $DB = new db_pdo();
        $products = $DB->table('products');

        $page = new web_page();
        $page->title = 'Product List';
        $page->content = '';
        $page->content .= table_display($products);
        //$page->content = multiple_arrayDisplay($products);
        $page->render();
    }

    /**
     * Product Catalog Page.
     */
    public function Products_Catalog($search = '')
    {
        // list of 6 products as it would be retrieved from database
        $DB = new db_pdo();
        if ($search == '') {
            $products = $DB->table('products');
        } else {
            //search product by description
            //$desc = 'SELECT * FROM products WHERE description LIKE "%'.$search.'%"';
            //search product by id
            //$desc = 'SELECT * FROM products WHERE id='.$search;
            //$products = $DB->querySelect($desc);

            //products search with value filter
            $sql_str = 'SELECT * FROM products WHERE id=:id_input';
            $params = ['id_input' => $search];
            $products = $DB->querySelectParam($sql_str, $params);
        }

        $page = new web_page();
        $page->title = 'Product Catalog';
        $page->content = '';

        $page->content .= '<form style="display:inline-block float:right" action="index.php?op=111" method="POST">';
        $page->content .= '<input type="text" name="search" value="'.$search.'" placeholder="search">';
        $page->content .= '<input type="submit" value="search">';
        $page->content .= '<a href="index.php?op=111"> or all Products</a>';
        $page->content .= '</form>';
        $page->content .= '<form style="display:inline-block float:right" action="index.php?op=116" method="POST">';
        $page->content .= '<br><a href="index.php?op=116"> Add product</a>';
        $page->content .= '</form>';
        if (count($products) == 0) {
            $page->content .= 'No products found';
        }
        $page->content .= catalog($products);
        $page->render();
    }

    public function ProductsWebService()
    {
        $DB = new db_pdo();
        $products = $DB->table('products');
        $productsJson = json_encode($products, JSON_PRETTY_PRINT);
        $content_type = 'Content-Type: application/json; charset=UTF-8';
        header($content_type);
        http_response_code(200);
        echo $productsJson; // output the data in json format
    }

    //=======================ProductEditAddForm()========================
    public function ProductEditAddForm($err_msg = '')
    {
        $DB = new db_pdo();

        if (isset($_GET['id'])) {
            $one_product = $DB->querySelect('SELECT * from products where id ='.$_GET['id']);
            $id_get = $_GET['id'];
            $default_image = $one_product[0]['pic'];
            $default_name = $one_product[0]['name'];
            $default_description = $one_product[0]['description'];
            $default_price = $one_product[0]['price'];
            $default_qty_in_stock = $one_product[0]['qty_in_stock'];
            $button_value = 'Save';
        } else {
            $id_get = '';
            $default_image = '';
            $default_name = '';
            $default_description = '';
            $default_price = '';
            $default_qty_in_stock = '';
            $button_value = 'Add';
        }

        //var_dump($one_product);

        $PorductEditPage = new web_page();
        $PorductEditPage->title = 'Edit Form';
        $PorductEditPage->content = <<<HTML
    <div  class="alert alert-danger" >{$err_msg}</div>
    <form enctype="multipart/form-data" action="index.php?op=117&id={$id_get}" method="POST" style="width:20%; margin:0 auto;" >
    
    <img src="products_images/{$default_image}"  style="width:300px"><br>
    <br>select a picture of you (max 500kb jpg, JPG, gif or png)<br>
    <input type="file" name="thumbnail"> <br>
    
    <label for="name">Name</label><br>
    <input class="form-control" type="text" name="name" maxlength="50" value="{$default_name}" ><br>
    
    <label for="description">Description</label><br>
    <input class="form-control" type="text" name="description"  maxlength="350" value="{$default_description}"><br>
    
    <label for="price">Price</label><br>
    <input class="form-control" type="number" name="price" min="0" step="0.1" value="{$default_price}"><br>
    
    <label for="qty_in_stock">Quantity</label><br>
    <input class="form-control" type="number" name="qty_in_stock" min="0" step="1" value="{$default_qty_in_stock}"><br>
    
    <input  type="submit" value="{$button_value}" class="btn btn-primary"><br><br><br>
    </form>
    HTML;
        $PorductEditPage->render();
    }

    //======================================ProductEditAddFormVerify()====================
    public function ProductEditAddFormVerify()
    {
        $DB = new db_pdo();
        $err_msg = '';
        if (isset($_POST['name'])) {
            $name_input = $_POST['name'];
        } else {
            crash(500, 'email not found in Register form, class users.php');
        }
        if ($_POST['name'] === '') {
            $err_msg .= 'Please enter name';
        }
        if (isset($_POST['description'])) {
            $description_input = $_POST['description'];
        } else {
            crash(500, 'email not found in Register form, class users.php');
        }

        if ($_POST['description'] === '') {
            $err_msg .= 'Please enter description';
        }

        if (isset($_POST['price'])) {
            $price_input = $_POST['price'];
        } else {
            crash(500, 'email not found in Register form, class users.php');
        }
        if ($_POST['price'] === 0) {
            $err_msg .= 'Price can not be 0';
        }
        if (isset($_POST['qty_in_stock'])) {
            $qty_input = $_POST['qty_in_stock'];
        } else {
            crash(500, 'email not found in Register form, class users.php');
        }

        if ($err_msg != '') {
            // display form with error message and values previously entered
            $err_msg .= '<br>Please try again';
            $this->ProductEditForm($err_msg);
        }
        $result = Picture_Save_File('thumbnail', 'products_images/');
        if (!$_GET['id'] == '') {
            if ($result === 'ok') {
                $file_name = basename($_FILES['thumbnail']['name']);
                $query = 'UPDATE products SET name="'.$name_input.'",description ="'.$description_input.'",price='.$price_input.',qty_in_stock ='.$qty_input.', pic="'.$file_name.'" where id='.$_GET['id'];
            //var_dump($query);
            } else {
                $query = 'UPDATE products SET name="'.$name_input.'",description ="'.$description_input.'",price='.$price_input.',qty_in_stock ='.$qty_input.' where id='.$_GET['id'];
            }
        } else {
            if ($result === 'ok') {
                $file_name = basename($_FILES['thumbnail']['name']);
                $query = 'INSERT INTO products (name,description,price,qty_in_stock,pic) VALUES("'.$name_input.'","'.$description_input.'",'.$price_input.','.$qty_input.',"'.$file_name.'")';
            }// else {
            //     $query = 'UPDATE products SET name="'.$name_input.'",description ="'.$description_input.'",price='.$price_input.',qty_in_stock ='.$qty_input.' where id='.$_GET['id'];
            // }
        }
        //var_dump($query);
        $DB->query($query);
        $this->Products_Catalog();
    }
}
