<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GenerateId
{
    public function generateId(string $modelClass, string $idColumn): string
    {
        $year = Carbon::now()->year;

        return DB::transaction(function () use ($modelClass, $idColumn, $year) {
            do {
                $randomNumber = str_pad(random_int(1, 9999), 4, '0', STR_PAD_LEFT);
                $newId = $year . $randomNumber;
                // Keep looping if this ID already exists
            } while ($modelClass::where($idColumn, $newId)->exists());

            return $newId;
        });
    }

}
