<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Store.php";
    require_once __DIR__."/../src/Brand.php";

    use Symfony\Component\Debug\Debug;
    Debug::enable();

    $server = 'mysql:host=localhost:8889;dbname=shoes';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app = new Silex\Application();
    $app['debug'] = true;

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    // index, allows user to select between viewing a list of all stores or a list of all brands)
    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig');
    });

    // routes from index to stores page, displays all stores and a form to add a new store
    $app->get("/stores", function() use ($app) {
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });

    // from stores page, add a store, returns to stores page
    $app->post("/stores", function() use ($app) {
        $store = new Store($_POST['store_name']);
        $store->save();

        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });

    // from stores page, delete all stores, returns to stores page
    $app->delete("/stores", function() use ($app) {
        Store::deleteAll();

        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });

    // routes from index to brands page, displays all brands and a form to add a new brand
    $app->get("/brands", function() use ($app) {
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll()));
    });

    // from brands page, add a brand, returns to brands page
    $app->post("/brands", function() use ($app) {
        $brand = new Brand($_POST['brand_name']);
        $brand->save();

        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll()));
    });

    // from brands page, delete all brands, returns to brands page
    $app->delete("/brands", function() use ($app) {
        Brand::deleteAll();

        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll()));
    });

    // routes from stores page to store page, displays all brands carried by that store and a form to add more brands to the store
    $app->get("/stores/{id}", function($id) use ($app) {
        $store = Store::find($id);

        return $app['twig']->render('store.html.twig', array('store' => $store, 'brands' => Brand::getAll(), 'carried_brands' => $store->getBrands()));
    });

    // add a brand to a store, starts on store page and reroutes to same page on submit to allow user to add multiple brands to a store
    $app->post("/stores/{id}", function($id) use ($app) {
        $store = Store::find($id);
        $brand = Brand::find($_POST['brand_id']);
        $store->addBrand($brand);

        return $app['twig']->render('store.html.twig', array('store' => $store, 'brands' => Brand::getAll(), 'carried_brands' => $store->getBrands()));
    });

    // edit a store, routes from store page to store edit page
    $app->get("/stores/{id}/edit", function($id) use ($app) {
        $store = Store::find($id);

        return $app['twig']->render('store_edit.html.twig', array('store' => $store));
    });

    // submit edit to a store, starts on store edit page and routes back to store page
    $app->patch("/stores/{id}", function($id) use ($app) {
        $store_name = $_POST['store_name'];
        $store = Store::find($id);
        $store->update($store_name);

        return $app['twig']->render('store.html.twig', array('store' => $store, 'brands' => Brand::getAll(), 'carried_brands' => $store->getBrands()));
    });

    // delete a store, starts on store edit page and routes to stores page
    $app->delete("/stores/{id}", function($id) use ($app) {
        $store = Store::find($id);
        $store->delete();

        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });

    // routes from brands page to brand page, displays all stores that carry a particular brand and a form to add more stores to the brand
    $app->get("/brands/{id}", function($id) use ($app) {
        $brand = Brand::find($id);

        return $app['twig']->render('brand.html.twig', array('brand' => $brand, 'stores' => Store::getAll(), 'carried_stores' => $brand->getStores()));
    });

    // add a store to a brand, starts on brand page and reroutes to same page on submit to allow user to add multiple stores to a brand
    $app->post("/brands/{id}", function($id) use ($app) {
        $brand = Brand::find($id);
        $store = Store::find($_POST['store_id']);
        $brand->addStore($store);

        return $app['twig']->render('brand.html.twig', array('brand' => $brand, 'stores' => Store::getAll(), 'carried_stores' => $brand->getStores()));
    });

    // edit a brand, routes from brand page to brand edit page
    $app->get("/brands/{id}/edit", function($id) use ($app) {
        $brand = Brand::find($id);

        return $app['twig']->render('brand_edit.html.twig', array('brand' => $brand));
    });

    // submit edit to a brand, starts on brand edit page and routes back to brand page
    $app->patch("/brands/{id}", function($id) use ($app) {
        $brand_name = $_POST['brand_name'];
        $brand = Brand::find($id);
        $brand->update($brand_name);

        return $app['twig']->render('brand.html.twig', array('brand' => $brand, 'stores' => Store::getAll(), 'carried_stores' => $brand->getStores()));
    });

    // delete a brand, starts on brand edit page and routes to brands page
    $app->delete("/brands/{id}", function($id) use ($app) {
        $brand = Brand::find($id);
        $brand->delete();

        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll()));
    });

    // remove an association between a store and a brand, starts on store page and routes back to store page
    $app->delete("/stores/{id}/remove_brand", function($id) use ($app) {
        $store = Store::find($id);
        $brand = Brand::find($_POST['brand_id']);
        $store->removeBrand($brand);

        return $app['twig']->render('store.html.twig', array('store' => $store, 'brands' => Brand::getAll(), 'carried_brands' => $store->getBrands()));
    });

    return $app;
?>
