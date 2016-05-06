<?php

namespace App\Services;

interface iService
{
    public static function create();
    public function save();
    public function update();
    public function remove();
    public function addItem($object);
    public function setItem($id);
    public function putValues($data);
    public function rules();
    public function messages();
    public function prepareProperties();
    public function validation();
}