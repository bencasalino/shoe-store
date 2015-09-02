<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Store.php";
    require_once "src/Brand.php";
    //needed for mysql login
    $server = 'mysql:host=localhost;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    //brand test
    class BrandTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Brand::deleteAll();
            Store::deleteAll();
        }
///////////////////////////////////////////  set name ///////////////////////////////
        function testSetName()
        {
            //Arrange
            $brand_name = "nike";
            $test_brand = new Brand($brand_name);

            //Act
            $test_brand->setName("puma");
            $result = $test_brand->getName();

            //Assert
            $this->assertEquals("puma", $result);
        }

////////////////////////////////////////  get name ///////////////////////////////////
        function testGetName()
        {
            //Arrange
            $brand_name = "puma";
            $test_brand = new Brand($brand_name);

            //Act
            $result = $test_brand->getName();

            //Assert
            $this->assertEquals($brand_name, $result);
        }

//////////////////////////////// get id ////////////////////////////////////////////
        function testGetId()
        {
            //Arrange
            $brand_name = "nike";
            $id = 1;
            $test_brand = new Brand($brand_name, $id);

            //Act
            $result = $test_brand->getId();

            //Assert true is_numeric!!
            $this->assertEquals(true, is_numeric($result));
        }
////////////////////////////////////////////////////////////////////////////////
/////////////////////////////// test save /////////////////////////////////////
        function testSave()
        {
            //Arrange
            $brand_name = "puma";
            $test_brand = new Brand($brand_name);
            $test_brand->save();

            //Act
            $result = Brand::getAll();

            //Assert
            $this->assertEquals($test_brand, $result[0]);
        }

/////////////////////////////// statuc method test //////////////////////////////

        function test_getAll()
        {
            $brand_name = "nike";
            $test_brand = new Brand($brand_name);
            $test_brand->save();

            $brand_name2 = "rebook";
            $test_brand2 = new Brand($brand_name2);
            $test_brand2->save();

            //Act
            $result = Brand::getAll();

            //Assert
            $this->assertEquals([$test_brand2, $test_brand], $result);
        }
///////////////////////////////////////// delete all //////////////////////////////
        function test_deleteAll()
        {
            $brand_name = "nike";
            $test_brand = new Brand($brand_name);
            $test_brand->save();

            $brand_name2 = "addidas";
            $test_brand2 = new Brand($brand_name2);
            $test_brand2->save();

            //Act
            Brand::deleteAll();
            $result = Brand::getAll();

            //Assert
            $this->assertEquals([], $result);

        }
/////////////////////////////////// static test find ////////////////////////////
        function test_find()
        {
            //Arrange
            $brand_name = "puma ";
            $test_brand = new Brand($brand_name);
            $test_brand->save();

            $brand_name2 = "nike ";
            $test_brand2 = new Brand($brand_name2);
            $test_brand2->save();

            //Act
            $result = Brand::find($test_brand->getId());

            //Assert
            $this->assertEquals($test_brand, $result);
        }

////////////////////////// test add a new store /////////////////////////////////////

        function test_addStore()
        {
            //Arrange
            $store_name = "bens shoes ";
            $test_store = new Store($store_name);
            $test_store->save();

            $brand_name = "bobs shoes ";
            $test_brand = new Brand($brand_name);
            $test_brand->save();

            //Act
            $result = [$test_store];
            $test_brand->addStore($test_store);

            //Assert
            $this->assertEquals($test_brand->getStores(), $result);
        }
//////////////////////////////////// get a store ////////////////////////////////
        function test_getStores()
        {
            //Arrange
            $store_name = "bobs shoes";
            $test_store = new Store($store_name);
            $test_store->save();

            $brand_name = "jerrys shoes ";
            $test_brand = new Brand($brand_name);
            $test_brand->save();

            //Act
            $test_brand->addStore($test_store);
            $result = $test_brand->getStores();

            //Assert
            $this->assertEquals([$test_store], $result);
        }

    }
?>
