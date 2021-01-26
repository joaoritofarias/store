<?php
require_once("base.php");

class Orders extends Base
{
    public function create( $cart ) {

        if(isset($cart["api_key"])) {
            $result = $this->isValidUser( $cart["api_key"] );
            $user_id = $result["user_id"];
        }
        else {
            $user_id = $_SESSION["user_id"];
        }

        $query = $this->db->prepare("
            INSERT INTO orders
            (user_id)
            VALUES(?)
        ");
        
        $query->execute([ $user_id ]);

        $order_id = $this->db->lastInsertId();

        $this->insertOrderProducts($order_id, $cart);

        return $order_id;
    }

    public function update($id, $data) {
        // validar que a encomenda é deste utilizador e que ainda não foi paga
        $query = $this->db->prepare("
            SELECT order_id
            FROM orders
            WHERE order_id = ?
              AND payment_date IS NULL
              AND user_id IN(
                SELECT user_id
                FROM users
                WHERE api_key = ?
              )
        ");
        $query->execute([
            $id,
            $data["api_key"]
        ]);

        $order = $query->fetch( PDO::FETCH_ASSOC );

        if(!empty($order)) {
            // delete das linhas encomenda existentes
            $query = $this->db->prepare("
                DELETE FROM orders_products
                WHERE order_id = ?
            ");
            $query->execute([ $id ]);
            
            // inserir cada um dos registos recebidos, sejam novos ou alterados
            $this->insertOrderProducts($id, $data);

            return true;
        }

        return false;
    }

    public function delete($id, $api_key) {

        $query = $this->db->prepare("
            DELETE FROM orders_products
            WHERE order_id = ?
              AND order_id IN(
                  SELECT order_id
                  FROM orders
                  WHERE payment_date IS NULL
                    AND user_id IN(
                      SELECT user_id
                      FROM users
                      WHERE api_key = ?
                  )
              )
        ");

        $query->execute([
            $id,
            $api_key
        ]);

        $query = $this->db->prepare("
            DELETE FROM orders
            WHERE order_id = ?
              AND payment_date IS NULL
              AND user_id IN(
                  SELECT user_id
                  FROM users
                  WHERE api_key = ?
              )
        ");

        return $query->execute([
            $id,
            $api_key
        ]);
    }

    public function insertOrderProducts($order_id, $products) {
        require("products.php");
        $productsModel = new Products;

        foreach($products as $item) {

            $product = [];
            if( isset($item["product_id"]) ) {
                $product = $productsModel->getProductWithinStock( $item["product_id"], $item["quantity"] );
            }

            if( !empty($product) ) {

                $query = $this->db->prepare("
                    INSERT INTO orders_products
                    (order_id, product_id, quantity, price)
                    VALUES(?, ?, ?, ?)
                ");
                
                $query->execute([
                    $order_id,
                    $item["product_id"],
                    $item["quantity"],
                    $product["price"]
                ]);

                $productsModel->updateStock( $item );
            }   
        }

        return null;
    }
    
}
