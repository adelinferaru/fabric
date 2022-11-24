<?php

namespace App\Fabric\Interfaces;

interface MovieSearch
{
    public function search(string $searchString):array;
}
