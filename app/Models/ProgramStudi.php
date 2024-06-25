<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramStudi extends Model
{
    protected $table = 'program_studi';

    protected $fillable = [
        'program_studi_id',
        'user_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function program_studi()
    {
        return $this->belongsTo(KategoriJurusan::class);
    }
    use HasFactory;
}
