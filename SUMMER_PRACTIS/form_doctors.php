<?php

//include ('config.php'); // подключение к базе данных

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //$fullName = $specialty = $fee = $commission = '';
    $fullName = $_POST['fullName'];
    $specialty = $_POST['specialty'];
    $fee = $_POST['fee'];
    $commission = $_POST['commission'];

    include('../impotent.php');
    $servername = "localhost";
    $username = username;
    $password = password;
    $dbname = username;

    try {
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Не могу подключиться к базе данных: " . $e->getMessage());
    }

    $sql = "INSERT INTO Doctors (FullName, Specialty, ConsultationFee, Commission) VALUES ( :fullName, :specialty, :fee, :commission)";
    $stmt = $pdo->prepare($sql);

    $sql->bindParam(':fullName', $fullName);
    $sql->bindParam(':specialty', $specialty);
    $sql->bindParam(':fee', $fee);
    $sql->bindParam(':commission', $commission);




    $stmt->execute();
    $lastId = $pdo->lastInsertId();



    try {
        $stmt->execute([$fullName, $specialty, $fee, $commission]);
        echo "Врач успешно добавлен.";
    } catch (PDOException $e) {
        die("Ошибка при добавлении врача: " . $e->getMessage());
    }
}else {

    header("Location: form_doctors.html");
    exit;
}
?>
