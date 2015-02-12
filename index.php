<?php

require 'libs/Frex/Frex.php';

// initialize the app
$app = new Frex();
$app->load('Database.php');

// set routes
$app->set('/', 'MainController:main'); // pass controller
$app->set('/about', 'MainController:about'); // pass another controller
$app->set('/user', function() { // pass function
	echo 'You are user!';
});
$app->set('/contact', function() { // pass another function
	echo 'You can contact me!';
});

// run the app!
$app->run();


?>