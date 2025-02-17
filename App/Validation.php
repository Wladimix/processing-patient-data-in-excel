<?php

class Validation
{

    public static function checkPrice($price, $errorMessage)
    {
        return [
            'isCorrect' => preg_match('/^\d+(\.\d+)?$/', $price),
            'errorMessage' => $errorMessage
        ];
    }

    public static function checkPhone($phoneNumber)
    {
        return preg_match('/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/', $phoneNumber);
    }

}
