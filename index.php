<?php
    require 'App/Constants.php';
    require 'App/Entities/InvoicesIssued.php';
    require 'App/Entities/Patients.php';
    require 'App/Entities/PaymentsMade.php';
    require 'App/Excel.php';
    require 'App/Files.php';
    require 'App/Helper.php';
    require 'App/HTML.php';
    require 'App/Validation.php';
    require 'vendor/autoload.php';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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

        $totalInvoicesCondition = !empty($finalePrices) && !empty($FCs);
        if ($totalInvoicesCondition) {
            $totalInvoices = Excel::generateAndGetTotalInvoices($finalePrices, $FCs);
        }

        $totalPaymentsCondition = !empty($FCs) && !empty($phones) && !empty($payments);
        if ($totalPaymentsCondition) {
            $totalPayments = Excel::generateAndGetPayments($FCs, $phones, $payments);
        }
    ?>

    <div class="container mt-4">
        <div class="card">
            <div class="card-body">

                <h5 class="card-title">Загрузка документов</h5>

                <?php if (!$totalInvoicesCondition && !$totalPaymentsCondition): ?>
                    <h6 class="card-subtitle mb-2 text-body-secondary">Загрузите документы, чтобы отобразить таблицы с отчётами</h6>
                <?php endif; ?>

                <form method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="formFile1" class="form-label">
                            <?= Constants::INVOICES_ISSUED ?>
                            <?php if (!empty($finalePrices)): ?><span> &#10004;</span> <?php endif; ?>
                        </label>
                        <input class="form-control" type="file" id="formFile1" name="uploads[<?= Constants::INVOICES_ISSUED_KEY ?>]" />
                    </div>
                    <div class="mb-3">
                        <label for="formFile2" class="form-label">
                            <?= Constants::PATIENTS ?>
                            <?php if (!empty($FCs)): ?><span> &#10004;</span> <?php endif; ?>
                        </label>
                        <input class="form-control" type="file" id="formFile2" name="uploads[<?= Constants::PATIENTS_KEY ?>]" />
                    </div>
                    <div class="mb-3">
                        <label for="formFile3" class="form-label">
                            <?= Constants::PAYMENTS_MADE ?>
                            <?php if (!empty($payments)): ?><span> &#10004;</span> <?php endif; ?></label>
                        <input class="form-control" type="file" id="formFile3" name="uploads[<?= Constants::PAYMENTS_MADE_KEY ?>]" />
                    </div>
                    <button type="submit" class="btn btn-outline-primary">Загрузить</button>
                </form>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">

                <h5 class="card-title">
                    <?php if ($totalInvoicesCondition): ?>
                        Сумма всех счетов
                    <?php else: ?>
                        Загрузите выставленные счета и список пациентов
                    <?php endif; ?>
                </h5>

                <?php
                    if ($totalInvoicesCondition) {
                        echo HTML::buildTotalInvoicesTable($totalInvoices);
                    }
                ?>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">

                <h5 class="card-title">
                    <?php if ($totalPaymentsCondition): ?>
                        Сумма совершённых платежей
                    <?php else: ?>
                        Загрузите совершённые платежи и список пациентов
                    <?php endif; ?>
                </h5>

                <?php
                    if ($totalPaymentsCondition) {
                        echo HTML::buildTotalPaymentsTable($totalPayments);
                    }
                ?>
            </div>
        </div>

    </div>

</body>
</html>
