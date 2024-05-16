<?php
namespace Models;

class Model
{
    public $connect;

    public function __construct()
    {
        $this->connect = mysqli_connect('localhost', 'root', 'root', 'teamupstart');

        if (!$this->connect) {
            die('Помилка підключення до бази даних: ' . mysqli_connect_error());
        }
    } 
}