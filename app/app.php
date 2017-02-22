<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Task.php";
    require_once __DIR__."/../src/Category.php";
    require_once __DIR__."/../src/Date.php";

    $app = new Silex\Application();

    $server = 'mysql:host=localhost:8889;dbname=to_do';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app['debug'] = true;

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
    return $app['twig']->render('index.html.twig', array('tasks' => Task::getAll()));
    });

    $app->post("/add_task", function() use ($app) {
        $description = $_POST['description'];
        $importance = $_POST['importance'];
        $due_date = $_POST['due-date'];
        $category_input = $_POST['category'];
        $date = new Date($due_date, $id = null);
        $date->save();
        $date_id = $date->getId();
        $category = new Category($category_input, $id = null);
        $category->save();
        $category_id = $category->getId();
        $task = new Task($description, $category_id, $importance, $date_id, $id = null);
        $task->save();
    return $app['twig']->render('confirm_task.html.twig', array('tasks' => Task::getAll()));
    });



    return $app;
 ?>
