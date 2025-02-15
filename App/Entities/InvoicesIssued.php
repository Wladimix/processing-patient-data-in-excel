<?php

class InvoicesIssued
{

    private $invoicesIssuedTable = [];

    private $idsColumn = [];
    private $finalePricesColumn = [];

    public function __construct()
    {
        if (file_exists(Files::getDocumentsPath() . Constants::INVOICES_ISSUED_FILE_NAME)) {
            $this->invoicesIssuedTable = Excel::readFile(Files::getDocumentsPath() . Constants::INVOICES_ISSUED_FILE_NAME);
        }
    }

    public function getGroupedIdsAndFinalePrices()
    {
        $this->filterColumnsByIdAndFinalePrices();

        $groupedData = [];

        foreach($this->finalePricesColumn as $key => $finalePrice) {

            $id = $this->idsColumn[$key];

            $groupedData[$id] = !isset($groupedData[$id])
                ? round((float)$finalePrice, 2)
                : $groupedData[$id] + round((float)$finalePrice, 2);

        }

        return $groupedData;
    }

    private function filterColumnsByIdAndFinalePrices()
    {
        $this->idsColumn = Helper::getColumnData(Constants::INVOICES_ISSUED_TABLE_CELL_ID, $this->invoicesIssuedTable);
        $this->finalePricesColumn = Helper::getColumnData(Constants::INVOICES_ISSUED_TABLE_CELL_FINAL_PRICE, $this->invoicesIssuedTable);
    }

}
