<?php
$router	= Router::getInstance();

//Home
$router->addRoute('/', 'HomeController', 'index');

//Auth
$router->addRoute('/auth/login', 'AuthController', 'login');
$router->addRoute('/auth/logout', 'AuthController', 'logout');
$router->addRoute('/auth/lostpw', 'AuthController', 'lostpw');
$router->addRoute('/auth/lostpw/:hash:', 'AuthController', 'lostpw_check');

//Profile
$router->addRoute('/profile', 'ProfileController', 'index');

//Log
$router->addRoute('/log', 'LogController', 'index');
$router->addRoute('/log/clear', 'LogController', 'clear');
$router->addRoute('/log/php', 'LogController', 'php');

// Users
$router->addRoute('/users', 'UsersController', 'index');
$router->addRoute('/users/add', 'UsersController', 'add');
$router->addRoute('/users/edit/:uid:', 'UsersController', 'edit');
$router->addRoute('/users/delete/:uid:', 'UsersController', 'delete');

$router->addRoute('/officer', 'OfficerController', 'index');
$router->addRoute('/officer/add', 'OfficerController', 'add');
$router->addRoute('/officer/edit/:id:', 'OfficerController', 'edit');
$router->addRoute('/officer/delete/:id:', 'OfficerController', 'delete');


// Admin panel
$router->addRoute('/admin', 'AdminController', 'index');
$router->addRoute('/admin/updateCheck', 'AdminController', 'updateCheck');

//Ajax
$router->addRoute('/api', 'ApiController', 'index');
$router->addRoute('/api/auth', 'ApiController', 'login');
$router->addRoute('/api/auth/logout', 'ApiController', 'logout');


$router->addRoute('/hello', 'HelloController', 'hello');


$router->addRoute('/report', 'ReportController', 'index');
$router->addRoute('/report/add/zdsl', 'ReportController', 'addStationStrength');
$router->addRoute('/report/add/wxzsl', 'ReportController', 'addSmallStationStrength');

$router->addRoute('/reports', 'ReportsController', 'index');
$router->addRoute('/reports/zdsl', 'ReportsController', 'stationStrength');
$router->addRoute('/reports/wxzsl', 'ReportsController', 'smallStationStrength');


?>
