<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriFakultas extends Model
{
    protected $table = 'kategori_fakultas';

    protected $fillable = [
        'name'
    ];
    public function dekan()
    {
        return $this->hasMany(Dekan::class,'fakultas_id','id');
    }
    use HasFactory;
}
