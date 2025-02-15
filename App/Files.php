<?php

class Files
{

    public static function uploadFiles()
    {

        if($_FILES)
        {
            foreach ($_FILES['uploads']['error'] as $key => $error) {
                if (!file_exists(self::getDocumentsPath())) {
                    mkdir(self::getDocumentsPath(), 0777, true);
                }

                if ($error == UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES['uploads']['tmp_name'][$key];
                    $name = self::makeFileName($key);
                    move_uploaded_file($tmp_name, $name);
                }
            }
        }

    }

    private static function makeFileName($key) {
        switch($key) {

            case Constants::INVOICES_ISSUED_KEY:
                return self::getDocumentsPath() . Constants::INVOICES_ISSUED_FILE_NAME;

            case Constants::PATIENTS_KEY:
                return self::getDocumentsPath() . Constants::PATIENTS_FILE_NAME;

            case Constants::PAYMENTS_MADE_KEY:
                return self::getDocumentsPath() . Constants::PAYMENTS_MADE_FILE_NAME;

        }
    }

    public static function getDocumentsPath()
    {
        return $_SERVER['DOCUMENT_ROOT'] . '/documents/';
    }

}
