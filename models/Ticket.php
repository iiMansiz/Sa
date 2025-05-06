<?php
require_once 'core/Model.php';

class Ticket extends Model {
    protected $table = 'tickets';

    public function getUserTickets($userId) {
        return $this->where('user_id', $userId)->orderBy('created_at', 'DESC')->get();
    }

    public function getOpenTickets() {
        return $this->where('status', 'open')->orderBy('created_at', 'DESC')->get();
    }

    public function getTicketWithMessages($ticketId) {
        $sql = "SELECT t.*, tm.id AS message_id, tm.user_id AS message_user_id, tm.message, tm.is_admin, tm.created_at AS message_created_at, u.nama AS user_name
                FROM " . $this->table . " t
                LEFT JOIN ticket_messages tm ON t.id = tm.ticket_id
                LEFT JOIN users u ON tm.user_id = u.id
                WHERE t.id = " . (int) $ticketId . "
                ORDER BY tm.created_at ASC";
        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }

    public function addMessage($ticketId, $userId, $message, $isAdmin = false) {
        $data = [
            'ticket_id' => $ticketId,
            'user_id' => $userId,
            'message' => $message,
            'is_admin' => $isAdmin
        ];
        return $this->insert('ticket_messages', $data);
    }
}
?>
