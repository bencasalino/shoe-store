<?php
    //need one for each class
    require_once __DIR__."/../src/Brand.php";
    require_once __DIR__."/../src/Store.php";
    require_once __DIR__."/../vendor/autoload.php";


  
    // needed to use silex
    $app = new Silex\Application();

    // turns on debuuger for terminal
    $app['debug'] = true;

    //login for phpmyadmin
    $server = 'mysql:host=localhost;dbname=shoes';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    // must have to run php tests
    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    //pointing twig towards the views folder
  $app->register(new Silex\Provider\TwigServiceProvider(), array(
      'twig.path' => __DIR__.'/../views'
  ));



      // get stores
      $app->get("/stores", function() use ($app) {
          return $app['twig']->render("stores.html.twig", array("stores" => Store::getAll(), "brands" => Brand::getAll()));
      });

      // post to stores
      $app->post('/stores', function() use ($app) {
          $name = $_POST['name'];
          $location = $_POST['location'];
          $store = new Store($name, $location);
          $store->save();
          return $app['twig']->render("stores.html.twig", array("stores" => Store::getAll(), "brands" => Brand::getAll()));
      });

      // delete stores
      $app->delete("/stores", function() use ($app) {
          Store::deleteAll();
          return $app['twig']->render("stores.html.twig", array("stores" => Store::getAll(), "brands" => Brand::getAll()));
      });

      //get store id
      $app->get("/store/{id}", function($id) use ($app) {
          $store = Store::find($id);
          return $app['twig']->render("store.html.twig", array("store" => $store, "all_brands" => Brand::getAll(), "brands" => $store->getBrands()));
      });


      // update store id
      $app->patch("/store/{id}", function($id) use ($app) {
          $store = Store::find($id);
          if (!empty($_POST['name'])) {
              $name = $_POST['name'];
              $store->updateName($name);
          }
          if (!empty($_POST['location'])) {
              $location = $_POST['location'];
              $store->updateLocation($location);
          }
          return $app['twig']->render("store.html.twig", array("store" => $store, "all_brands" => Brand::getAll(), "brands" => $store->getBrands()));
      });

      // get store id
      $app->get("/store/{id}/edit", function($id) use ($app) {
          $store = Store::find($id);
          return $app['twig']->render("store_edit.html.twig", array("store" => $store));
      });

      // add a new brand
      $app->post("/add_brands", function() use ($app) {
          $store = Store::find($_POST['store_id']);
          $brand = Brand::find($_POST['brand_id']);
          $store->addBrand($brand);
          return $app['twig']->render("store.html.twig", array("store" => $store, "all_brands" => Brand::getAll(), "brands" => $store->getBrands()));
      });

      // delete a strore serial id
      $app->get("/store/{id}/delete", function($id) use ($app) {
          $store = Store::find($id);
          $store->delete();
          return $app['twig']->render("stores.html.twig", array("stores" => Store::getAll(), "brands" => Brand::getAll()));
      });

      // get a brand
      $app->get("/brands", function() use ($app) {
          return $app['twig']->render("brands.html.twig", array("stores" => Store::getAll(), "brands" => Brand::getAll()));
      });

      // get multiple brands?
      $app->post("/brands", function() use ($app) {
          $name = $_POST['name'];
          $brand = new Brand($name);
          $brand->save();
          return $app['twig']->render("brands.html.twig", array("stores" => Store::getAll(), "brands" => Brand::getAll()));
      });

      // delete all brands
      $app->delete("/brands", function() use ($app) {
          Brand::deleteAll();
          return $app['twig']->render("brands.html.twig", array("stores" => Store::getAll(), "brands" => Brand::getAll()));
      });

      // retrieve a brand id
      $app->get("/brand/{id}", function($id) use ($app) {
          $brand = Brand::find($id);
          return $app['twig']->render("brand.html.twig", array("brand" => $brand,"all_stores" => Store::getAll(), "stores" => $brand->getStores()));
      });


      // update a new store
      $app->post("/add_stores", function() use ($app) {
          $brand = Brand::find($_POST['brand_id']);
          $store = Store::find($_POST['store_id']);
          $brand->addStore($store);
          return $app['twig']->render("brand.html.twig", array("brand" => $brand,"all_stores" => Store::getAll(), "stores" => $brand->getStores()));
      });


// must have at bottom

return $app;
  ?>
