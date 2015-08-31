<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    //needed to link CLASS pages
    require_once "src/Store.php";
    require_once "src/Brand.php";

    //needed to use mysql
    $server = 'mysql:host=localhost;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    //needed to run PHPunit tests
    class StoreTest extends PHPUnit_Framework_TestCase

    //teardown
    {
        protected function tearDown()
        {
            // one needed for each class
            Store::deleteAll();
            Brand::deleteAll();
        }


        function testGetName()
        {
            //Arrange
            $name = "shoe store";
            $location = "123 n fake st";
            $test_store = new Store($name, $location);
            //Act
            $result = $test_store->getName();
            //Assert
            $this->assertEquals($name, $result);
        }
        function testSetName()
        {
            //Arrange
            $name = "shoe store";
            $location = "123 n fake st";
            $test_store = new Store($name, $location);
            $new_name = "new store";
            //Act
            $test_store->setName($new_name);
            $result = $test_store->getName();
            //Assert
            $this->assertEquals($new_name, $result);
        }
        function testGetLocation()
        {
            //Arrange
            $name = "shoe store";
            $location = "123 n fake st";
            $test_store = new Store($name, $location);
            //Act
            $result = $test_store->getLocation();
            //Assert
            $this->assertEquals($location, $result);
        }
        function testSetLocation()
        {
            //Arrange
            $name = "shoe store";
            $location = "123 n fake st";
            $test_store = new Store($name, $location);
            $new_location = "312 n reallyfake st";
            //Act
            $test_store->setLocation($new_location);
            $result = $test_store->getLocation();
            //Assert
            $this->assertEquals($new_location, $result);
        }

        // test needed also for set id?????
        function testGetId()
        {
            //Arrange
            $name = "shoe store";
            $location = "123 n fake st";
            $id = 4;
            $test_store = new Store($name, $location, $id);
            //Act
            $result = $test_store->getId();
            //Assert
            $this->assertEquals($id, $result);
        }





        // keep save and get all next to eachother
        function testsave()
        {
            //Arrange
            $name = "shoe store";
            $location = "123 n fake ave";
            $id = 4;
            $test_store = new Store($name, $location, $id);
            $test_store->save();
            //Act
            $result = Store::getAll();
            //Assert
            $this->assertEquals($test_store, $result[0]);
        }


        function testGetAll()
        {
            //Arrange
            $name = "shoe store";
            $location = "123 n fake st";
            $id = 4;
            $test_store = new Store($name, $location, $id);
            $test_store->save();
            $name2 = "other store";
            $location2 = "444 s real st";
            $id2 = 3;
            $test_store2 = new Store($name2, $location2, $id2);
            $test_store2->save();
            //Act
            $result = Store::getAll();
            //Assert
            $this->assertEquals([$test_store, $test_store2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $name = "shoe store";
            $location = "1234 nw 1st street";
            $id = 4;
            $test_store = new Store($name, $location, $id);
            $test_store->save();
            $name2 = "other store";
            $location2 = "5555 sw 2nd street";
            $id2 = 3;
            $test_store2 = new Store($name2, $location2, $id2);
            $test_store2->save();
            //Act
            Store::deleteAll();
            $result = Store::getAll();
            //Assert
            $this->assertEquals([], $result);
        }

        // test find
        function testFind()
        {
            //Arrange
            $name = "shoe store";
            $location = "1234 nw 1st street";
            $id = 4;
            $test_store = new Store($name, $location, $id);
            $test_store->save();
            $name2 = "other store";
            $location2 = "5555 sw 2nd street";
            $id2 = 3;
            $test_store2 = new Store($name2, $location2, $id2);
            $test_store2->save();
            //Act
            $result = Store::find($test_store2->getId());
            //Assert
            $this->assertEquals($test_store2, $result);
        }
        // to change name in the future
        function testUpdateName()
        {
            //Arrange
            $name = "shoe store";
            $location = "1234 nw 1st street";
            $id = 4;
            $test_store = new Store($name, $location, $id);
            $test_store->save();
            $new_name = "New Store";
            //Act
            $test_store->updateName($new_name);
            $result = $test_store->getName();
            //Assert
            $this->assertEquals($new_name, $result);
        }
        // to change location in the future 
        function testUpdateLocation()
        {
            //Arrange
            $name = "shoe store";
            $location = "1234 nw 1st street";
            $id = 4;
            $test_store = new Store($name, $location, $id);
            $test_store->save();
            $new_location = "5555 sw 3rd street";
            //Act
            $test_store->updateLocation($new_location);
            $result = $test_store->getLocation();
            //Assert
            $this->assertEquals($new_location, $result);
        }
        function testgetBrands()
        {
            //Arrange
            $name1 = "shoe store";
            $location = "123 n fake dr";
            $id1 = 4;
            $test_store = new Store($name1, $location, $id1);
            $test_store->save();
            $name = "nike";
            $id = 1;
            $test_brand = new Brand($name, $id);
            $test_brand->save();
            $name2 = "addidas";
            $id2 = 2;
            $test_brand2 = new Brand($name2, $id2);
            $test_brand2->save();
            //Act
            $test_store->addBrand($test_brand);
            $test_store->addBrand($test_brand2);
            $result = $test_store->getBrands();
            //Assert
            $this->assertEquals([$test_brand, $test_brand2], $result);
        }
    }
 ?>
