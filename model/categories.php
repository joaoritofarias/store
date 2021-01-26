<?php
require("base.php");

class Categories extends Base
{
    public function get() {

        $query = $this->db->prepare("
            SELECT category_id, name
            FROM categories
            WHERE parent_id = 0
        ");

        $query->execute();

        return $query->fetchAll( PDO::FETCH_ASSOC );
    }

    public function getSubcategories($parent_id) {

        $query = $this->db->prepare("
            SELECT c1.category_id, c1.name, c2.name AS parent_name 
            FROM categories c1
            INNER JOIN categories c2 ON(c1.parent_id = c2.category_id)
            WHERE c1.parent_id = ?
        ");

        $query->execute([ $parent_id ]);

        return $query->fetchAll( PDO::FETCH_ASSOC );

    }

    public function getItem($id) {

        $query = $this->db->prepare("
            SELECT c1.category_id, c1.name, c2.name AS parent_name 
            FROM categories c1
            LEFT JOIN categories c2 ON(c1.parent_id = c2.category_id)
            WHERE c1.category_id = ?
        ");

        $query->execute([ $id ]);

        return $query->fetch( PDO::FETCH_ASSOC );
    }

    public function create($data) {

        $data = $this->sanitize($data);

        if(!$this->validator($data)) {
            return false;
        }

        $query = $this->db->prepare("
            INSERT INTO categories
            (name, parent_id)
            VALUES(?, ?)
        ");
        
        return $query->execute([
            $data["name"],
            $data["parent_id"]
        ]);
    }

    public function update($id, $data) {
        $data = $this->sanitize($data);

        if(!$this->validator($data)) {
            return false;
        }

        $query = $this->db->prepare("
            UPDATE categories
            SET name = ?,
                parent_id = ?
            WHERE category_id = ?
        ");
        
        return $query->execute([
            $data["name"],
            $data["parent_id"],
            $id
        ]);
    }

    public function delete($id, $api_key) {
        $query = $this->db->prepare("
            DELETE FROM categories
            WHERE category_id = ?
        ");

        return $query->execute([
            $id
        ]);
    }

    public function validator($data) {
        if(
            empty($data["name"]) ||
            mb_strlen($data["name"]) > 64 ||
            !is_numeric($data["parent_id"]) ||
            $data["parent_id"] < 0
        ) {
            return false;
        }

        return true;
    }
}






