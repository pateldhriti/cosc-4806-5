<?php

class Reports extends Controller {
    public function index() {
        if (!isset($_SESSION['auth']) || $_SESSION['role'] !== 'admin') {
            echo "Access denied. Admin only.";
            return;
        }

        $reminderModel = new Reminder();
        $userModel = new User();

        $reminders = $reminderModel->get_all_reminders();
        $topUser = $reminderModel->get_user_with_most_reminders();
        $loginStats = $userModel->get_login_stats();

        // ✅ This line is the most important
        $this->view('reports/index', [
            'reminders' => $reminders,
            'topUser' => $topUser,
            'loginStats' => $loginStats
        ]);
    }
}
