<?php

class Patients
{

    private $patientsTable = [];

    private $idsColumn = [];
    private $surnamesColumn = [];
    private $namesColumn = [];
    private $patronymicsColumn = [];
    private $phonesColumn = [];

    public function __construct()
    {
        if (file_exists(Files::getDocumentsPath() . Constants::PATIENTS_FILE_NAME)) {
            $this->patientsTable = Excel::readFile(Files::getDocumentsPath() . Constants::PATIENTS_FILE_NAME);
        }
    }

    public function getGroupedIdsAndFCs()
    {
        $this->filterColumnsByIdAndFC();

        $groupedData = [];

        foreach($this->idsColumn as $key => $id) {
            $groupedData[$id] = "{$this->surnamesColumn[$key]} {$this->namesColumn[$key]} {$this->patronymicsColumn[$key]}";
        }

        return $groupedData;
    }

    public function getGroupedIdsAndPhones()
    {
        $this->filterColumnsByIdAndPhone();

        $groupedData = [];

        foreach($this->idsColumn as $key => $id) {
            $groupedData[$id] = $this->phonesColumn[$key];
        }

        return $groupedData;
    }

    private function filterColumnsByIdAndFC()
    {
        if (!empty($this->patientsTable)) {
            $this->idsColumn = Helper::getColumnData(Constants::PATIENTS_TABLE_CELL_ID, $this->patientsTable);
            $this->surnamesColumn = Helper::getColumnData(Constants::PATIENTS_TABLE_CELL_SURNAME, $this->patientsTable);
            $this->namesColumn = Helper::getColumnData(Constants::PATIENTS_TABLE_CELL_NAME, $this->patientsTable);
            $this->patronymicsColumn = Helper::getColumnData(Constants::PATIENTS_TABLE_CELL_PATRONYMIC, $this->patientsTable);
        }
    }

    private function filterColumnsByIdAndPhone()
    {
        if (!empty($this->patientsTable)) {
            $this->idsColumn = Helper::getColumnData(Constants::PATIENTS_TABLE_CELL_ID, $this->patientsTable);
            $this->phonesColumn = Helper::getColumnData(Constants::PATIENTS_TABLE_CELL_PHONE, $this->patientsTable);
        }
    }

}
