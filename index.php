<?php

require_once "App/Config/Setup.php";
require_once "App/Config/Config.php";

use App\Controllers\FrontendController;
use App\Controllers\ProductController;

$frontendController = new FrontendController();
$productsController = new ProductController();


if(isset($_GET['page'])){
    switch ($_GET['page']){
        case 'home':
            $frontendController->homePage();
            break;
        case 'getAllProductsLeft':
            $productsController->getAllProductsLeft();
            break;
        case 'getAllProductsRight':
            $productsController->getAllProductsRight();
            break;
        case 'moveToRight':
            $productsController->moveToRight();
            break;
        case 'moveToLeft':
            $productsController->moveToLeft();
            break;
        case 'addCheckbox':
            $productsController->addCheckbox();
            break;
        case 'sendRequest':
            $productsController->deleteProducts();
            break;
        default:
            $frontendController->homePage();
            break;
    }
} else {
    $frontendController->homePage();
}

