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

        function update($update_name)
        {
            $GLOBALS['DB']->exec("UPDATE brands SET name = '{$update_name}' WHERE id = {$this->getId()};");
            $this->setName($update_name);
        }

        function addStore($store)
        {
            $GLOBALS['DB']->exec("INSERT INTO brands_stores (brand_id, store_id) VALUES ({$this->getId()}, {$store->getId()});");
        }

        function getStores()
        {
            $returned_stores_array = array();
            $all_stores_array = $GLOBALS['DB']->query("SELECT stores.* FROM brands
                JOIN brands_stores ON (brands_stores.brand_id = brands.id)
                JOIN stores ON (stores.id = brands_stores.store_id)
                WHERE brands.id = {$this->getId()}");
            foreach ($all_stores_array as $store) {
                $name = $store['name'];
                $id = $store['id'];
                $store_to_add = new Store($name, $id);
                array_push($returned_stores_array, $store_to_add);
            }
            return $returned_stores_array;
        }

    }
?>
