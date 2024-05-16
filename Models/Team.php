<?php

namespace Models;

class Team extends Model
{
    public function getApplicationsByUserId(int $id)
    {
        $query = "
    SELECT team.*, users.name AS user_name_1, u.name AS user_name_2
    FROM team
    JOIN users ON team.id_user_1 = users.id
    JOIN users u ON team.id_user_2 = u.id
    WHERE team.id_user_2 = $id
";

        return mysqli_query($this->connect, $query);
    }

    public function find(int $userId)
    {
        $query = "
    SELECT team.*, users.name AS user_name_1, u.name AS user_name_2
    FROM team
    JOIN users ON team.id_user_1 = users.id
    JOIN users u ON team.id_user_2 = u.id
    WHERE team.id_user_1 = $userId
    AND team.status = 1
";

        return mysqli_query($this->connect, $query);
    }

    public function invite(int $idUser1, int $idUser2, int $status)
    {
        $statusQuery = true;
        $error       = '';
        $checkQuery  = "SELECT * FROM team WHERE id_user_1 = '$idUser1' AND id_user_2 = '$idUser2'";
        $checkResult = mysqli_query($this->connect, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            $statusQuery = false;
            $error  = 'The same record already exists!';
        } else {
            $insertQuery = "INSERT INTO `team` (`id_team`, `id_user_1`, `id_user_2`, `status`) 
                    VALUES (NULL, '$idUser1', '$idUser2', '$status')";
            $insertResult = mysqli_query($this->connect, $insertQuery);

            if (!$insertResult) {
                $statusQuery = false;
                $error  = 'Server Errors! Try again';
            }
        }

        return ['success' => $statusQuery, 'error' => $error];
    }

    public function updateStatus(int $idTeam, int $status)
    {
        $updateQuery = "UPDATE team SET status = '$status' WHERE id_team = '$idTeam'";

        return mysqli_query($this->connect, $updateQuery);
    }
}