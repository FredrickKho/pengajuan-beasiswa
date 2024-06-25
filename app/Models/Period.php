<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    protected $table = 'period';

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
    ];
    public function beasiswa(){
        return $this->hasMany(Beasiswa::class);
    }
    use HasFactory;
}
