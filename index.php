<?php

require_once 'libs/Frex/Frex.php';

// initialize the app
$app = new Frex();

/*
	set routes
*/

// without pass any controller method
$app->set('/');

// pass controller's method
$app->set('/main', 'MainController:main'); 
$app->set('/main/about', 'MainController:about');
$app->set('/user', 'UserController:listCurrentUsers');
$app->set('/json/user', 'UserController:listCurrentUsersInJson');

// pass controller's method with argument
$app->set('/user/:id', 'UserController:listUser');
$app->set('/json/user/:id', 'UserController:listUserInfoInJson');

// pass a function
$app->set('/contact', function() {
	echo 'You can contact me!';
});

// run the app!
$app->run();


?>
