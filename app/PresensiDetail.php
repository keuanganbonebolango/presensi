<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PresensiDetail extends Model
{
    protected $guarded = [];

    /**
     * Get the Presensi that owns the PresensiDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function presensi()
    {
        return $this->belongsTo(Presensi::class);
    }
}
