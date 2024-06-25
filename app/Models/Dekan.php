<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dekan extends Model
{
    protected $table = 'dekan';

    protected $fillable = [
        'fakultas_id',
        'status',
        'user_id'
    ];
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function fakultas()
    {
        return $this->belongsTo(KategoriFakultas::class);
    }
}
