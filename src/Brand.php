<?php
    //Class
    Class Brand
    // class properites
    {
        private $id;
        private $Brand_name;
    }

    //contructor
    function __construct($name, $id = null)
        {
            $this->name = $name;
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
        function getId()
        {
            return $this->id;
        }
        ///////////////End Getters and Setters//////////////


                function save()
                {
                    $GLOBALS['DB']->exec("INSERT INTO brands (name) VALUES ('{$this->name}')");
                    $this->id = $GLOBALS['DB']->lastInsertId();
                }


                function addStore($store)
                {
                    $GLOBALS['DB']->exec("INSERT INTO brands_stores (brand_id, store_id) VALUES ({$this->id}, {$store->getId()})");
                }


                function getStores()
                {
                    $returned_stores = $GLOBALS['DB']->query("SELECT stores.* FROM brands JOIN brands_stores ON (brands.id = brands_stores.brand_id) JOIN stores ON (stores.id = brands_stores.store_id) WHERE brands.id = {$this->id}");
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
                ////////////////////Static functions/////////////////


                static function getAll()
                {
                    $returned_brands = $GLOBALS['DB']->query("SELECT * FROM brands");
                    $brands = array();
                    foreach($returned_brands as $brand){
                        $name = $brand["name"];
                        $id = $brand["id"];
                        $new_brand = new Brand($name, $id);
                        array_push($brands, $new_brand);
                    }
                    return $brands;
                }


                static function deleteAll()
                {
                    $GLOBALS['DB']->exec("DELETE FROM brands");
                    $GLOBALS['DB']->exec("DELETE FROM brands_stores");
                }


                static function find($search_id)
                {
                    $found_brand = null;
                    $brands = Brand::getAll();
                    foreach($brands as $brand) {
                        $brand_id = $brand->getId();
                        if($search_id == $brand_id) {
                            $found_brand = $brand;
                        }
                    }
                    return $found_brand;
                }
            }




?>
