<?php
require_once 'core/Session.php';

class Cart {
    private static $cartKey = 'shopping_cart';

    public static function getItems() {
        Session::start();
        return Session::get(self::$cartKey, []);
    }

    public static function addItem($productId, $quantity = 1) {
        Session::start();
        $cart = self::getItems();
        if (isset($cart[$productId])) {
            $cart[$productId] += $quantity;
        } else {
            $cart[$productId] = $quantity;
        }
        Session::set(self::$cartKey, $cart);
    }

    public static function updateItem($productId, $quantity) {
        Session::start();
        $cart = self::getItems();
        if (isset($cart[$productId])) {
            $cart[$productId] = max(1, $quantity); // Pastikan kuantitas minimal 1
            Session::set(self::$cartKey, $cart);
            return true;
        }
        return false;
    }

    public static function removeItem($productId) {
        Session::start();
        $cart = self::getItems();
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::set(self::$cartKey, $cart);
            return true;
        }
        return false;
    }

    public static function getTotalItems() {
        $cart = self::getItems();
        return array_sum($cart);
    }

    public static function clear() {
        Session::start();
        Session::delete(self::$cartKey);
    }
}
?>
