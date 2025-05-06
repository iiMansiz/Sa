<?php
require_once 'core/Controller.php';
require_once 'core/Session.php';
require_once 'models/Notification.php';

class NotificationController extends Controller {
    private $notificationModel;

    public function __construct() {
        Session::start();
        if (!Session::get('user_id')) {
            $this->redirect('/auth/login');
        }
        $this->notificationModel = $this->model('Notification');
    }

    public function index() {
        $userId = Session::get('user_id');
        $notifications = $this->notificationModel->getUserNotifications($userId);
        $this->view('user/notifications', ['notifications' => $notifications]);
    }

    public function markAsRead($notificationId) {
        $notification = $this->notificationModel->find($notificationId);
        if ($notification && $notification['user_id'] == Session::get('user_id')) {
            $this->notificationModel->markAsRead($notificationId);
        }
        $this->redirect('/notifications');
    }
}
?>
