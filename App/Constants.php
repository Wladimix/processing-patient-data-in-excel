<?php

class Constants
{
    const INVOICES_ISSUED = 'Выставленные счета';
    const INVOICES_ISSUED_KEY = 'invoices_issued';
    const INVOICES_ISSUED_FILE_NAME = 'Выставленные счета.xlsx';
    const INVOICES_ISSUED_TABLE_CELL_ID = 'ИД';
    const INVOICES_ISSUED_TABLE_CELL_FINAL_PRICE = 'Цена услуги итоговая';

    const PATIENTS = 'Пациенты';
    const PATIENTS_KEY = 'patients';
    const PATIENTS_FILE_NAME = 'Пациенты.xlsx';
    const PATIENTS_TABLE_CELL_ID = 'ID';
    const PATIENTS_TABLE_CELL_SURNAME = 'Фамилия';
    const PATIENTS_TABLE_CELL_NAME = 'Имя';
    const PATIENTS_TABLE_CELL_PATRONYMIC = 'Отчество';
    const PATIENTS_TABLE_CELL_PHONE = 'Телефон';

    const PAYMENTS_MADE = 'Совершённые платежи';
    const PAYMENTS_MADE_KEY = 'payments_made';
    const PAYMENTS_MADE_FILE_NAME = 'Совершённые платежи.xlsx';
    const PAYMENTS_MADE_TABLE_CELL_ID = 'ИД';
    const PAYMENTS_MADE_TABLE_CELL_PAYMENTS = 'Платежи';

    const ERROR_INVOICES_ISSUED = 'в таблице со счетами в столбце итоговых цен присутствуют некорректные данные';
    const ERROR_PAYMENTS_MADE = 'в таблице с совершёнными платежами в столбце платежей присутствуют некорректные данные';
    const ERROR_PHONE_NUMBER = 'некорректный номер телефона';
}
