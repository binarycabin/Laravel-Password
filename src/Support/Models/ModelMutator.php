<?php

namespace BinaryCabin\LaravelPassword\Support\Models;

use BinaryCabin\LaravelPassword\Support\Passwords\PasswordGenerator;
use Hash;

class ModelMutator{

    private $model;

    public function __construct($model) {
        $this->setModel($model);
    }

    public function setModel($model){
        $this->model = $model;
    }

    public function getModel(){
        return $this->model;
    }

    public function setPasswordIfEmpty($fieldName){
        if(empty($this->model->$fieldName)){
            $this->model->$fieldName = PasswordGenerator::generate();
        }
        return $this;
    }

    public function hashPassword($fieldName){
        $password = $this->model->$fieldName;
        $this->model->$fieldName = Hash::make($password);
        return $this;
    }

}