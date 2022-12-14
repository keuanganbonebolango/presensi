<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    protected $guarded = [];

    /**
     * Get all of the presensidetail for the Presensi
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function presensidetail()
    {
        return $this->hasMany(PresensiDetail::class);
    }
    /**
     * Get the user that owns the Presensi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
