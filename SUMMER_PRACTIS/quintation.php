<h1>Квитанция о приеме</h1>
<p>Пациент: <?php echo $row['PatientLastName'] . ' ' . $row['PatientFirstName'] . ' ' . $row['PatientMiddleName']; ?></p>
<p>Врач: <?php echo $row['DoctorName']; ?></p>
<p>Дата и время приема: <?php echo $row['AppointmentDate']; ?></p>
<p>Стоимость приема: <?php echo $row['PaymentAmount']; ?></p>
