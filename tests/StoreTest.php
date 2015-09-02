<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Store.php";
    require_once "src/Brand.php";
    // needed for login my sql
    $server = 'mysql:host=localhost;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
    // store test

    class StoreTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Store::deleteAll();
        }

////////////////////////////// set name //////////////////////////////////////
        function testSetName()
        {
            //Arrange
            $store_name = "nike store";
            $test_store = new Store($store_name);

            //Act
            $test_store->setName("puma store ");
            $result = $test_store->getName();

            //Assert
            $this->assertEquals("puma store ", $result);
        }

///////////////////////////////////// get name //////////////////////////////////
        function testGetName()
        {
            //Arrange
            $store_name = "nike store";
            $test_store = new Store($store_name);

            //Act
            $result = $test_store->getName();

            //Assert
            $this->assertEquals($store_name, $result);
        }
///////////////////////////////////// test get an id from store /////////////////
        function testGetId()
        {
            //Arrange
            $store_name = "nike store";
            $id = 23;
            $test_store = new Store($store_name, $id);

            //Act
            $result = $test_store->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }
///////////////////////////////// save a store ////////////////////////////////////
        function testSave()
        {
            //Arrange
            $store_name = "kramers shoes ";
            $test_store = new Store($store_name);
            $test_store->save();

            //Act
            $result = Store::getAll();

            //Assert
            $this->assertEquals($test_store, $result[0]);
        }
///////////////////////////////// update a store name ///////////////////////////////
        function testUpdateName()
        {
            //Arrange
            $store_name = "bobs shoe store ";
            $test_store = new Store($store_name);
            $test_store->save();

            $store_name2 = "nike store";

            //Act
            $test_store->updateName($store_name2);

            //Assert
            $this->assertEquals("nike store", $test_store->getName());
        }
/////////////////////////////////// delete a single store /////////////////////
        function test_delete()
        {
            //Arrange
            $store_name = "nike store ";
            $test_store = new Store($store_name);
            $test_store->save();

            $store_name2 = "puma store " ;
            $test_store2 = new Store($store_name2);
            $test_store2->save();

            //Act
            $test_store->delete();
            $result = Store::getAll();

            //Assert
            $this->assertEquals([$test_store2], $result);
        }
///////////////////////////////////// static methods ///////////////////////////
////////////////////////////// test get all stores //////////////////////////////
        function test_getAll()
        {
            //Arrange
            $store_name = "nike store";
            $test_store = new Store($store_name);
            $test_store->save();

            $store_name2 = "addidas store " ;
            $test_store2 = new Store($store_name2);
            $test_store2->save();

            //Act
            $result = Store::getAll();

            //Assert
            $this->assertEquals([$test_store2, $test_store], $result);
        }
///////////////////////////////////// test delete all stores //////////////////
        function test_deleteAll()
        {
            $store_name = "george shoe store ";
            $test_store = new Store($store_name);
            $test_store->save();

            $store_name2 = "kramer shoe store " ;
            $test_store2 = new Store($store_name2);
            $test_store2->save();

            //Act
            Store::deleteAll();
            $result = Store::getAll();

            //Assert
            $this->assertEquals([], $result);
        }
//////////////////////////////// test for find a store///////////////////////////
        function test_find()
        {
            //Arrange
            $store_name =  "jerrys shoes ";
            $test_store = new Store($store_name);
            $test_store->save();

            $store_name2 = "newmans shoes " ;
            $test_store2 = new Store($store_name2);
            $test_store2->save();

            //Act
            $result = Store::find($test_store->getId());

            //Assert
            $this->assertEquals($test_store, $result);
        }
///////////////////////// test add a shoe brand to a store /////////////////////////////

        function test_addBrand()
        {
            //Arrange
            $brand_name = "rebook";
            $test_brand = new Brand($brand_name);
            $test_brand->save();

            $store_name = "bens store ";
            $test_store = new Store($store_name);
            $test_store->save();

            //Act
            $result = [$test_brand];
            $test_store->addBrand($test_brand);

            //Assert
            $this->assertEquals($test_store->getBrands(), $result);
        }

///////////////////////////// test for getting brands ///////////////////////////
        function test_getBrands()
        {
            //Arrange
            $brand_name = "nike";
            $test_brand = new Brand($brand_name);
            $test_brand->save();

            $store_name = "joes sandal store ";
            $test_store = new Store($store_name);
            $test_store->save();

            //Act
            $test_store->addBrand($test_brand);
            $result = $test_store->getBrands();

            //Assert
            $this->assertEquals([$test_brand], $result);
        }

    }

?>
