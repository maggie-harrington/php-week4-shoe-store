<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once 'src/Store.php';

    $server = 'mysql:host=localhost:8889;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
    class StoreTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            // Store::deleteAll();
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


    }
?>
