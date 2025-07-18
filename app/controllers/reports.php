<?php

class Reports extends Controller {

  public function __construct() {
    if (!isset($_SESSION['auth']) || $_SESSION['role'] !== 'admin') {
        die("Access denied. Admin only.");
      
    }

}
  public function index() {
          $reminderModel = $this->model('Reminder');
          $userModel = $this->model('User');

          $reminders = $reminderModel->get_all_reminders();
          $topUser = $reminderModel->get_user_with_most_reminders();
          $loginStats = $userModel->get_login_stats();

          $this->view('reports/index', [
              'reminders' => $reminders,
              'topUser' => $topUser,
              'loginStats' => $loginStats

          ]);
      }
  }