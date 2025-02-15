<?php
    require 'App/Constants.php';
    require 'App/Entities/InvoicesIssued.php';
    require 'App/Entities/Patients.php';
    require 'App/Excel.php';
    require 'App/Files.php';
    require 'App/Helper.php';
    require 'vendor/autoload.php';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Обработка данных пациентов</title>
</head>
<body>

    <?php
        Files::uploadFiles();
        Excel::generateTotalInvoices();
    ?>

    <h2>Загрузка файлов</h2>
    <form method="post" enctype="multipart/form-data">
        <?= Constants::INVOICES_ISSUED ?>: <input type="file" name="uploads[<?= Constants::INVOICES_ISSUED_KEY ?>]" /><br />
        <?= Constants::PATIENTS ?>: <input type="file" name="uploads[<?= Constants::PATIENTS_KEY ?>]" /><br />
        <?= Constants::PAYMENTS_MADE ?>: <input type="file" name="uploads[<?= Constants::PAYMENTS_MADE_KEY ?>]" /><br />
        <input type="submit" value="Загрузить" />
    </form>

</body>
</html>
