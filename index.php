<?php
require_once 'autoload.php';
require_once 'core/Session.php';
Session::start();

$router = new Router();

// ... (rute lain)

// Rute Notifikasi
$router->add('GET', '/notifications', 'NotificationController', 'index');
$router->add('POST', '/notifications/read/([0-9]+)', 'NotificationController', 'markAsRead');

// Rute Rating Penjual
$router->add('GET', '/seller/rate/([0-9]+)/order/([0-9]+)', 'ReviewController', 'rateSeller');
$router->add('POST', '/seller/rate/([0-9]+)/order/([0-9]+)', 'ReviewController', 'rateSeller');

// Rute Promosi (Admin)
$router->add('GET', '/admin/promotions', 'PromotionController', 'index');
$router->add('GET', '/admin/promotions/add', 'PromotionController', 'add');
$router->add('POST', '/admin/promotions/add', 'PromotionController', 'add');
$router->add('GET', '/admin/promotions/edit/([0-9]+)', 'PromotionController', 'edit');
$router->add('POST', '/admin/promotions/edit/([0-9]+)', 'PromotionController', 'edit');
$router->add('GET', '/admin/promotions/delete/([0-9]+)', 'PromotionController', 'delete');
$router->add('GET', '/admin/promotions/manage/([0-9]+)', 'PromotionController', 'manageProducts');
$router->add('POST', '/admin/promotions/manage/([0-9]+)', 'PromotionController', 'manageProducts');

// Rute Pengiriman (Admin)
$router->add('GET', '/admin/shipping', 'ShippingController', 'index');
$router->add('GET', '/admin/shipping/add', 'ShippingController', 'add');
$router->add('POST', '/admin/shipping/add', 'ShippingController', 'add');
$router->add('GET', '/admin/shipping/edit/([0-9]+)', 'ShippingController', 'edit');
$router->add('POST', '/admin/shipping/edit/([0-9]+)', 'ShippingController', 'edit');
$router->add('GET', '/admin/shipping/delete/([0-9]+)', 'ShippingController', 'delete');

// ... (rute lain)


// Rute Review
$router->add('POST', '/review/add/([0-9]+)', 'ReviewController', 'add');

// Rute Seller - Manajemen Gambar Produk
$router->add('POST', '/seller/product/image/delete/([0-9]+)', 'SellerController', 'deleteProductImage');

// Rute Seller - Manajemen Variasi Produk
$router->add('POST', '/seller/product/variation/delete/([0-9]+)', 'SellerController', 'deleteProductVariation');

// ... (rute lain)

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
$router->add('GET', '/cart', 'CartController', 'index');
$router->add('GET', '/cart/add/([0-9]+)', 'CartController', 'add');
$router->add('POST', '/cart/update', 'CartController', 'update');
$router->add('GET', '/cart/remove/([0-9]+)', 'CartController', 'remove');
$router->add('GET', '/cart/clear', 'CartController', 'clear');
$router->add('GET', '/checkout', 'CheckoutController', 'index');
$router->add('POST', '/checkout/process', 'CheckoutController', 'processOrder');
$router->add('GET', '/orders', 'OrderController', 'index');
$router->add('GET', '/orders/([0-9]+)', 'OrderController', 'detail');
$router->add('GET', '/payment/([0-9]+)', 'PaymentController', 'index');
$router->add('POST', '/payment/process/([0-9]+)', 'PaymentController', 'processPayment');

// Rute Penjual
$router->add('GET', '/seller/dashboard', 'SellerController', 'dashboard');
$router->add('GET', '/seller/products', 'SellerController', 'productList');
$router->add('GET', '/seller/products/add', 'SellerController', 'addProduct');
$router->add('POST', '/seller/products/add', 'SellerController', 'addProduct');
$router->add('GET', '/seller/products/edit/([0-9]+)', 'SellerController', 'editProduct');
$router->add('POST', '/seller/products/edit/([0-9]+)', 'SellerController', 'editProduct');
$router->add('GET', '/seller/orders', 'OrderController', 'sellerOrderList');
$router->add('GET', '/seller/orders/([0-9]+)', 'OrderController', 'sellerOrderDetail');

// Rute Admin
$router->add('GET', '/admin/dashboard', 'AdminController', 'dashboard');
$router->add('GET', '/admin/users', 'AdminController', 'userList');
$router->add('GET', '/admin/products', 'AdminController', 'productList');
$router->add('GET', '/admin/orders', 'OrderController', 'adminOrderList');
$router->add('GET', '/admin/orders/([0-9]+)', 'OrderController', 'adminOrderDetail');
$router->add('GET', '/admin/categories', 'CategoryController', 'index');
$router->add('GET', '/admin/categories/add', 'CategoryController', 'add');
$router->add('POST', '/admin/categories/add', 'CategoryController', 'add');
$router->add('GET', '/admin/categories/edit/([0-9]+)', 'CategoryController', 'edit');
$router->add('POST', '/admin/categories/edit/([0-9]+)', 'CategoryController', 'edit');
$router->add('GET', '/admin/categories/delete/([0-9]+)', 'CategoryController', 'delete');

// Rute Update Status Pesanan (Admin & Seller)
$router->add('POST', '/orders/status/([0-9]+)', 'OrderController', 'updateOrderStatus');

// Rute User (Profil)
$router->add('GET', '/user/profile', 'UserController', 'profile');
$router->add('POST', '/user/profile/update', 'UserController', 'updateProfile');

$url = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];
$router->dispatch($url, $method);
?>

