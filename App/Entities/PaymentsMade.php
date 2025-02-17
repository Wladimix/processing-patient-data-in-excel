<?php

class PaymentsMade
{

    private $paymentsMadeTable = [];

    private $idsColumn = [];
    private $paymentsColumn = [];

    public function __construct()
    {
        if (file_exists(Files::getDocumentsPath() . Constants::PAYMENTS_MADE_FILE_NAME)) {
            $this->paymentsMadeTable = Excel::readFile(Files::getDocumentsPath() . Constants::PAYMENTS_MADE_FILE_NAME);
        }
    }

    public function getGroupedIdsAndPayments()
    {
        $this->filterColumnsByIdAndPayment();

        $groupedData = [];

        foreach($this->paymentsColumn as $key => $payment) {

            $priceValidation = Validation::checkPrice($payment, Constants::ERROR_PAYMENTS_MADE);
            if (!$priceValidation['isCorrect']) {
                $groupedData = ['error' => $priceValidation['errorMessage']];
                break;
            }

            $id = $this->idsColumn[$key];

            $groupedData[$id] = !isset($groupedData[$id])
                ? round((float)$payment, 2)
                : $groupedData[$id] + round((float)$payment, 2);

        }

        return $groupedData;
    }

    private function filterColumnsByIdAndPayment()
    {
        if (!empty($this->paymentsMadeTable)) {
            $this->idsColumn = Helper::getColumnData(Constants::PAYMENTS_MADE_TABLE_CELL_ID, $this->paymentsMadeTable);
            $this->paymentsColumn = Helper::getColumnData(Constants::PAYMENTS_MADE_TABLE_CELL_PAYMENTS, $this->paymentsMadeTable);
        }
    }

}
