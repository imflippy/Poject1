<?php
/*
* @created 27/03/2020 - 12:52 PM
* @author flippy
*/

namespace App\Controllers;

use App\Config\Database;
use App\Models\Product;


class ProductController extends Controller
{
    private $modelProduct;
    public function __construct()
    {
        $this->modelProduct = new Product(Database::instance());
    }


    public function getAllProductsLeft() {
        $idProductsArray = null;
        try {
            if (isset($_SESSION['products'])){
                $idProductsArray = $_SESSION['products'];
            } else {
                $idProductsArray = [];
            }
            $products = $this->modelProduct->getAllProductsLeft($idProductsArray);
            $this->json($products);
        } catch (\PDOException $ex) {
            $this->json($ex->getMessage(), 500);
        }
    }

    public function getAllProductsRight() {
        $idProductsArray = null;
        try {
            if (isset($_SESSION['products'])){
                $idProductsArray = $_SESSION['products'];
            } else {
                $idProductsArray = [];
            }
            $products = $this->modelProduct->getAllProductsRight($idProductsArray);
            $this->json($products);
        } catch (\PDOException $ex) {
            $this->json($ex->getMessage(), 500);
        }
    }

    public function moveToRight() {
       if (!isset($_POST['products'])){
           $this->json(null, 422);
           exit;
       }
        $arrayForSession = [];
       if (isset($_SESSION['products']) && count($_SESSION['products'])) {
           foreach ($_SESSION['products'] as $p) {
               $arrayForSession[] = $p;
           }
       }
        $productsArray = $_POST['products'];

       foreach ($productsArray as $p) {
            $arrayForSession[] = $p;
       }

        $_SESSION['products'] = $arrayForSession;
    }
    public function moveToLeft() {
       if (!isset($_POST['products'])){
           $this->json(null, 422);
           exit;
       }
        $arrayForSession = [];
        $productsArray = $_POST['products'];

       foreach ($_SESSION['products'] as $p) {
            if (!in_array($p, $productsArray)){
                $arrayForSession[] = $p;
            }
       }
        $_SESSION['products'] = $arrayForSession;
    }

    public function addCheckbox() {
        try {
            $this->modelProduct->addProduct($this->randomName());
            $this->json('Gj Added', 201);
        } catch (\PDOException $ex) {
            $this->json($ex->getMessage(), 500);
        }
    }
    private function randomName() {
        $names = array(
            "Aaron", "Abbey", "Abbie", "Abby", "Abdul", "Abe", "Abel", "Abigail", "Abraham","Abram", "Ada", "Adah", "Adalberto", "Adaline", "Burma", "Burt", "Burton", "Buster", "Byron", "Caitlin", "Caitlyn", "Calandra", "Caleb", "Calista", "Callie",
            "Calvin", "Camelia", "Deandrea", "Deane", "Deangelo", "Deann", "Deanna", "Gaston","Gavin","Gay", "Gaye", "Gayla", "Gayle", "Gayle", "Gaylene", "India", "Indira", "Inell", "Ines", "Inez", "Inga", "Inge", "Ingeborg",
            "Inger", "Ingrid", "Inocencia", "Iola", "Iona", "Ione", "Ira", "Ira", "Jeromy","Jerrell", "Jerri", "Jerrica", "Jerrie", "Jerrod", "Jerrold", "Jerry", "Jerry", "Jesenia", "Jesica", "Jess", "Jesse", "Jesse", "Jessenia", "Jessi"
        );
        return $names[rand ( 0 , count($names) -1)];
    }

    public function deleteProducts() {
        if (!isset($_POST['products'])){
            $this->json(null, 422);
            exit;
        }

        try {
            $this->modelProduct->deleteProducts($_POST['products']);
            $this->json('Deleted', 204);
        } catch (\PDOException $ex) {
            $this->json($ex->getMessage(), 500);
        }

    }
}