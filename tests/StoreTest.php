<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once 'src/Store.php';
    require_once 'src/Brand.php';

    $server = 'mysql:host=localhost:8889;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
    class StoreTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Store::deleteAll();
            Brand::deleteAll();
        }

        function test_getName()
        {
            // Arrange
            $name = 'Foot Traffic';
            $test_store = new Store($name);

            // Act
            $result = $test_store->getName();

            // Assert
            $this->assertEquals($name, $result);
        }

        function test_getId()
        {
            // Arrange
            $name = 'Foot Traffic';
            $id = 1;
            $test_store = new Store($name, $id);

            // Act
            $result = $test_store->getId();

            // Assert
            $this->assertEquals($id, $result);
        }

        function test_setName()
        {
            // Arrange
            $name = 'Foot Traffic';
            $test_store = new Store($name);

            $update_name = 'Foot Traffic Athletic Shoes';

            // Act
            $test_store->setName($update_name);
            $result = $test_store->getName();

            // Assert
            $this->assertEquals($update_name, $result);
        }

        function test_save()
        {
            // Arrange
            $name = 'Foot Traffic';
            $test_store = new Store($name);

            // Act
            $test_store->save();
            $result = Store::getAll();

            // Assert
            $this->assertEquals([$test_store], $result);
        }

        function test_getAll()
        {
            // Arrange
            $name = 'Foot Traffic';
            $test_store = new Store($name);
            $test_store->save();

            $name2 = 'Road Runner Sports';
            $test_store2 = new Store($name2);
            $test_store2->save();

            // Act
            $result = Store::getAll();

            // Assert
            $this->assertEquals([$test_store, $test_store2], $result);
        }

        function test_deleteAll()
        {
            // Arrange
            $name = 'Foot Traffic';
            $test_store = new Store($name);
            $test_store->save();

            $name2 = 'Road Runner Sports';
            $test_store2 = new Store($name2);
            $test_store2->save();

            // Act
            Store::deleteAll();
            $result = Store::getAll();

            // Assert
            $this->assertEquals([], $result);
        }

        function test_deleteAll_with_brand()
        {
            // Arrange
            $store_name = 'Foot Traffic';
            $test_store = new Store($store_name);
            $test_store->save();

            $name2 = 'Road Runner Sports';
            $test_store2 = new Store($name2);
            $test_store2->save();

            $brand_name = 'Nike';
            $test_brand = new Brand($brand_name);
            $test_brand->save();
            $test_store->addBrand($test_brand);
            $test_store2->addBrand($test_brand);

            // Act
            Store::deleteAll();
            $result = $test_brand->getStores();

            // Assert
            $this->assertEquals([], $result);
        }


        function test_find()
        {
            // Arrange
            $name = 'Foot Traffic';
            $test_store = new Store($name);
            $test_store->save();

            $name2 = 'Road Runner Sports';
            $test_store2 = new Store($name2);
            $test_store2->save();

            // Act
            $id2 = $test_store2->getId();
            $result = Store::find($id2);

            // Assert
            $this->assertEquals($test_store2, $result);
        }

        function test_delete()
        {
            // Arrange
            $name = 'Foot Traffic';
            $test_store = new Store($name);
            $test_store->save();

            $name2 = 'Road Runner Sports';
            $test_store2 = new Store($name2);
            $test_store2->save();

            // Act
            $test_store->delete();
            $result = Store::getAll();

            // Assert
            $this->assertEquals([$test_store2], $result);
        }

        function test_delete_with_brand()
        {
            // Arrange
            $store_name = 'Foot Traffic';
            $test_store = new Store($store_name);
            $test_store->save();

            $name2 = 'Road Runner Sports';
            $test_store2 = new Store($name2);
            $test_store2->save();

            $brand_name = 'Nike';
            $test_brand = new Brand($brand_name);
            $test_brand->save();
            $test_store->addBrand($test_brand);
            $test_store2->addBrand($test_brand);

            // Act
            $test_store->delete();
            $result = $test_brand->getStores();

            // Assert
            $this->assertEquals([$test_store2], $result);
        }

        function test_update()
        {
            // Arrange
            $name = 'Foot Traffic';
            $test_store = new Store($name);
            $test_store->save();

            $update_name = 'Foot Traffic Athletic Shoes';

            // Act
            $test_store->update($update_name);
            $result = $test_store->getName();

            // Assert
            $this->assertEquals($update_name, $result);
        }

        function test_addBrand()
        {
            // Arrange
            $store_name = 'Foot Traffic';
            $test_store = new Store($store_name);
            $test_store->save();

            $brand_name = 'Nike';
            $test_brand = new Brand($brand_name);
            $test_brand->save();

            // Act
            $test_store->addBrand($test_brand);
            $result = $test_store->getBrands();

            // Assert
            $this->assertEquals([$test_brand], $result);
        }

        function test_getBrands()
        {
            // Arrange
            $store_name = 'Foot Traffic';
            $test_store = new Store($store_name);
            $test_store->save();

            $brand_name = 'Nike';
            $test_brand = new Brand($brand_name);
            $test_brand->save();
            $test_store->addBrand($test_brand);

            $brand_name2 = 'Adidas';
            $test_brand2 = new Brand($brand_name2);
            $test_brand2->save();
            $test_store->addBrand($test_brand2);

            // Act
            $result = $test_store->getBrands();

            // Assert
            $this->assertEquals([$test_brand, $test_brand2], $result);
        }

        function test_removeBrand()
        {
            // Arrange
            $store_name = 'Foot Traffic';
            $test_store = new Store($store_name);
            $test_store->save();

            $brand_name = 'Nike';
            $test_brand = new Brand($brand_name);
            $test_brand->save();
            $test_store->addBrand($test_brand);

            $brand_name2 = 'Adidas';
            $test_brand2 = new Brand($brand_name2);
            $test_brand2->save();
            $test_store->addBrand($test_brand2);

            // Act
            $test_store->removeBrand($test_brand);
            $result = $test_store->getBrands();

            // Assert
            $this->assertEquals([$test_brand2], $result);
        }
    }
?>
