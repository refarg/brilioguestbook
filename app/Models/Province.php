<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    public $table = "province";
    public $primaryKey = "code";
    public $timestamps = false;

    protected $fillable = [
        'code',
        'name',
    ];
}