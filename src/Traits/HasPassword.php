<?php

namespace BinaryCabin\LaravelPassword\Traits;

use BinaryCabin\LaravelPassword\Support\Models\ModelMutator;

trait HasPassword{

    public static function bootHasPassword(){
        static::creating(function($model) {
            $passwordFieldName = $model->getPasswordFieldName();
            $modelMutator = new ModelMutator($model);
            $model = $modelMutator->setPasswordIfEmpty($passwordFieldName)->getModel();
            $model = $modelMutator->hashPassword($passwordFieldName)->getModel();
        });
        static::updating(function($model) {
            $passwordFieldName = $model->getPasswordFieldName();
            $modelMutator = new ModelMutator($model);
            if(!empty($model->$passwordFieldName)){
                $model = $modelMutator->hashPassword($passwordFieldName)->getModel();
            }
        });
    }

    public function getPasswordFieldName(){
        if(!empty($this->passwordFieldName)){
            return $this->passwordFieldName;
        }
        return 'password';
    }

}