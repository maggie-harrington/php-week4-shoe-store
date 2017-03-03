<?php
    class Store
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
            $GLOBALS['DB']->exec("INSERT INTO stores (name) VALUES ('{$this->getName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_stores = $GLOBALS['DB']->query("SELECT * FROM stores");
            $all_stores_array = array();
            foreach($returned_stores as $store)
            {
                $name = $store['name'];
                $id = $store['id'];
                $new_store = new Store($name, $id);
                array_push($all_stores_array, $new_store);
            }
            return $all_stores_array;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores");
        }

        static function find($id_to_find)
        {
            $returned_stores = Store::getAll();
            foreach ($returned_stores as $returned_store)
            {
                $returned_id = $returned_store->getId();
                if ($returned_id == $id_to_find)
                {
                    return $returned_store;
                }
            }
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores WHERE id = {$this->getId()};");
        }

        function update($update_name)
        {
            $GLOBALS['DB']->exec("UPDATE stores SET name = '{$update_name}' WHERE id = {$this->getId()};");
            $this->setName($update_name);
        }
    }
?>
