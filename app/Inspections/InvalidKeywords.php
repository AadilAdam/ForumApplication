<?php

namespace App\Inspections;

use Exception;


class InvalidKeywords
{

    protected $keywords = [
        'some invalid spam words.'
    ];


    public function detect($body)
    {

        foreach($this->keywords as  $keyword)
        {
            if(stripos($body, $keyword) !== false) 
            {
                throw new Exception('You hav a spam mssage');
            }
        }
    }
}