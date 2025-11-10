<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreferensiPertanyaan extends Model
{
    use HasFactory;

    protected $primaryKey = 'preferensi_id';

    protected $fillable = [
        'murid_id',
        'pertanyaan',
        'jawaban',
    ];

    public function murid()
    {
        return $this->belongsTo(Murid::class, 'murid_id', 'murid_id');
    }

    public function verifyAnswers($answer)
    {
        return strtolower(trim($answer)) === strtolower(trim($this->jawaban));
    }
}
