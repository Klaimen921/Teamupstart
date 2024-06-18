<?php

namespace Models;

class User extends Model
{
    public function getByUserId(int $id)
    {
        $userResult = mysqli_query($this->connect, "SELECT * FROM `users` WHERE `id` = $id");

        return mysqli_fetch_assoc($userResult);
    }

    public function getByUserIdQueryResult(int $id)
    {
        $error      = '';
        $user_query = "SELECT name FROM `users` WHERE id = $id";

        $data = mysqli_query($this->connect, $user_query);

        if (!$data) {
            $error = mysqli_error($this->connect);
        }

        return ['data' => $data, 'error' => $error];
    }

    public function getByEmail(string $email)
    {
        $checkQuery  = "SELECT * FROM `users` WHERE `email` = '$email'";
        $checkResult = mysqli_query($this->connect, $checkQuery);

        return mysqli_fetch_assoc($checkResult);
    }

    public function authorize(string $email)
    {
        $stmt = mysqli_prepare($this->connect, "SELECT `id`, `password`, `role` FROM `users` WHERE `email` = ?");
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);

        return mysqli_stmt_get_result($stmt);
    }

    public function register(array $data)
    {
        $name     = $data['name'];
        $email    = $data['email'];
        $password = $data['password'];
        $role     = $data['role'];

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $insertQuery    = "INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`) 
            VALUES (NULL, '$name', '$email', '$hashedPassword', '$role')";

        return mysqli_query($this->connect, $insertQuery);
    }

    public function getRate($countResume)
    {
        $rate = 0;
        $query = "
            SELECT DISTINCT messages.chat_id FROM messages
        JOIN users ON messages.sender_id = users.id
        WHERE users.role = 'employer'";

        $result = mysqli_query($this->connect, $query);
        $arr = mysqli_fetch_all($result);
        $countRequestFromEmployer = count($arr);

        if ($countRequestFromEmployer > 0 && $countResume > 0) {
            $rate = $countRequestFromEmployer/$countResume;
        }

        return round($rate,2);
    }
}