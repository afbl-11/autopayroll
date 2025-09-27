<?php

namespace App\Repositories;

use App\Models\Contracts;

class ContractsRepository
{
    public function all() {
        return Contracts::all();
    }

    public function getById($id) {
        return Contracts::find($id);
    }
}
