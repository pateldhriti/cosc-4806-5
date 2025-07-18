<?php

class Reminders extends Controller {

    public function index() {
        if (!isset($_SESSION['auth']) || !isset($_SESSION['username'])) {
            echo "User not authenticated.";
            exit;
        }

        $reminder = $this->model('Reminder');
        $list_of_reminders = $reminder->get_all_reminders_by_username($_SESSION['username']);
        $this->view('reminders/index', ['reminders' => $list_of_reminders]);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $subject = $_POST['subject'];
            $reminder = $this->model('Reminder');
            $reminder->create_reminder_by_username($_SESSION['username'], $subject);
            header('Location: /reminders');
            exit;
        }

        $this->view('reminders/create');
    }

    public function edit($id = null) {
        if (!isset($_SESSION['auth'])) {
            redirect('/login');
        }

        $reminderModel = $this->model('Reminder');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $subject = $_POST['subject'] ?? '';

            if (!empty($subject)) {
                $reminderModel->update_reminder($id, $subject);
                redirect('/reminders');
            } else {
                $this->view('reminders/edit', [
                    'reminder' => ['id' => $id, 'subject' => ''],
                    'error' => 'Subject cannot be empty.'
                ]);
            }
        } else {
            $reminder = $reminderModel->get_reminder_by_id($id);

            if (!$reminder) {
                die("Reminder not found.");
            }

            $this->view('reminders/edit', ['reminder' => $reminder]);
        }
    }


    public function delete($id = null) {
        $reminder = $this->model('Reminder');
        $reminder->delete_reminder($id);
        header('Location: /reminders');
        exit;
    }

    public function get_user_with_most_reminders() {
        $db = db_connect();
        $stmt = $db->prepare("
            SELECT users.username, COUNT(notes.id) AS total
            FROM notes 
            JOIN users ON notes.user_id = users.id
            GROUP BY users.username
            ORDER BY total DESC
            LIMIT 1
        ");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
