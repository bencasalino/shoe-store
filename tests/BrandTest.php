<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    // need one for each class
    require_once "src/Store.php";
    require_once "src/Brand.php";

    // needed to mysql
    $server = 'mysql:host=localhost;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    // needed for phpunit to actually test
    class BrandTest extends PHPUnit_Framework_TestCase
    {
      // teardown
      protected function tearDown()
        {
            Store::deleteAll();
            Brand::deleteAll();
        }



        // lots of theses tets should be simliar to storetest.php
        function testGetName()
        {
            //Arrange
            $name = "addidas";
            $test_brand = new Brand($name);
            //Act
            $result = $test_brand->getName();
            //Assert
            $this->assertEquals($name, $result);
        }
        function testSetName()
        {
            //Arrange
            $name = "addidas";
            $test_brand = new Brand($name);
            $new_name = "nike";
            //Act
            $test_brand->setName($new_name);
            $result = $test_brand->getName();
            //Assert
            $this->assertEquals($new_name, $result);
        }
        // get id
        function testGetId()
        {
            //Arrange
            $name = "addidas";
            $id = 1;
            $test_brand = new Brand($name, $id);
            //Act
            $result = $test_brand->getId();
            //Assert
            $this->assertEquals($id, $result);
        }

        // keep save near delete all
        function testSave()
        {
            //Arrange
            $name = "reebok";
            $id = 1;
            $test_brand = new Brand($name, $id);
            $test_brand->save();
            //Act
            $result = Brand::getAll();
            //Assert
            $this->assertEquals($test_brand, $result[0]);
        }

        function testDeleteAll()
        {
            //Arrange
            $name = "vans";
            $id = 1;
            $test_brand = new Brand($name, $id);
            $test_brand->save();
            $name2= "crocs";
            $id2 = 2;
            $test_brand2 = new Brand($name2, $id2);
            $test_brand2->save();
            //Act
            Brand::deleteAll();
            $result = Brand::getAll();
            //Assert
            $this->assertEquals([], $result);
        }

        // get all
        function testgetAll()
        {
            //Arrange
            $name = "rebook";
            $id = 1;
            $test_brand = new Brand($name, $id);
            $test_brand->save();
            $name2 = "assidas";
            $id2 = 2;
            $test_brand2 = new Brand($name2, $id2);
            $test_brand2->save();
            //Act
            $result = Brand::getAll();
            //Assert
            $this->assertEquals([$test_brand, $test_brand2], $result);
        }


        function testgetStores()
        {
            //Arrange
            $name = "crocs store ";
            $id = 1;
            $test_brand = new Brand($name, $id);
            $test_brand->save();
            $name1 = "shoe store";
            $location = "123  n fake st";
            $id1 = 4;
            $test_store = new Store($name1, $location, $id1);
            $test_store->save();
            $name2 = "addidas store ";
            $location2 = "321 s real st";
            $id2 = 3;
            $test_store2 = new Store($name2, $location2, $id2);
            $test_store2->save();
            //Act
            $test_brand->addStore($test_store);
            $test_brand->addStore($test_store2);
            $result = $test_brand->getStores();
            //Assert
            $this->assertEquals([$test_store, $test_store2], $result);
        }
    }
 ?>
