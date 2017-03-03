<?php
    class Brand
    {
        private $name;
        private $id;

        function __construct($name, $id = null)
        {
            $this->name = $name;
            $this->id = $id;
        }

        function getName()
        {
            return $this->name;
        }

        function getId()
        {
            return $this->id;
        }

        function setName($new_name)
        {
            $this->name = $new_name;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO brands (name) VALUES ('{$this->getName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_brands = $GLOBALS['DB']->query("SELECT * FROM brands");
            $all_brands_array = array();
            foreach($returned_brands as $brand)
            {
                $name = $brand['name'];
                $id = $brand['id'];
                $new_brand = new Brand($name, $id);
                array_push($all_brands_array, $new_brand);
            }
            return $all_brands_array;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM brands");
        }

        static function find($id_to_find)
        {
            $returned_brands = Brand::getAll();
            foreach ($returned_brands as $returned_brand)
            {
                $returned_id = $returned_brand->getId();
                if ($returned_id == $id_to_find)
                {
                    return $returned_brand;
                }
            }
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM brands WHERE id = {$this->getId()};");
        }

    }
?>
