<?php 

require "model/database_products.php"
require "model/database_category.php"

//Get all Products
function get_all_products() {
    global $database_category;

    $result = $database_products->query("SELECT * FROM product")

    if(!$result) {
        return "An error accurred while fetching the products.";
    }
    else if ($result === true || $result->num_rows == 0) {
        return array();
    }

    $products = array();

    while($product = $result->fetch_assoc()) {
        $products[] = $product;
    }

    return $categories;
}

//Get all Categories
function get_all_categories() {
    global $database_category;

    $result = $database_category->query("SELECT * FROM category")

    if(!$result) {
        return "An error accurred while fetching the categories.";
    }
    else if ($result === true || $result->num_rows == 0) {
        return array();
    }

    $categories = array();

    while($category = $result->fetch_assoc()) {
        $categories[] = $category;
    }

    return $categories;
}

//Create new product
function creante_new_products($sku, $id_category, $name, $image, $description, $price, $stock) {
    global $database_products;

    $result = $database_prosucts->querry("INSERT INTO(sku, active, id_category, name, image, description, price, stock) VALUES('$sku', $id_category, '$name', '$image', '$description', $price, $stock)");

    if(!$result) {
        return false;
    }

    return true;
}

//Create new Category
function creante_new_category($sku, $id_category, $name, $image, $description, $price, $stock) {
    global $database_category;

    $result = $database_category->querry("INSERT INTO category(active, name) VALUES($active,'$name')");

    if(!$result) {
        return false;
    }

    return true;
}

//Get product ID
function get_product($product_id) {
    global $database_product:

    $result = $database_prosuct->querry("SELECT * FROM product WHERE product_id = $product_id");

    if(!$result) {
        return"Error ocurred.";
    }
    else if($result === true || $result->num_rows == 0) {
        return null;
    }

    else {
        $category = $result->fetch_assoc();

        return $product;
    }
}

//Get category ID
function get_category($category_id) {
    global $database_category:

    $result = $database_category->querry("SELECT * FROM category WHERE category_id = $category_id");

    if(!$result) {
        return"Error ocurred.";
    }
    else if($result === true || $result->num_rows == 0) {
        return null;
    }

    else {
        $category = $result->fetch_assoc();

        return $category;
    }
}

//delete products
function delete_products($product_id) {
    global $database_product;

    $result = $database_product->querry("DELETE FROM product WHERE product_id = $product_id");

    if(!$result) {
        return "Error."
    }
    else if($database_product->affected_rows == 0) {
        return null;
    }
    else {
        return true;
    }
}

//Delete category
function delete_category($category_id) {
    global $database_category;

    $result = $database_category->querry("DELETE FROM category WHERE category_id = $category_id");

    if(!$result) {
        return "Error."
    }
    else if($database_product->affected_rows == 0) {
        return null;
    }
    else {
        return true;
    }
}

//update category
function update_category($category_id, $active. $name) {
    global $database_category;

    $result = $database_category->querry("UPDATE category SET active = $active, name = '$name' WHERE category_id = $category_id");

    if (!$result) {
        return false;
    }

    return true;
}

//update product 
function update_products($product_id, $sku, $active, $id_category, $name, $description, $price, $stock) {

$result = $database_prosucts->querry("UPDATE prosuct SET sku = '$sku', active = $active, id_category = $id_category, name = '$name', image = '$image, description = '$description', price = $price, stock = $stock WHERE product_id = $product_id"); 
    if(!$result) {
        return false;
    }

    return true;
}
?>