<?php

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Excel
{

    public static function readFile($filePath, $sheetIndex = 0) {
        $testAgainstFormats = [
            IOFactory::READER_XLS,
            IOFactory::READER_XLSX,
        ];

        $spreadsheet = IOFactory::load($filePath, $sheetIndex, $testAgainstFormats);
        $sheet = $spreadsheet->getActiveSheet();
        $data = [];

        foreach ($sheet->getRowIterator() as $row) {
            $rowData = [];
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(true);

            foreach ($cellIterator as $cell) {
                $rowData[] = $cell->getValue();
            }

            $rowData = array_filter($rowData, function($elem) {
                if (isset($elem)) {
                    return true;
                } else {
                    return false;
                }
            });

            if (!empty($rowData)) {
                $data[] = $rowData;
            }
        }

        return $data;
    }

    public static function generateAndGetTotalInvoices($finalePrices, $FCs)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(50);
        $sheet->getStyle('A1:C1')->applyFromArray([
            'font' => [
                'bold' => true,
            ]
        ]);

        $dataForExcel = [
            ['Сумма счетов', 'ФИО'],
        ];

        foreach ($finalePrices as $key => $finalePrice) {
            if (isset($FCs[$key])) {
                $dataForExcel[] = [$finalePrice, $FCs[$key]];
            }
        }

        foreach ($dataForExcel as $rowIndex => $rowData) {

            foreach ($rowData as $colIndex => $cellValue) {

                $columnLetter = Coordinate::stringFromColumnIndex($colIndex + 1);
                $sheet->setCellValue($columnLetter . ($rowIndex + 1), $cellValue);

            }

        }

        $writer = new Xlsx($spreadsheet);
        $writer->save(Files::getDocumentsPath() . 'Сумма всех счетов пациентов.xlsx');

        return $dataForExcel;
    }

    public static function generateAndGetPayments($FCs, $phones, $payments)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getColumnDimension('A')->setWidth(40);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getStyle('A1:C1')->applyFromArray([
            'font' => [
                'bold' => true,
            ]
        ]);

        $dataForExcel = [
            ['ФИО', 'Телефон', 'Совершенные платежи'],
        ];

        foreach ($FCs as $key => $FC) {
            if (isset($phones[$key]) && isset($payments[$key])) {
                $dataForExcel[] = [$FC, $phones[$key], $payments[$key]];
            }
        }

        foreach ($dataForExcel as $rowIndex => $rowData) {

            foreach ($rowData as $colIndex => $cellValue) {

                $columnLetter = Coordinate::stringFromColumnIndex($colIndex + 1);
                $sheet->setCellValue($columnLetter . ($rowIndex + 1), $cellValue);

            }

        }

        $writer = new Xlsx($spreadsheet);
        $writer->save(Files::getDocumentsPath() . 'Сумма совершённых платежей пациентов.xlsx');

        return $dataForExcel;
    }

}
