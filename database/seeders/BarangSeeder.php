<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barang;

class BarangSeeder extends Seeder
{
    protected $model = Barang::class;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Barang::factory()->times(100)->create();
    }
}
