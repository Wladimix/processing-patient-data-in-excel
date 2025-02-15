<?php

class HTML
{

    public static function buildTotalInvoicesTable($totalInvoices)
    {
        $table = '<table class="table table-striped mt-4">';

        foreach ($totalInvoices as $row) {
            $table .= '<tr>';
                foreach($row as $column) {
                    $table .= "<td>{$column}</td>";
                }
            $table .= '</tr>';

        }

        return $table .= '</table>';
    }

    public static function buildTotalPaymentsTable($totalPayments)
    {
        $table = '<table class="table table-striped mt-4">';

        foreach ($totalPayments as $row) {
            $table .= '<tr>';
                foreach($row as $column) {
                    $table .= "<td>{$column}</td>";
                }
            $table .= '</tr>';

        }

        return $table .= '</table>';
    }

}
