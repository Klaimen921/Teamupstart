<?php

namespace Models;

class Chat extends Model
{
    public function getQueryResult(int $currentUserId, int $otherUserId)
    {
        $query = "SELECT id FROM chats WHERE (user1_id = $currentUserId AND user2_id = $otherUserId) OR (user1_id = $otherUserId AND user2_id = $currentUserId)";

        return $this->connect->query($query);
    }

    public function getQueryResultById(int $userId)
    {
        $error = '';
        $chat_query = "SELECT * FROM `chats` WHERE user1_id = $userId OR user2_id = $userId";

        $data = mysqli_query($this->connect, $chat_query);

        if (!$data) {
            $error = mysqli_error($this->connect);
        }

        return ['data' => $data, 'error' => $error];
    }

    public function create(int $currentUserId, int $otherUserId)
    {
        $query = "INSERT INTO chats (user1_id, user2_id) VALUES ($currentUserId, $otherUserId)";
        $this->connect->query($query);

        return $this->connect->insert_id;
    }

    public function send(int $chatId, int $senderId, string $message)
    {
        $error   = '';
        $message = mysqli_real_escape_string($this->connect, $message);

        // Перевірка, чи існує `chat_id` в `chats`
        $query  = "SELECT id FROM chats WHERE id = $chatId";
        $result = $this->connect->query($query);

        if ($result->num_rows > 0) {
            // Вставка повідомлення, якщо `chat_id` існує
            $query = "INSERT INTO messages (chat_id, sender_id, message) VALUES ($chatId, $senderId, '$message')";
            $this->connect->query($query);

            if ($this->connect->error) {
                $success = false;
                $error   = 'Помилка: ' . $this->connect->error;
            } else {
                $success = true;
            }
        } else {
            $error   = 'Некоректне значення chat_id.';
            $success = false;
        }

        return ['success' => $success, 'error' => $error];
    }
}