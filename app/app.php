<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Cuisine.php";
    require_once __DIR__."/../src/Restaurant.php";
    require_once __DIR__."/../src/Review.php";


    $app = new Silex\Application();

    $server = 'pgsql:host=localhost;dbname=best_restaurants';
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

    $app->get("/cuisine", function() use ($app) {
        return $app['twig']->render('cuisines.html.twig', array('cuisines' => Cuisine::getAll()));
    });

    $app->post('/cuisine', function() use ($app){
        $cuisine = new Cuisine($_POST['type']);
        $cuisine->save();
        return $app['twig']->render('cuisines.html.twig', array('cuisines' => Cuisine::getAll()));
    });

    $app->get('/cuisine/{id}/edit', function($id), use ($app){
        $cuisine = Cuisine::find($id);
        return $app['twig']->render('cuisine_edit.html.twig', array('cuisine' => $cuisine));
    });

    $app->patch('/cuisine/{id}', function($id), use ($app){
        $type = $_POST['type'];
        $cuisine = Cuisine::find($id);
        $cuisine->update($cuisine);
        $restaurants = Restaurant::find($id);
        return $app['twig']->render('cuisines.html.twig', array('cuisine' => $cuisine, 'restaurants' => $restaurants));
    });

    $app->delete('/cuisine/{id}', function($id) use ($app) {
        $cuisine = Cuisine::find($id);
        $cuisine->deleteOne();
        return $app['twig']->render('index.html.twig', array('cuisines' => Cuisine::getAll()));
    });
