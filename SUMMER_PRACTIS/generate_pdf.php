<?php
require_once('vendor/autoload.php'); // Подключение TCPDF

// Получение HTML-кода из запроса
$html = $_POST['html'];

// Создание нового PDF документа
$pdf = new TCPDF();

// Установка метаданных документа
// ...

// Добавление новой страницы
$pdf->AddPage();

// Запись HTML-кода в PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Вывод PDF в виде файла
$pdf->Output('appointment_receipt.pdf', 'I');
