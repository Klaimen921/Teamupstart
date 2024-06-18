<?php

namespace Models;

class Resume extends Model
{
    public function getByUserId(int $id)
    {
        $userInfoList = mysqli_query($this->connect, "SELECT * FROM `resume` WHERE `user_id` = $id");

        return mysqli_fetch_assoc($userInfoList);
    }

    public function checkNewResumeById(int $id)
    {
        $userResult = mysqli_query($this->connect, "SELECT * FROM `resume` WHERE `unique_new_resume_id` = $id");

        return mysqli_fetch_assoc($userResult);
    }

    public function checkNewResumeExistsById(int $id)
    {
        $checkQuery = "SELECT * FROM `resume` WHERE `unique_new_resume_id` = ?";
        $checkStmt = $this->connect->prepare($checkQuery);
        $checkStmt->bind_param("i", $id);
        $checkStmt->execute();

        return $checkStmt->get_result();
    }


    public function checkExistsByUserId(int $id)
    {
        $checkQuery = "SELECT * FROM `resume` WHERE `user_id` = ?";
        $checkStmt = $this->connect->prepare($checkQuery);
        $checkStmt->bind_param("i", $id);
        $checkStmt->execute();

        return $checkStmt->get_result();
    }

    public function all()
    {
        $query = "
            SELECT resume.*, IFNULL(users.name, 'resume from api') AS name FROM resume
                LEFT JOIN users ON resume.user_id = users.id";

        return mysqli_query($this->connect, $query);
    }

    public function create(array $data, $isCreateFromFile = false)
    {
        $newResumeId = $isCreateFromFile ? $data['unique_new_resume_id'] : 0;
        $insertQuery = "INSERT INTO `resume` (`user_id`, `adress`, `education`, `lang`, `certifications`, `skills`, `description`, `schedule`, `from_price`, `age_user`, `experience`, `languages`, `status`, `unique_new_resume_id`) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $insertStmt = $this->connect->prepare($insertQuery);
        $insertStmt->bind_param(
            "issssssssssiii",
            $data['user_id'],
            $data['adress'],
            $data['education'],
            $data['languages_known'],
            $data['certifications'],
            $data['skills'],
            $data['description'],
            $data['schedule'],
            $data['from_price'],
            $data['age_user'],
            $data['experience'],
            $data['languages'],
            $data['status'],
            $newResumeId
        );

        if ($insertStmt->execute()) {
            $message = 'success';
        } else {
            $message = 'Помилка під час вставлення: ' . $insertStmt->error;
        }

        return $message;
    }

    public function update(array $data, $isUpdateFromFile = false)
    {
        if ($isUpdateFromFile) {
            $newResumeId = $isUpdateFromFile ? $data['unique_new_resume_id'] : 0;
            $updateQuery = "UPDATE `resume` SET `adress` = ?, `education` = ?, `lang` = ?, `certifications` = ?, `skills` = ?,
        `description` = ?, `schedule` = ?, `from_price` = ?, `age_user` = ?, `experience` = ?, `languages` = ?, `status` = 0 WHERE `unique_new_resume_id` = ?";
            $updateStmt = $this->connect->prepare($updateQuery);
            $updateStmt->bind_param(
                "sssssssssssi",
                $data['adress'],
                $data['education'],
                $data['languages_known'],
                $data['certifications'],
                $data['skills'],
                $data['description'],
                $data['schedule'],
                $data['from_price'],
                $data['age_user'],
                $data['experience'],
                $data['languages'],
                $newResumeId
            );
        } else {
            $updateQuery = "UPDATE `resume` SET `adress` = ?, `education` = ?, `lang` = ?, `certifications` = ?, `skills` = ?,
        `description` = ?, `schedule` = ?, `from_price` = ?, `age_user` = ?, `experience` = ?, `languages` = ?, `status` = 0 WHERE `user_id` = ?";
            $updateStmt = $this->connect->prepare($updateQuery);
            $updateStmt->bind_param(
                "sssssssssssi",
                $data['adress'],
                $data['education'],
                $data['languages_known'],
                $data['certifications'],
                $data['skills'],
                $data['description'],
                $data['schedule'],
                $data['from_price'],
                $data['age_user'],
                $data['experience'],
                $data['languages'],
                $data['user_id']
            );
        }

        if ($updateStmt->execute()) {
            $message = 'success';
        } else {
            $message = 'Помилка під час оновлення: ' . $updateStmt->error;
        }

        return $message;
    }

