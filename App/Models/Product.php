<?php
/*
* @created 27/03/2020 - 12:54 PM
* @author flippy
*/

namespace App\Models;
use App\Config\Database;

class Product
{

    private $database;
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function getAllProductsLeft($idProductsArray) {
        if (count($idProductsArray)) {
            $queryParams = [];
            $values = [];

            foreach($idProductsArray as $idProd){
                $queryParams[] = "?";

                $values[] = $idProd;
            }

            $query = "SELECT * FROM product WHERE id_product NOT IN (". implode(',', $queryParams) .")";
            return $this->database->executeAll($query, $values);

        } else {
            return $this->database->queryGet("SELECT * FROM product");
        }
    }
    public function getAllProductsRight($idProductsArray) {
        if (count($idProductsArray)) {
            $queryParams = [];
            $values = [];

            foreach($idProductsArray as $idProd){
                $queryParams[] = "?";

                $values[] = $idProd;
            }

            $query = "SELECT * FROM product WHERE id_product IN (". implode(',', $queryParams) .")";
            return $this->database->executeAll($query, $values);

        } else {
            return [];
        }
    }

    public function addProduct($product) {
        $param = [$product];
        $query = "INSERT INTO product VALUES (null, ?)";

        $this->database->insert_update($query, $param);
    }
    public function deleteProducts($idProductsArray) {
        $queryParams = [];
        $values = [];

        foreach($idProductsArray as $idProd){
            $queryParams[] = "?";

            $values[] = $idProd;
        }

        $query = "DELETE FROM product WHERE id_product IN (". implode(',', $queryParams) .")";
        $this->database->insert_update($query, $values);
    }
}