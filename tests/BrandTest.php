<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once 'src/Brand.php';
    require_once 'src/Store.php';

    $server = 'mysql:host=localhost:8889;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
    class BrandTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Brand::deleteAll();
            Store::deleteAll();
        }

        function test_getName()
        {
            // Arrange
            $name = 'Nike';
            $test_brand = new Brand($name);

            // Act
            $result = $test_brand->getName();

            // Assert
            $this->assertEquals($name, $result);
        }

        function test_getId()
        {
            // Arrange
            $name = 'Nike';
            $id = 1;
            $test_brand = new Brand($name, $id);

            // Act
            $result = $test_brand->getId();

            // Assert
            $this->assertEquals($id, $result);
        }

        function test_setName()
        {
            // Arrange
            $name = 'Nike';
            $test_brand = new Brand($name);

            $update_name = 'Nike, Inc.';

            // Act
            $test_brand->setName($update_name);
            $result = $test_brand->getName();

            // Assert
            $this->assertEquals($update_name, $result);
        }

        function test_save()
        {
            // Arrange
            $name = 'Nike';
            $test_brand = new Brand($name);

            // Act
            $test_brand->save();
            $result = Brand::getAll();

            // Assert
            $this->assertEquals([$test_brand], $result);
        }

        function test_getAll()
        {
            // Arrange
            $name = 'Nike';
            $test_brand = new Brand($name);
            $test_brand->save();

            $name2 = 'Adidas';
            $test_brand2 = new Brand($name2);
            $test_brand2->save();

            // Act
            $result = Brand::getAll();

            // Assert
            $this->assertEquals([$test_brand, $test_brand2], $result);
        }

        function test_deleteAll()
        {
            // Arrange
            $name = 'Nike';
            $test_brand = new Brand($name);
            $test_brand->save();

            $name2 = 'Adidas';
            $test_brand2 = new Brand($name2);
            $test_brand2->save();

            // Act
            Brand::deleteAll();
            $result = Brand::getAll();

            // Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            // Arrange
            $name = 'Nike';
            $test_brand = new Brand($name);
            $test_brand->save();

            $name2 = 'Adidas';
            $test_brand2 = new Brand($name2);
            $test_brand2->save();

            // Act
            $id2 = $test_brand2->getId();
            $result = Brand::find($id2);

            // Assert
            $this->assertEquals($test_brand2, $result);
        }

        function test_delete()
        {
            // Arrange
            $name = 'Nike';
            $test_brand = new Brand($name);
            $test_brand->save();

            $name2 = 'Adidas';
            $test_brand2 = new Brand($name2);
            $test_brand2->save();

            // Act
            $test_brand->delete();
            $result = Brand::getAll();

            // Assert
            $this->assertEquals([$test_brand2], $result);
        }

        function test_update()
        {
            // Arrange
            $name = 'Nike';
            $test_brand = new Brand($name);
            $test_brand->save();

            $update_name = 'Nike, Inc.';

            // Act
            $test_brand->update($update_name);
            $result = $test_brand->getName();

            // Assert
            $this->assertEquals($update_name, $result);
        }

        function test_addStore()
        {
            // Arrange
            $brand_name = 'Nike';
            $test_brand = new Brand($brand_name);
            $test_brand->save();

            $store_name = 'Road Runner Sports';
            $test_store = new Store($store_name);
            $test_store->save();

            // Act
            $test_brand->addStore($test_store);
            $result = $test_brand->getStores();

            // Assert
            $this->assertEquals([$test_store], $result);
        }

        function test_getStores()
        {
            // Arrange
            $brand_name = "Nike";
            $test_brand = new Brand($brand_name);
            $test_brand->save();

            $store_name = 'Foot Traffic';
            $test_store = new Store($store_name);
            $test_store->save();
            $test_brand->addStore($test_store);

            $store_name2 = 'Road Runner Sports';
            $test_store2 = new Store($store_name2);
            $test_store2->save();
            $test_brand->addStore($test_store2);

            // Act
            $result = $test_brand->getStores();

            // Assert
            $this->assertEquals([$test_store, $test_store2], $result);
        }



    }
?>
