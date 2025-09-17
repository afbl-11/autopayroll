<?php

namespace App\Services;

use Carbon\Carbon;

class GenerateId
{
    public function generateId(string $modelClass, string $idColumn): string
    {
        $year = Carbon::now()->year;

        $lastRecord = $modelClass::where($idColumn, 'like', "$year%")
            ->orderBy($idColumn, 'desc')
            ->first();

        $newNumber = $lastRecord ? (int)substr($lastRecord->$idColumn, 5) + 1 : 1;

        return $year . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}
