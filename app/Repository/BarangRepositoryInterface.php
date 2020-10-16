<?php

namespace App\Repository;

use App\Models\Barang;
use Illuminate\Support\Collection;

interface BarangRepositoryInterface {
    public function all(): Collection;
}