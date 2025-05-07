<?php
namespace Core;

class Session {
    public static function start() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public static function get($key) {
        return $_SESSION[$key] ?? null;
    }

    public static function has($key) {
        return isset($_SESSION[$key]);
    }

    public static function delete($key) {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public static function destroy() {
        session_destroy();
    }

    public static function flash($key) {
        if (isset($_SESSION[$key])) {
            $value = $_SESSION[$key];
            unset($_SESSION[$key]);
            return $value;
        }
        return null;
    }

    public static function setSuccessMessage($message) {
        $_SESSION['success_message'] = $message;
    }

    public static function getSuccessMessage() {
        return self::flash('success_message');
    }

    public static function setErrorMessage($message) {
        $_SESSION['error_message'] = $message;
    }

    public static function getErrorMessage() {
        return self::flash('error_message');
    }

    public static function setInfoMessage($message) {
        $_SESSION['info_message'] = $message;
    }

    public static function getInfoMessage() {
        return self::flash('info_message');
    }
}
