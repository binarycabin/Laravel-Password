<?php

namespace BinaryCabin\LaravelPassword\Support\Passwords;

class PasswordGenerator{

    public static function generate($length=11){
        return str_random($length);
    }

}