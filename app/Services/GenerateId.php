<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GenerateId
{
    public function generateId(string $modelClass, string $idColumn): string
    {
        $year = Carbon::now()->year;

        $newId = \DB::transaction(function() use ($modelClass, $idColumn, $year) {
            $lastRecord = $modelClass::where($idColumn, 'like', "$year%")
                ->orderBy($idColumn, 'desc')
                ->lockForUpdate()
                ->first();

            $newNumber = $lastRecord ? (int)substr($lastRecord->$idColumn, 4) + 1 : 1;

            return $year . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
        });

        return $newId;
    }

}
