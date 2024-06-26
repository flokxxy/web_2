<?php
// Подключение к базе данных
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "username";

$db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

// ID приема, который будет отображаться на квитанции
$appointment_id = 1;

// Получение данных о приеме
$sql = "SELECT p.LastName AS patient_last_name, p.FirstName AS patient_first_name, p.MiddleName AS patient_middle_name,
               p.BirthDate AS patient_birth_date, p.Address AS patient_address,
               d.FullName AS doctor_full_name, d.Specialty AS doctor_specialty, d.ConsultationFee AS consultation_fee,
               d.Commission AS commission,
               a.Date AS appointment_date
        FROM Appointments a
        INNER JOIN Patients p ON a.PatientID = p.PatientID
        INNER JOIN Doctors d ON a.DoctorID = d.DoctorID
        WHERE a.AppointmentID = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$appointment_id]);
$appointment = $stmt->fetch(PDO::FETCH_ASSOC);

// Расчет стоимости приема с учетом подоходного налога
$consultation_fee = $appointment['consultation_fee'];
$commission = $appointment['commission'];
$tax_rate = 0.13; // Ставка подоходного налога
$tax_amount = $consultation_fee * $tax_rate;
$total_amount = $consultation_fee + $tax_amount;

// Формирование квитанции в HTML
$html = "<h1>Квитанция о приеме</h1>";
$html .= "<p>Пациент: {$appointment['patient_last_name']} {$appointment['patient_first_name']} {$appointment['patient_middle_name']}</p>";
$html .= "<p>Дата рождения: {$appointment['patient_birth_date']}</p>";
$html .= "<p>Адрес: {$appointment['patient_address']}</p>";
$html .= "<p>Врач: {$appointment['doctor_full_name']}</p>";
$html .= "<p>Специальность: {$appointment['doctor_specialty']}</p>";
$html .= "<p>Дата и время приема: {$appointment['appointment_date']}</p>";
$html .= "<p>Стоимость приема: {$consultation_fee} руб.</p>";
$html .= "<p>Комиссия врача: {$commission}%</p>";
$html .= "<p>Сумма подоходного налога: {$tax_amount} руб.</p>";
$html .= "<p>Итого к оплате: {$total_amount} руб.</p>";

// Создание PDF из HTML и сохранение в файл
require_once('vendor/autoload.php'); // Подключение TCPDF

// Создание нового PDF документа
$pdf = new TCPDF();

// Установка метаданных документа
$pdf->SetCreator('Your Name');
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Appointment Receipt');
$pdf->SetSubject('Appointment Receipt');
$pdf->SetKeywords('Appointment, Receipt, PDF');

// Установка шрифтов
$pdf->SetFont('dejavusans', '', 12);

// Добавление новой страницы
$pdf->AddPage();

// Запись HTML-кода в PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Сохранение PDF в файл
$pdfFilePath = 'appointment_receipt.pdf';
$pdf->Output($pdfFilePath, 'F');

// Вывод ссылки для скачивания PDF
echo '<a href="' . $pdfFilePath . '" download>Скачать PDF</a>';
?>
