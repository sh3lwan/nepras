<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['name', 'contract_id', 'address', 'birth_date', 'identity'];
}
