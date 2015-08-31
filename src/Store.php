<?php
      //Class
    Class Store{
      //Class Properties
      private $id;
      private $store_name;
      //Constructors
      function __construct($store_name, $id = null)
      {
          $this->store_name = $store_name;
          $this->id = $id;
      }

     //Getters and Setters
     function getName()
     {
         return $this->name;
     }
     function setName($new_name)
     {
         $this->name = $new_name;
     }
     function getLocation()
     {
         return $this->location;
     }
     function setLocation($new_location)
     {
         $this->location = $new_location;
     }
     function getId()
     {
         return $this->id;
     }
     ////////////////End Getters and Setters/////////////


     function save()
     {
         $GLOBALS['DB']->exec("INSERT INTO stores (name, location) VALUES ('{$this->getName()}', '{$this->getLocation()}')");
         $this->id = $GLOBALS['DB']->lastInsertId();
     }


     function updateName($new_name)
     {
         $GLOBALS['DB']->exec("UPDATE stores SET name = '{$new_name}' WHERE id = {$this->id}");
         $this->name = $new_name;
     }


     function updateLocation($new_location)
     {
         $GLOBALS['DB']->exec("UPDATE stores SET location = '{$new_location}' WHERE id = {$this->id}");
         $this->location = $new_location;
     }


     function addBrand($brand)
     {
         $GLOBALS['DB']->exec("INSERT INTO brands_stores (brand_id, store_id) VALUES ({$brand->getId()}, {$this->id})");
     }


     function delete()
     {
         $GLOBALS['DB']->exec("DELETE FROM stores WHERE id = {$this->getId()}");
         $GLOBALS['DB']->exec("DELETE FROM brands_stores WHERE store_id = {$this->getId()}");
     }


     function getBrands()
     {
         $returned_brands = $GLOBALS['DB']->query("SELECT brands.* FROM stores JOIN brands_stores ON (stores.id = brands_stores.store_id) JOIN brands ON (brands.id = brands_stores.brand_id) WHERE stores.id = {$this->id}");
         $brands = array();
         foreach($returned_brands as $brand){
             $name = $brand["name"];
             $id = $brand["id"];
             $new_brand = new Brand($name, $id);
             array_push($brands, $new_brand);
         }
         return $brands;
     }


     //////////////////Static functions////////////////////////////

     static function getAll()
     {
         $returned_stores = $GLOBALS['DB']->query("SELECT * FROM stores");
         $stores = array();
         foreach($returned_stores as $store) {
             $name = $store['name'];
             $location = $store['location'];
             $id = $store['id'];
             $new_store = new Store($name, $location, $id);
             array_push($stores, $new_store);
         }
         return $stores;
     }


     static function deleteAll()
     {
         $GLOBALS['DB']->exec("DELETE FROM stores");
         $GLOBALS['DB']->exec("DELETE FROM brands_stores");
     }

     static function find($search_id)
     {
         $found_store = null;
         $stores = Store::getAll();
         foreach($stores as $store){
             $store_id = $store->getId();
             if($store_id == $search_id) {
                 $found_store = $store;
             }
         }
         return $found_store;
     }
 }


      ?>
