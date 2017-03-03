<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once 'src/Brand.php';

    $server = 'mysql:host=localhost:8889;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
    class BrandTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Brand::deleteAll();
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


    }
?>
