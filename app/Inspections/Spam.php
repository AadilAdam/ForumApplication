<?php
namespace App\Inspections;

class Spam
{

    /**
     * Don't auto-apply mass assignment protection.
     *
     * @var array
     */
    protected $guarded = [];

    protected $inspections = [

        InvalidKeywords::class,

        KeyHeldDown::class
    ];

    public function detect($body)
    {

        foreach($this->inspections as $inspection)
        {
            app($inspection)->detect($body);
        }

        return false;
        
    }

}