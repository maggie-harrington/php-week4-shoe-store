<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Store.php";

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
    }
?>
