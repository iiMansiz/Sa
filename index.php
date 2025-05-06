<?php
require_once 'autoload.php';
require_once 'core/Session.php';
Session::start();

$router = new Router();

// Rute Auth
$router->add('GET', '/auth/login', 'AuthController', 'login');
$router->add('POST', '/auth/login', 'AuthController', 'login');
$router->add('GET', '/auth/register', 'AuthController', 'register');
$router->add('POST', '/auth/register', 'AuthController', 'register');
$router->add('GET', '/auth/logout', 'AuthController', 'logout');

// Rute Pembeli
$router->add('GET', '/', 'HomeController', 'index');
$router->add('GET', '/products', 'HomeController', 'index');
$router->add('GET', '/product/([0-9]+)', 'ProductController', 'detail');
// ... rute pembeli lainnya (cart, checkout, orders)

// Rute Penjual
$router->add('GET', '/seller/dashboard', 'SellerController', 'dashboard');
$router->add('GET', '/seller/products', 'SellerController', 'productList');
$router->add('GET', '/seller/products/add', 'SellerController', 'addProduct');
$router->add('POST', '/seller/products/add', 'SellerController', 'addProduct');
$router->add('GET', '/seller/products/edit/([0-9]+)', 'SellerController', 'editProduct');
$router->add('POST', '/seller/products/edit/([0-9]+)', 'SellerController', 'editProduct');
$router->add('GET', '/seller/orders', 'SellerController', 'orderList');
// ... rute penjual lainnya

// Rute Admin
$router->add('GET', '/admin/dashboard', 'AdminController', 'dashboard');
$router->add('GET', '/admin/users', 'AdminController', 'userList');
$router->add('GET', '/admin/products', 'AdminController', 'productList');
$router->add('GET', '/admin/orders', 'AdminController', 'orderList');
// ... rute admin lainnya

// Rute User (Profil)
$router->add('GET', '/user/profile', 'UserController', 'profile');
$router->add('POST', '/user/profile/update', 'UserController', 'updateProfile');

$url = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];
$router->dispatch($url, $method);
?>
