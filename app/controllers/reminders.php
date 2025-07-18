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
        $reminder = $this->model('Reminder');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $reminder->update_reminder($id, $_POST['subject']);
            header('Location: /reminders');
            exit;
        }

        $note = $reminder->get_reminder_by_id($id);
        $this->view('reminders/edit', ['note' => $note]);
    }

    public function delete($id = null) {
        $reminder = $this->model('Reminder');
        $reminder->delete_reminder($id);
        header('Location: /reminders');
        exit;
    }
}
