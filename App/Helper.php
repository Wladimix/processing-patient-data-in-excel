<?php

class Helper
{

    public static function getColumnData($columnName, $table)
    {
        $columnData = [];
        $columnIndex = self::getColumnIndex($columnName, $table);

        foreach($table as $key => $row) {
            if ($key === 0) {
                continue;
            }

            if (isset($row[$columnIndex])) {
                $columnData[] = $row[$columnIndex];
            }
        }

        return $columnData;
    }

    private static function getColumnIndex($columnName, $table)
    {
        $tableHeaderData = $table[0];
        return array_search($columnName, $tableHeaderData);
    }

}
