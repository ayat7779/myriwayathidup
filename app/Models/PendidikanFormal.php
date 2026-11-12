<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PendidikanFormal extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function degree(): BelongsTo
    {
        return $this->belongsTo(PendidikanDegree::class, 'pendidikan_degree_id');
    }
}
