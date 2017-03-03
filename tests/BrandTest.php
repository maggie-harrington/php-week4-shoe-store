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
            // Brand::deleteAll();
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


    }
?>
