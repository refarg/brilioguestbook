<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    public $table = "city";
    public $primaryKey = "code";
    public $timestamps = false;

    protected $fillable = [
        'code',
        'name',
        'province_code',
    ];
}
