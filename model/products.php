<?php
require_once("base.php");

class Products extends Base
{
    public function get() {

        $query = $this->db->prepare("
            SELECT p.product_id, p.name, c.name AS category
            FROM products p
            INNER JOIN categories c USING(category_id)
        ");

        $query->execute();

        return $query->fetchAll( PDO::FETCH_ASSOC );
    }

    public function getItem($id) {

        $query = $this->db->prepare("
            SELECT
                p.product_id, p.name, c.name AS category,
                p.description, p.price, p.image, p.stock
            FROM products p
            INNER JOIN categories c USING(category_id)
            WHERE p.product_id = ?
        ");

        $query->execute([ $id ]);

        return $query->fetch( PDO::FETCH_ASSOC );
    }

    public function getProducts($category_id) {

        $query = $this->db->prepare("
            SELECT p.product_id, p.name, c.name AS category
            FROM products p
            INNER JOIN categories c USING(category_id)
            WHERE p.category_id = ?
        ");

        $query->execute([ $category_id ]);

        return $query->fetchAll( PDO::FETCH_ASSOC );
    }

    public function getProduct($product_id) {

        $query = $this->db->prepare("
            SELECT product_id, name, description, price, image, stock
            FROM products
            WHERE product_id = ?
        ");

        $query->execute([ $product_id ]);

        return $query->fetch( PDO::FETCH_ASSOC );
    }

    public function getProductWithinStock( $product_id, $quantity ) {
        $query = $this->db->prepare("
            SELECT name, price
            FROM products
            WHERE product_id = ?
              AND stock >= ?
              AND ? > 0
        ");

        $query->execute([
            $product_id,
            $quantity,
            $quantity
        ]);

        return $query->fetch( PDO::FETCH_ASSOC );
    }

    public function updateStock( $item ) {
        $query = $this->db->prepare("
            UPDATE products
            SET stock = stock - ?
            WHERE product_id = ?
        ");

        return $query->execute([
            $item["quantity"],
            $item["product_id"]
        ]);
    }

    public function create($data) {
        
        $data = $this->sanitize($data);

        if( !$this->validator($data) ) {
            return false;
        }

        $imageName = $this->uploadBase64Image( $data["image"] ?? "" );

        $query = $this->db->prepare("
            INSERT INTO products
            (name, description, price, stock, category_id, image)
            VALUES(?, ?, ?, ?, ?, ?)
        ");

        return $query->execute([
            $data["name"],
            $data["description"],
            $data["price"],
            $data["stock"],
            $data["category_id"],
            $imageName
        ]);
    }

    public function update($id, $data) {
        $data = $this->sanitize($data);

        if(!$this->validator($data)) {
            return false;
        }

        $imageName = $this->uploadBase64Image( $data["image"] ?? "" );

        $query = $this->db->prepare("
            UPDATE
                products 
            SET
                name = ?,
                description = ?,
                price = ?,
                stock = ?,
                category_id = ?,
                image = (CASE WHEN ? <> '' THEN ? ELSE image END)
            WHERE
                product_id = ?
        ");

        return $query->execute([
            $data["name"],
            $data["description"],
            $data["price"],
            $data["stock"],
            $data["category_id"],
            $imageName,
            $imageName,
            $id
        ]);
    }

    public function delete($id, $api_key) {
        $query = $this->db->prepare("
            DELETE FROM products
            WHERE product_id = ?
        ");
        
        return $query->execute([
            $id
        ]);
    }

    public function validator($data) {
        if(
            empty($data["name"]) ||
            empty($data["description"]) ||
            empty($data["price"]) ||
            empty($data["stock"]) ||
            empty($data["category_id"]) ||
            mb_strlen($data["name"]) > 128 ||
            mb_strlen($data["description"]) > 65535 ||
            !is_numeric($data["price"]) ||
            !is_numeric($data["stock"]) ||
            !is_numeric($data["category_id"]) ||
            $data["price"] < 0 ||
            $data["stock"] < 0 ||
            $data["category_id"] < 0
        ) {
            return false;
        }

        return true;
    }

    public function uploadBase64Image($image) {
        
        if( empty($image) || empty(base64_decode($image)) ) {
            return "";
        }

        // desconverter de texto para binário
        $imageData = base64_decode($image);

        // definir localização e nome para guardar
        $imageName = bin2hex(random_bytes(32)) . ".jpg";
        $imagePath = rtrim($_SERVER['DOCUMENT_ROOT'], "/") . dirname($_SERVER["SCRIPT_NAME"]) . "/images/" . $imageName;

        // criar um ficheiro vazio nessa localização e adicionar o binário da imagem
        file_put_contents($imagePath, $imageData);

        // preparar a camada de validação de ficheiros
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $detected_filetype = finfo_file($finfo, $imagePath);

        // validar se realmente é uma imagem, apagar caso não seja
        if($detected_filetype !== "image/jpeg") {
            unlink( $imagePath );
            $imageName = "";
        }

        return $imageName;
    }
}



