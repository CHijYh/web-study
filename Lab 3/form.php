<?php
session_start();

$user = 'ваш_логин';
$pass = 'ваш_пароль';
$db_name = 'ваш_логин';
$host = 'localhost';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fio = trim($_POST['fio'] ?? '');
    $langs = $_POST['languages'] ?? [];
    
    if (!preg_match("/^[a-zA-Zа-яА-ЯёЁ\s\-]+$/u", $fio)) $errors[] = "Ошибка в ФИО.";
    if (empty($langs)) $errors[] = "Выберите язык.";

    if (empty($errors)) {
        try {
            $db = new PDO("mysql:host=$host;dbname=$db_name", $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);

            $db->beginTransaction();

            $stmt = $db->prepare("INSERT INTO applications (full_name, phone, email, birth_date, gender, biography, contract_agreed) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $fio, 
                $_POST['phone'], 
                $_POST['email'], 
                $_POST['birthday'], 
                $_POST['gender'], 
                $_POST['bio'], 
                1
            ]);
            $app_id = $db->lastInsertId();

            $get_lang_id = $db->prepare("SELECT id FROM languages WHERE name = ?");
            $link_lang = $db->prepare("INSERT INTO application_languages (application_id, language_id) VALUES (?, ?)");

            foreach ($langs as $lang_name) {
                $get_lang_id->execute([$lang_name]);
                $lang_data = $get_lang_id->fetch();
                
                if ($lang_data) {
                    $link_lang->execute([$app_id, $lang_data['id']]);
                }
            }

            $db->commit();
            $_SESSION['messages'] = ["Заявка №$app_id успешно сохранена!"];
            $_SESSION['status'] = 'success';
        } catch (PDOException $e) {
            if (isset($db)) $db->rollBack();
            $_SESSION['messages'] = ["Ошибка: " . $e->getMessage()];
            $_SESSION['status'] = 'error';
        }
    } else {
        $_SESSION['messages'] = $errors;
        $_SESSION['status'] = 'error';
    }
}
header("Location: index.php");
exit();
