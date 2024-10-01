<?php

namespace App\Library;

class Customer {
    
    public static function getTpfBasedCategory($tpf_number)
    {
        $tpf_number = substr($tpf_number, 0, 1);
        switch ($tpf_number) {
            case '1':
                $category = '2';
                break;

            case '2':
                $category = '3';
                break;

            case '3':
                $category = '4';
                break;

            case '6':
                $category = '5';
                break;
            
            case '7':
                $category = '1';
                break;
            
            default:
                $category = NULL;
                break;
        }

        return $category;
    }
}
