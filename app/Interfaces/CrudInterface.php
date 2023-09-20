<?php

namespace App\Interfaces;

interface CrudInterface {
    public function getFormDesign():object;
    public function getRequestValidator():array;
}