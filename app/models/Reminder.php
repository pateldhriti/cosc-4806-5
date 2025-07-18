<?php

class Reminder extends Controller {

    public function get_all_reminders_by_username($username) {
        $db = db_connect();
        $stmt = $db->prepare("
            SELECT notes.* FROM notes 
            JOIN users ON notes.user_id = users.id 
            WHERE users.username = :username AND notes.deleted = 0
        ");
        $stmt->execute(['username' => $username]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create_reminder_by_username($username, $subject) {
        $db = db_connect();

        $stmt = $db->prepare("SELECT id FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return false;
        }

        $stmt = $db->prepare("
            INSERT INTO notes (user_id, subject, created_at, completed, deleted) 
            VALUES (:user_id, :subject, NOW(), 0, 0)
        ");
        return $stmt->execute([
            'user_id' => $user['id'],
            'subject' => $subject
        ]);
    }

    public function update_reminder($id, $new_subject) {
        $db = db_connect();
        $stmt = $db->prepare("UPDATE notes SET subject = :subject WHERE id = :id");
        return $stmt->execute([
            'subject' => $new_subject,
            'id' => $id
        ]);
    }

    public function delete_reminder($id) {
        $db = db_connect();
        $stmt = $db->prepare("UPDATE notes SET deleted = 1 WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function get_reminder_by_id($id) {
        $db = db_connect();
        $stmt = $db->prepare("SELECT * FROM notes WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function get_all_reminders() {
        $db = db_connect();
        $stmt = $db->prepare("
            SELECT notes.*, users.username 
            FROM notes 
            JOIN users ON notes.user_id = users.id 
            WHERE notes.deleted = 0
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_user_with_most_reminders() {
        $db = db_connect();
        $stmt = $db->prepare("
            SELECT users.username, COUNT(notes.id) as total 
            FROM notes 
            JOIN users ON notes.user_id = users.id 
            WHERE notes.deleted = 0
            GROUP BY users.id 
            ORDER BY total DESC 
            LIMIT 1
        ");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
}
