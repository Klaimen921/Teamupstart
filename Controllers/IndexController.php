<?php
namespace Controllers;

use Models\Chat;
use Models\LikeResume;
use Models\Message;
use Models\Resume;
use Models\Team;
use Models\User;

class IndexController
{
    public function index(string $view)
    {
        include "Views/{$view}.php";
    }

    public function admin(string $view)
    {
        $userRole = $_SESSION['role'];
        if ($userRole != 'admin') {
            header('Location: /login');

            exit();
        }

        $id = $_SESSION['user_id'];

        $users  = (new User)->getByUserId($id);
        $result = (new Resume)->all();

        include "Views/{$view}.php";
    }

    public function login()
    {
        $email    = $_POST['email'];
        $password = $_POST['password'];
        $result   = (new User)->authorize($email);

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];

                if ($_SESSION['role'] == 'admin') {
                    header('Location: /admin');
                } else{
                    header('Location: /profile');
                }
            } else {
                header('Refresh:2; url=/login');
                echo 'Не правильний логін або пароль. ';
            }
        } else {
            header('Refresh:2; url=/login');
            echo 'Помилка сервера!';
        }
    }

    public function register()
    {
        $name     = $_POST['name'];
        $email    = $_POST['email'];
        $password = $_POST['password'];
        $typeUser = $_POST['type_user'];

        if ($name && $email && $password && $typeUser) {
            $user = (new User)->getByEmail($email);

            if (!empty($user)) {
                header('Refresh:2; url=/register');
                echo 'Error. Was found user with the same credentials';
            } else {
                $data = [
                    'name'     => $name,
                    'email'    => $email,
                    'password' => $password,
                    'role'     => $typeUser
                ];

                $insertResult = (new User)->register($data);

                if ($insertResult) {
                    header('Location: /login');
                } else {
                    header('Refresh:2; url=/register');
                    echo 'Server Errors! Try again';
                }
            }
        } else {
            header('Refresh:2; url=/register');
            echo "errors";
        }
    }

    public function logout()
    {
        session_destroy();

        header('Location: ./');
    }

    public function search($view)
    {
        $selectedSkills    = $_GET['project-type'] ?? [];
        $schedule          = $_GET['schedule'] ?? 'all';
        $ageFilter         = $_GET['age_user'] ?? '';
        $experienceFilter  = $_GET['experience'] ?? '';
        $selectedLanguages = $_GET['languages'] ?? [];
        $toPrice           = $_GET['to_price'] ?? '';
        $fromPrice         = $_GET['from_price'] ?? '';

        $data = [
            'selectedSkills'    => $selectedSkills,
            'schedule'          => $schedule,
            'age_filter'        => $ageFilter,
            'experience_filter' => $experienceFilter,
            'selectedLanguages' => $selectedLanguages,
            'to_price'          => $toPrice,
            'from_price'        => $fromPrice
        ];

        $result = (new Resume)->getSearch($data);
        $responseRate = (new User)->getRate($result->num_rows);
        $timeToFill = (new Resume)->getMediumTime();

        include "Views/{$view}.php";
    }

    public function showApplications(string $view)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');

            exit();
        }

        $userId = $_SESSION['user_id'];
        $result = (new Team)->getApplicationsByUserId($userId);

        include "Views/{$view}.php";
    }

    public function showProfile(string $view)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');

            exit();
        }
        $id = $_SESSION['user_id'];

        $users     = (new User)->getByUserId($id);
        $usersData = (new Resume)->getByUserId($id);

        include "Views/{$view}.php";
    }

    public function updateProfile()
    {
        // Отримання даних з форми
        $adress         = $_POST['adress'] ?? '';
        $education      = $_POST['education'] ?? '';
        $languagesKnown = $_POST['languages_known'] ?? '';
        $certifications = $_POST['certifications'] ?? '';
        $description    = $_POST['description'] ?? '';
        $schedule       = $_POST['schedule'] ?? '';
        $fromPrice      = $_POST['from_price'] ?? '';
        $ageUser        = $_POST['age_user'] ?? '';
        $experience     = $_POST['experience'] ?? '';
        $languages      = isset($_POST['work-schedule']) ? implode(", ", $_POST['work-schedule']) : '';
        $skillsArray    = $_POST['project-type'] ?? [];
        $skills         = implode(", ", $skillsArray);

        // Значення статусу за замовчуванням
        $status = 0;

        // Отримання ідентифікатора користувача з сесії
        $userId = $_SESSION['user_id'] ?? null;

        if ($userId === null) {
            die('Користувач не авторизований.');
        }

        // Перевірка існування запису з таким самим `user_id`
        $checkResult = (new Resume)->checkExistsByUserId($userId);

        // Оновлення або вставка даних у `resume`
        if ($checkResult->num_rows > 0) {
            // Запис з таким самим `user_id` вже існує, здійснюємо оновлення даних
            $data = [
              'adress'          => $adress,
              'education'       => $education,
              'languages_known' => $languagesKnown,
              'certifications'  => $certifications,
              'skills'          => $skills,
              'description'     => $description,
              'schedule'        => $schedule,
              'from_price'      => $fromPrice,
              'age_user'        => $ageUser,
              'experience'      => $experience,
              'languages'       => $languages,
              'user_id'         => $userId
            ];

            $message = (new Resume)->update($data);
        } else {
            // Якщо запис не існує, здійснюється вставка нових даних
            $data = [
               'user_id'         => $userId,
               'adress'          => $adress,
               'education'       => $education,
               'languages_known' => $languagesKnown,
               'certifications'  => $certifications,
               'skills'          => $skills,
               'description'     => $description,
               'schedule'        => $schedule,
               'from_price'      => $fromPrice,
               'age_user'        => $ageUser,
               'experience'      => $experience,
               'languages'       => $languages,
               'status'          => $status
            ];

            $message = (new Resume)->create($data);
        }

        echo $message;
    }

   public function infoUser(string $view)
   {
       if (!isset($_SESSION['user_id'])) {
           header('Location: /login');

           exit();
       }

       $resumeFromApi = false;
       if (isset($_GET['newResumeId'])) {
           $resumeFromApi = true;
           $usersData     = (new Resume)->checkNewResumeById($_GET['newResumeId']);
           $users         = ['name' => 'resume from api', 'email' => ''];
       }

       if (isset($_GET['id'])) {
           $id = $_GET['id'];
           $users     = (new User)->getByUserId($id);
           $usersData = (new Resume)->getByUserId($id);
       }

       include "Views/{$view}.php";
   }

   public function changeStatusResume()
   {
       $idResume = $_POST['id_resume'] ?? null;
       $status   = $_POST['status'] ?? null;

       if ($idResume !== null && $status !== null) {
           $result = (new Resume)->updateStatusById($idResume, $status);

           if ($result['success']) {
               header('Location: ' . $_SERVER['HTTP_REFERER']);
               echo $result['message'];
           } else {
               header('Refresh:2; url=' . $_SERVER['HTTP_REFERER']);
               echo 'Помилка при оновленні статусу резюме: ' . $result['message'];
           }
       } else {
           header('Refresh:2; url=' . $_SERVER['HTTP_REFERER']);
           echo 'Недійсні дані.';
       }
   }

   public function addToFavorites()
   {
       $resumeId    = $_GET['id_resume'];
       $userId      = $_SESSION['user_id'];
       $resultCheck = (new LikeResume)->find($userId, $resumeId);

       if ($resultCheck->num_rows > 0) {
           // Запис вже існує, отримуємо поточний статус
           $row           = $resultCheck->fetch_assoc();
           $currentStatus = $row['status'];

           // Визначаємо новий статус: змінюємо 0 на 1 або 1 на 0
           $newStatus = ($currentStatus == 0) ? 1 : 0;

           $result = (new LikeResume)->update($newStatus, $resumeId, $userId);
       } else {
           $result = (new LikeResume)->create($userId, $resumeId);
       }

       if ($result['success']) {
           header('Location: /like');
       } else {
           echo 'Сталася помилка: ' . $result['error'];
       }
   }

    public function chats(string $view)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');

            exit();
        }

        $userId         = $_SESSION['user_id'];
        $chatListResult = (new Chat)->getQueryResultById($userId);
        $chatList       = $chatListResult['data'];

        if (!empty($chatListResult['error'])) {
            echo 'Помилка: ' . mysqli_error($chatListResult['error']);
            exit;
        }

        $chats = [];
        while ($chat = mysqli_fetch_assoc($chatList)) {
            // Визначаємо іншу сторону чату
            $otherUserId = ($chat['user1_id'] == $userId) ? $chat['user2_id'] : $chat['user1_id'];

            // Запит для отримання імені іншого користувача
            $userResult = (new User)->getByUserIdQueryResult($otherUserId);

            // Перевірка помилки запиту
            if (!empty($userResult['error'])) {
                echo 'Помилка: ' . $userResult['error'];
                continue;
            }

            // Отримуємо ім'я іншого користувача
            $user          = mysqli_fetch_assoc($userResult['data']);
            $otherUserName = $user['name'];

            if ($userId == $chat['user2_id']) {
                $idChat = $chat['user1_id'];
            } else {
                $idChat = $chat['user2_id'];
            }

            if ($idChat != $userId) {
                $chats[] = [
                  'chat_id'         => $idChat,
                  'other_user_name' => $otherUserName
                ];
            }
        }

        include "Views/{$view}.php";
    }

    public function chat(string $view)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');

            exit();
        }

        $currentUserId = $_SESSION['user_id'];
        $otherUserId   = $_GET['id'];

        $result = (new Chat)->getQueryResult($currentUserId, $otherUserId);

        if ($result->num_rows > 0) {
            $chat    = $result->fetch_assoc();
            $chatId = $chat['id'];
        } else {
            $chatId = (new Chat)->create($currentUserId, $otherUserId);
        }

        $messageList = (new Message)->getByChat($chatId);

        include "Views/{$view}.php";
    }

    public function startChat()
    {
        $status = false;
        $data = '';
        if (isset($_POST['chat_id']) && isset($_POST['message']) && isset($_POST['sender_id'])) {
            $chatId      = intval($_POST['chat_id']);
            $senderId    = intval($_POST['sender_id']);
            $message     = $_POST['message'];
            $sendMessage = (new Chat)->send($chatId, $senderId, $message);

            if ($sendMessage['success']) {
                $data = '<div class="chat-messages-item d-flex justify-content-end">
                            <p class="user-mess navigation-label padding-8 border-radius-12 surface-disabled"> '. $message .' </p>
                         </div>';

                $status = true;
            } else {
                $data = $sendMessage['error'];
            }
        }

        echo json_encode(['status' => $status, 'data' => $data]);
    }

    public function longPoolingChat()
    {
        $currentUserId = $_SESSION['user_id'];
        $otherUserId   = $_POST['other_user_id'];

        $result = (new Chat)->getQueryResult($currentUserId, $otherUserId);

        if ($result->num_rows > 0) {
            $chat    = $result->fetch_assoc();
            $chatId = $chat['id'];
        } else {
            $chatId = (new Chat)->create($currentUserId, $otherUserId);
        }

        $messageList = (new Message)->getByChat($chatId);

        ob_start();
        include 'partials/chat.php';
        $view = ob_get_clean();

        echo json_encode($view);
    }


    public function like(string $view)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');

            exit();
        }

        $userId = $_SESSION['user_id'];
        $result = (new LikeResume)->getLikesResumeById($userId);

        include "Views/{$view}.php";
    }

    public function inviteToTeam()
    {
        $idUser1 = $_SESSION['user_id'];
        $idUser2 = $_GET['id_user'];
        $status  = 2;

        $result = (new Team)->invite($idUser1, $idUser2, $status);

        if ($result['success']) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            echo $result['error'];
        }
    }

    public function changeInviteTeamStatus()
    {
        $idTeam = $_POST['id_team'];
        $status = $_POST['status'];

        $updateResult = (new Team)->updateStatus($idTeam, $status);

        if ($updateResult) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            header('Refresh:2; url=' . $_SERVER['HTTP_REFERER']);
            echo 'Server Errors! Try again';
        }
    }

    public function team(string $view)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');

            exit();
        }

        $userId = $_SESSION['user_id'];
        $result  = (new Team)->find($userId);

        include "Views/{$view}.php";
    }

    public function getListNewResume()
    {
        $list = file_get_contents('api/resume.json');

        header('Content-Type: application/json; charset=utf-8');
        echo $list;
    }

    public function updateNewResume()
    {
        $list = file_get_contents('api/resume.json');
        $status = 0;
        $list = json_decode($list,true);

        foreach ($list as $resumeId => $dataResume) {
            $checkResult = (new Resume)->checkNewResumeExistsById($resumeId);
            $data = [
                'user_id'         => 0,
                'adress'          => $dataResume['adress'],
                'education'       => $dataResume['education'],
                'languages_known' => $dataResume['lang'],
                'certifications'  => $dataResume['certifications'],
                'skills'          => $dataResume['skills'],
                'description'     => $dataResume['description'],
                'schedule'        => $dataResume['schedule'],
                'from_price'      => (int) $dataResume['from_price'],
                'age_user'        => '',
                'experience'      => $dataResume['experience'],
                'languages'       => $dataResume['languages'],
                'status'          => $status,
                'unique_new_resume_id' => $resumeId
            ];
            if ($checkResult->num_rows > 0) {
                (new Resume)->update($data, true);
            } else {
                (new Resume)->create($data, true);
            }
        }

        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}