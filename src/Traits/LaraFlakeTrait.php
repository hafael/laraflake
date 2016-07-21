<?php

namespace Hafael\LaraFlake\Traits;



use Hafael\LaraFlake\LaraFlake;

trait LaraFlakeTrait
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function($model){

            $model->{$model->getKeyName()} = LaraFlake::generateID();

        });
    }
}