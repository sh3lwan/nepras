<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = ['name', 'contract_id', 'address', 'birth_date', 'identity'];

    public function family()
    {

        return $this->hasMany('App\FamilyMember', 'employee_id', 'id');

    }


}
