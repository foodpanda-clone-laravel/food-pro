<?php



namespace App\DTO;



class BaseDTO

{

    public function toArray()

    {

        return (array) $this;

    }
}