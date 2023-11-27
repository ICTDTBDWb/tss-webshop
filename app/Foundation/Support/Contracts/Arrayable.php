<?php

namespace App\Foundation\Support\Contracts;

interface Arrayable
{
    /**
     * Convert the implementing class to array.
     *
     * @return array
     */
    public function toArray(): array;
}