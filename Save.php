<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fio = trim($_POST['fio']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $gender = $_POST['gender'];
    $region = trim($_POST['region']);
    $date_rozh = $_POST['date_rozh']; 
    $soglasie = isset($_POST['soglasie']);
    $password = trim($_POST['password']); 

    $errors = [];

    //Проверка данных с формы
    if (empty($fio)) {
        $errors[] = "ФИО не может быть пустым.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Некорректный email.";
    }
    if (empty($phone) || !preg_match('/^\+?[0-9]{10,15}$/', $phone)) {
        $errors[] = "Некорректный номер телефона.";
    }
    if (empty($gender)) {
        $errors[] = "Выберите пол.";
    }
    if (empty($region)) {
        $errors[] = "Выберите регион.";
    }
    if (empty($date_rozh)) {
        $errors[] = "Дата рождения не может быть пустой.";
    }
    if (!$soglasie) {
        $errors[] = "Необходимо дать согласие на обработку персональных данных.";
    }
    if (empty($password)) {
        $errors[] = "Пароль не может быть пустым.";
    }
    if (empty($errors)) {
        $data = [
            'fio' => $fio,
            'email' => $email,
            'phone' => $phone,
            'gender' => $gender,
            'region' => $region,
            'date_rozh' => $date_rozh, 
            'tecush_date' => date('Y-m-d H:i:s'),
            'soglasie' => $soglasie,
            'password' => $password 
        ];
        $filePath = 'dannie.json';
        $currentData = [];
        if (file_exists($filePath)) {
            $currentData = json_decode(file_get_contents($filePath), true);
        }
        $currentData[] = $data;
        file_put_contents($filePath, json_encode($currentData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        echo "Данные успешно сохранены!";
    } else {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    }
} else {
    echo "Некорректный запрос.";
}
?>
