<?php
require_once 'core/Controller.php';
require_once 'core/Session.php';
require_once 'models/Ticket.php';

class TicketController extends Controller {
    private $ticketModel;

    public function __construct() {
        Session::start();
        if (!Session::get('user_id')) {
            $this->redirect('/auth/login');
        }
        $this->ticketModel = $this->model('Ticket');
    }

    public function index() {
        $userId = Session::get('user_id');
        $tickets = $this->ticketModel->getUserTickets($userId);
        $this->view('user/ticket/list', ['tickets' => $tickets]);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = Session::get('user_id');
            $subject = $_POST['subject'];
            $message = $_POST['message'];
            $priority = $_POST['priority'];

            $ticketData = [
                'user_id' => $userId,
                'subject' => $subject,
                'priority' => $priority
            ];
            $ticketId = $this->ticketModel->insert($ticketData);

            if ($ticketId) {
                $this->ticketModel->addMessage($ticketId, $userId, $message);
                Session::set('success_message', 'Tiket berhasil dibuat. Kami akan segera menanggapi.');
                $this->redirect('/tickets');
            } else {
                $error = 'Gagal membuat tiket.';
                $this->view('user/ticket/create', ['error' => $error]);
            }
        } else {
            $this->view('user/ticket/create');
        }
    }

    public function view($ticketId) {
        $userId = Session::get('user_id');
        $ticketData = $this->ticketModel->getTicketWithMessages($ticketId);

        if ($ticketData && $ticketData[0]['user_id'] == $userId) {
            $this->view('user/ticket/view', ['ticketData' => $ticketData, 'ticketId' => $ticketId]);
        } else {
            $this->redirect('/tickets');
        }
    }

    public function reply($ticketId) {
        $userId = Session::get('user_id');
        $ticket = $this->ticketModel->find($ticketId);

        if (!$ticket || $ticket['user_id'] != $userId) {
            $this->redirect('/tickets');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $message = $_POST['message'];
            if ($this->ticketModel->addMessage($ticketId, $userId, $message)) {
                $this->redirect('/tickets/view/' . $ticketId);
            } else {
                $error = 'Gagal mengirim balasan.';
                $ticketData = $this->ticketModel->getTicketWithMessages($ticketId);
                $this->view('user/ticket/view', ['ticketData' => $ticketData, 'ticketId' => $ticketId, 'error' => $error]);
            }
        } else {
            $this->redirect('/tickets/view/' . $ticketId);
        }
    }
}
?>