    public function updateStatusById(int $idResume, int $status)
    {
        // Підготовлений запит для безпечного оновлення статусу резюме
        $query = "UPDATE `resume` SET `status` = ? WHERE `id` = ?";
        $stmt = $this->connect->prepare($query);

        // Зв'язування параметрів з відповідними типами
        $stmt->bind_param("ii", $status, $idResume);

        // Виконання запиту та перевірка результату
        if ($stmt->execute()) {
            $message = 'Статус резюме оновлено успішно.';
            $success = true;
        } else {
            $success = false;
            $message = 'Помилка при оновленні статусу резюме: ' . $stmt->error;
        }

        return ['success' => $success, 'message' => $message];
    }

    public function getSearch(array $data)
    {
        $query = "SELECT 
            resume.id AS resume_id,
            users.id AS user_id,
            IFNULL(users.name, 'resume from api') AS user_name,
            resume.adress,
            resume.education,
            resume.languages,
            resume.certifications,
            resume.skills,
            resume.from_price,
            resume.description,
            resume.unique_new_resume_id
          FROM 
            resume
          LEFT JOIN
            users ON resume.user_id = users.id
          WHERE
            (resume.status = 2 or unique_new_resume_id > 0)";

        $selectedSkills = $data['selectedSkills'];
        $schedule = $data['schedule'];
        $ageFilter = $data['age_filter'];
        $experienceFilter = $data['experience_filter'];
        $selectedLanguages = $data['selectedLanguages'];
        $toPrice = $data['to_price'];
        $fromPrice = $data['from_price'];

        $conditions = [];

        if (!empty($selectedSkills)) {
            $skillsCondition = [];
            foreach ($selectedSkills as $skill) {
                $skillsCondition[] = "resume.skills LIKE '%" . $this->connect->real_escape_string($skill) . "%'";
            }
            $conditions[] = "(" . implode(' OR ', $skillsCondition) . ")";
        }

        if ($fromPrice !== '' && $toPrice !== '') {
            $conditions[] = "resume.from_price BETWEEN '" . $this->connect->real_escape_string($fromPrice) . "' AND '" . $this->connect->real_escape_string($toPrice) . "'";
        } elseif ($fromPrice !== '') {
            $conditions[] = "resume.from_price >= '" . $this->connect->real_escape_string($fromPrice) . "'";
        } elseif ($toPrice !== '') {
            $conditions[] = "resume.from_price <= '" . $this->connect->real_escape_string($toPrice) . "'";
        }

        if ($schedule !== 'all') {
            $conditions[] = "resume.schedule = '" . $this->connect->real_escape_string($schedule) . "'";
        }

        if ($ageFilter !== '') {
            $conditions[] = "resume.age_user = '" . $this->connect->real_escape_string($ageFilter) . "'";
        }

        if ($experienceFilter !== '') {
            $conditions[] = "resume.experience = '" . $this->connect->real_escape_string($experienceFilter) . "'";
        }

        if (!empty($selectedLanguages)) {
            $languagesCondition = [];
            foreach ($selectedLanguages as $language) {
                $languagesCondition[] = "resume.languages LIKE '%" . $this->connect->real_escape_string($language) . "%'";
            }
            if (!empty($languagesCondition)) {
                $conditions[] = "(" . implode(' OR ', $languagesCondition) . ")";
            }
        }

        // Формування умови WHERE з усіх умов
        if (!empty($conditions)) {
            $query .= ' AND ' . implode(' AND ', $conditions);
        }

        // Виконання запиту
        $result = $this->connect->query($query);

        if (!$result) {
            die('Помилка виконання запиту: ' . $this->connect->error);
        }

        return $result;
    }

    public function getMediumTime()
    {
        $mediumTime = 0;
        $query = "
            SELECT team.created_at as team_created_at, resume.created_at as resume_created_at FROM resume
        JOIN team ON resume.user_id = team.id_user_2";
        $res = mysqli_query($this->connect, $query);

        $arr = mysqli_fetch_all($res);
        $count = count($arr);
        $diff = 0;
        foreach ($arr as $item) {
            $toTime = strtotime($item[0]);
            $fromTime = strtotime($item[1]);
            $diff+= round(abs($toTime - $fromTime) / 60,2);

        }

        if ($diff > 0 && $count > 0) {
            $mediumTime = round($diff/$count,2);
        }

        return $mediumTime;
    }
}