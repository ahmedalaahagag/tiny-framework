<?php

namespace App\Models;

/**
 * Class User
 * @package App\Models
 */
class User extends Model
{
    public $table = 'users';
    private $builder;

    public function create($parameters)
    {
        $this->builder->insert($parameters);
    }
}
