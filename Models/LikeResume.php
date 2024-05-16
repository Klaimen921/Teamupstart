<?php

namespace Models;

class LikeResume extends Model
{
    public function getLikesResumeById(int $userId)
    {
        $query = "
    SELECT lr.id, lr.id_user, lr.id_resume, lr.status, 
           u.id AS user_id,
           u.name AS resume_user_name, 
           r.skills AS resume_skills, 
           r.user_id AS resume_user_id,
           t.status AS team_status
    FROM like_resume lr
    JOIN resume r ON lr.id_resume = r.id
    JOIN users u ON r.user_id = u.id
    LEFT JOIN team t ON (t.id_user_1 = r.user_id AND t.id_user_2 = ?) OR (t.id_user_1 = ? AND t.id_user_2 = r.user_id)
    WHERE lr.id_user = ? AND lr.status = '1';
";

        // Підготуємо запит
        $stmt = $this->connect->prepare($query);

        // Зв'яжемо параметр `$userId` із запитом
        $stmt->bind_param('iii', $userId, $userId, $userId);

        // Виконуємо запит
        $stmt->execute();

        // Отримуємо результат запиту
        return $stmt->get_result();
    }

    public function find(int $userId, int $resumeId)
    {
        $sql_check = "SELECT `status` FROM `like_resume` WHERE `id_resume` = ? AND `id_user` = ?";
        $stmt_check = $this->connect->prepare($sql_check);
        $stmt_check->bind_param("ii", $resumeId, $userId);
        $stmt_check->execute();

        return $stmt_check->get_result();
    }

    public function create(int $userId, int $resumeId)
    {
        $error = '';
        $success = true;
        $sql_insert = "INSERT INTO `like_resume` (`id`, `id_resume`, `id_user`, `status`) VALUES (NULL, ?, ?, 1)";
        $stmt_insert = $this->connect->prepare($sql_insert);
        $stmt_insert->bind_param("ii", $resumeId, $userId);

        if (!$stmt_insert->execute()) {
            $success = false;
            $error = $stmt_insert->error;
        }

        return ['success' => $success, 'error' => $error];
    }

    public function update(int $newStatus, int $resumeId, int $userId)
    {
        $error   = '';
        $success = true;
        $sql_update  = "UPDATE `like_resume` SET `status` = ? WHERE `id_resume` = ? AND `id_user` = ?";
        $stmt_update = $this->connect->prepare($sql_update);
        $stmt_update->bind_param("iii", $newStatus, $resumeId, $userId);

        if (!$stmt_update->execute()) {
            $success = false;
            $error = $stmt_update->error;
        }

        return ['success' => $success, 'error' => $error];
    }
}