<?php

namespace App\Repository;

use App\Models\Barang;
use Illuminate\Support\Collection;

interface BarangRepositotyInterface {
    public function all(): Collection;
}