<?php

require 'libs/Frex/Frex.php';

// initialize the app
$app = new Frex();

// set routes
$app->set('/');
$app->set('/main', 'MainController:main'); // pass controller's method 
$app->set('/main/about', 'MainController:about'); // pass anthoer controller's method
$app->set('/user', 'UserController:listCurrentUsers');
$app->set('/user/:id', 'UserController:printUserInfo'); // pass controller's method with argument
$app->set('/contact', function() { // pass a function
	echo 'You can contact me!';
});

// run the app!
$app->run();


?>