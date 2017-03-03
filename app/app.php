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

    // delete a store, starts on store page and routes to stores page
    $app->delete("/stores/{id}", function($id) use ($app) {
        $store = Store::find($id);
        $store->delete();

        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });

    // edit a store, routes from store page to store edit page
    $app->get("/stores/{id}/edit", function($id) use ($app) {
        $store = Store::find($id);

        return $app['twig']->render('store_edit.html.twig', array('store' => $store));
    });

    return $app;
?>
