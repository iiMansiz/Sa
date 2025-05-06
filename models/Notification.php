<?php
require_once 'core/Model.php';

class Notification extends Model {
    protected $table = 'notifications';

    public function getUserNotifications($userId, $limit = 10) {
        $sql = "SELECT * FROM " . $this->table . " WHERE user_id = " . (int) $userId . " ORDER BY created_at DESC LIMIT " . (int) $limit;
        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }

    public function markAsRead($notificationId) {
        return $this->update($notificationId, ['is_read' => true]);
    }

    public function addNotification($userId, $type, $message) {
        $data = [
            'user_id' => $userId,
            'type' => $type,
            'message' => $message
        ];
        return $this->insert($data);
    }

    public function getUnreadCount($userId) {
        $result = $this->db->query("SELECT COUNT(*) AS unread_count FROM " . $this->table . " WHERE user_id = " . (int) $userId . " AND is_read = FALSE");
        $row = $this->db->fetch($result);
        return $row ? $row['unread_count'] : 0;
    }
}
?>
