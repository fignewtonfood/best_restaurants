<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Cuisine.php";
    require_once __DIR__."/../src/Restaurant.php";
    require_once __DIR__."/../src/Review.php";


    $app = new Silex\Application();

    $server = 'mysql:host=localhost;dbname=best_restaurants';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get('/', function() use($app){
        return $app['twig']->render('index.html.twig');
    });

//===================CUISINE ROUTES====================//

    $app->get("/cuisine", function() use ($app) {
        return $app['twig']->render('cuisines.html.twig', array('cuisines' => Cuisine::getAll()));
    });

    $app->post('/cuisine', function() use ($app){
        $cuisine = new Cuisine($_POST['type']);
        $cuisine->save();
        return $app['twig']->render('cuisines.html.twig', array('cuisines' => Cuisine::getAll()));
    });

    $app->get('/cuisine/{id}/edit', function($id) use ($app){
        $cuisine = Cuisine::find($id);
        return $app['twig']->render('cuisine_edit.html.twig', array('cuisine' => $cuisine));
    });

    $app->patch('/cuisine/{id}', function($id) use ($app){
        $type = $_POST['type'];
        $cuisine = Cuisine::find($id);
        $cuisine->update($type);
        $restaurants = Restaurant::find($id);
        return $app['twig']->render('cuisines.html.twig', array('cuisine' => $cuisine, 'restaurants' => $restaurants));
    });

    $app->delete('/cuisine/{id}', function($id) use ($app) {
        $cuisine = Cuisine::find($id);
        $cuisine->deleteOne();
        return $app['twig']->render('cuisines.html.twig', array('cuisines' => Cuisine::getAll()));
    });

    //===============END CUISINE ROUTES====================//

    //================RESTAURANT ROUTES====================//


    $app->get("/restaurant", function() use ($app) {
        return $app['twig']->render('restaurants.html.twig', array('restaurants' => Restaurant::getAll()));
    });

    $app->post('/restaurant', function() use ($app){
        $restaurant = new Restaurant($_POST['cuisine_id'], $_POST['name']);
        $restaurant->save();
        return $app['twig']->render('restaurants.html.twig', array('restaurants' => Restaurant::getAll(), 'cuisines' => Cuisine::getAll()));
    });

    $app->get('/restaurant/{id}/edit', function($id) use ($app){
        $restaurant = Restaurant::find($id);
        return $app['twig']->render('restaurant_edit.html.twig', array('restaurant' => $restaurant));
    });

    $app->patch('/restaurant/{id}', function($id) use ($app){
        $name = $_POST['name'];
        $restaurant = Restaurant::find($id);
        $restaurant->update($name);
        $reviews = Review::find($id);
        return $app['twig']->render('restaurants.html.twig', array('restaurant' => $restaurant, 'reviews' => $reviews));
    });

    $app->delete('/restaurant/{id}', function($id) use ($app) {
        $restaurant = Restaurant::find($id);
        $restaurant->deleteOne();
        return $app['twig']->render('restaurants.html.twig', array('restaurants' => Restaurant::getAll()));
    });
    //===============END RESTAURANT ROUTES=================//


    //================REVIEW ROUTES========================//

    // $app->get("/review", function() use ($app) {
    //     return $app['twig']->render('reviews.html.twig', array('reviews' => Review::getAll()));
    // });

    // $app->post('/restaurant', function() use ($app){
    //     $restaurant = new Restaurant($_POST['cuisine_id'], $_POST['name']);
    //     $restaurant->save();
    //     return $app['twig']->render('restaurants.html.twig', array('restaurants' => Restaurant::getAll(), 'cuisines' => Cuisine::getAll()));
    // });
    //
    // $app->get('/restaurant/{id}/edit', function($id), use ($app){
    //     $restaurant = Restaurant::find($id);
    //     return $app['twig']->render('restaurant_edit.html.twig', array('restaurant' => $restaurant));
    // });
    //
    // $app->patch('/restaurant/{id}', function($id), use ($app){
    //     $name = $_POST['name'];
    //     $restaurant = Restaurant::find($id);
    //     $restaurant->update($name);
    //     $reviews = Review::find($id);
    //     return $app['twig']->render('restaurants.html.twig', array('restaurant' => $restaurant, 'reviews' => $reviews));
    // });
    //
    // $app->delete('/restaurant/{id}', function($id) use ($app) {
    //     $restaurant = Restaurant::find($id);
    //     $restaurant->deleteOne();
    //     return $app['twig']->render('restaurants.html.twig', array('restaurants' => Restaurant::getAll()));
    // });

    //===============END REVIEW ROUTES=====================//
    return $app;
