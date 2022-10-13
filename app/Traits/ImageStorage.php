<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Upload Image for Profile
 * And Attendance
 */
trait ImageStorage
{
    /**
     * For Upload gambar_profil
     * @param mixed $gambar_profil
     * @param mixed $name
     * @param mixed $path
     * @param bool $update
     * @param mixed|null $old_gambar_profil
     * @return void
     */
    public function uploadImage($gambar_profil, $name, $path, $update = false, $old_gambar_profil = null)
    {
        if ($update) {
            Storage::delete("/public/{$path}/" . $old_gambar_profil);
        }

        $name = Str::slug($name) . '-' . time();
        $extension = $gambar_profil->getClientOriginalExtension();
        $newName = $name . '.' . $extension;
        Storage::putFileAs("/public/{$path}", $gambar_profil, $newName);
        return $newName;
    }

    /**
     *
     * @param mixed $old_gambar_profil
     * @param mixed $path
     * @return void
     */
    public function deleteImage($old_gambar_profil, $path)
    {
        Storage::delete("/public/{$path}" . $old_gambar_profil);
    }
}
