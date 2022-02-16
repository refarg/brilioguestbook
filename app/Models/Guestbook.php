<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guestbook extends Model
{
    use HasFactory;

    public $table = "guestbook";

    protected $fillable = [
        'first_name',
        'last_name',
        'organization',
        'address',
        'province_code',
        'city_code',
        'message',
    ];

    public function province()
    {
        return $this->hasOne('App\Models\Province', 'code', 'province_code');
    }

    public function city()
    {
        return $this->hasOne('App\Models\City', 'code', 'city_code');
    }
}
