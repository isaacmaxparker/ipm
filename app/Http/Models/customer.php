<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    protected $table = 'customers';
    protected $fillable = ['first_name', 'last_name', 'email','address_1','address_2','city','state','country','zip'];
}
