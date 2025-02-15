<?php
    require 'App/Constants.php';
    require 'App/Entities/InvoicesIssued.php';
    require 'App/Entities/Patients.php';
    require 'App/Entities/PaymentsMade.php';
    require 'App/Excel.php';
    require 'App/Files.php';
    require 'App/Helper.php';
    require 'App/HTML.php';
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

        $invoicesIssued = new InvoicesIssued();
        $patients = new Patients();
        $paymentsMade = new PaymentsMade();

        $finalePrices = $invoicesIssued->getGroupedIdsAndFinalePrices();
        $FCs = $patients->getGroupedIdsAndFCs();
        $phones = $patients->getGroupedIdsAndPhones();
        $payments = $paymentsMade->getGroupedIdsAndPayments();

        $totalInvoices = [];
        $totalPayments = [];

        $totalInvoicesTable = null;
        $totalPaymentsTable = null;

        if (!empty($finalePrices) && !empty($FCs)) {
            $totalInvoices = Excel::generateAndGetTotalInvoices($finalePrices, $FCs);
        }

        if (!empty($FCs) && !empty($phones) && !empty($payments)) {
            $totalPayments = Excel::generateAndGetPayments($FCs, $phones, $payments);
        }
    ?>

    <h2>Загрузка файлов</h2>
    <form method="post" enctype="multipart/form-data">
        <?= Constants::INVOICES_ISSUED ?>: <input type="file" name="uploads[<?= Constants::INVOICES_ISSUED_KEY ?>]" /><br />
        <?= Constants::PATIENTS ?>: <input type="file" name="uploads[<?= Constants::PATIENTS_KEY ?>]" /><br />
        <?= Constants::PAYMENTS_MADE ?>: <input type="file" name="uploads[<?= Constants::PAYMENTS_MADE_KEY ?>]" /><br />
        <input type="submit" value="Загрузить" />
    </form>

    <?= HTML::buildTotalInvoicesTable($totalInvoices); ?>
    <?= HTML::buildTotalPaymentsTable($totalPayments); ?>

</body>
</html>
