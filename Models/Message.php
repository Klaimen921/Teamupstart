<?php

namespace Models;

class Message extends Model
{
    public function getByChat(int $id)
    {
        $messageList = mysqli_query($this->connect, "SELECT * FROM `messages` WHERE chat_id = $id");

        return mysqli_fetch_all($messageList);
    }
}