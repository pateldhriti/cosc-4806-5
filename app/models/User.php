<?php

class User {
    public function __construct() {}

    public function create($username, $password) {
        $db = db_connect(); 
        $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);

        if ($stmt->rowCount() > 0) {
            return "Username already exists.";
        }

        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $insert = $db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        return $insert->execute([
            'username' => $username,
            'password' => $hashed
        ]);
    }

    public function authenticate($username, $password) {
        $db = db_connect();
        $username = strtolower(trim($username));

        $stmt = $db->prepare("SELECT * FROM log WHERE username = :username AND attempt = 'bad' ORDER BY timestamp DESC LIMIT 3");
        $stmt->execute(['username' => $username]);
        $attempts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($attempts) == 3) {
            $lastAttemptTime = strtotime($attempts[0]['timestamp']);
            if (time() - $lastAttemptTime < 60) {
                return "⏳ Locked for 60 seconds.";
            }
        }

        $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $this->log_attempt($username, 'good');
            $_SESSION['auth'] = 1;
            $_SESSION['username'] = $username;
            $_SESSION['user'] = $user;  // ✅ set user info
            return true;
        } else {
            $this->log_attempt($username, 'bad');
            return false;
        }
    }

    private function log_attempt($username, $result) {
        $db = db_connect();
        $stmt = $db->prepare("INSERT INTO log (username, attempt) VALUES (:username, :result)");
        $stmt->execute(['username' => $username, 'result' => $result]);
    }
}
