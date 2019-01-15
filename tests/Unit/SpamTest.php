<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Inspections\Spam;


class SpamTest extends TestCase
{
    /** @test */
    public function test_checks_for_invalid_keywords()
    {
        $spam = new Spam();

        $this->assertFalse($spam->detect('Innocent reply here'));
        
        $this->expectException('Exception');
        
        $spam->detect('some invalid spam words.');
    }
     /** @test */
    function test_checks_for_any_key_being_held_down()
    {
        $spam = new Spam();
        
        $this->expectException('Exception');
        
        $spam->detect('Hello world aaaaaaaaa');
     }

    
}