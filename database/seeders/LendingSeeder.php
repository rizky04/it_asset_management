<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LendingSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('lendings')->insert([
            [
                'asset_id' => 128,
                'borrower' => 'm lounge',
                'department' => 'GA',
                'lend_date' => '2026-03-11',
                'due_date' => '2026-03-27',
                'return_date' => null,
                'notes' => 'ACARA',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'asset_id' => 127,
                'borrower' => 'bu yetti',
                'department' => 'CM TP',
                'lend_date' => '2026-03-11',
                'due_date' => '2026-03-13',
                'return_date' => null,
                'notes' => 'presentasi di tp',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'asset_id' => 174,
                'borrower' => 'AFFRIZAL',
                'department' => 'IT',
                'lend_date' => '2026-03-12',
                'due_date' => '2026-03-31',
                'return_date' => null,
                'notes' => 'SERVER AI',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'asset_id' => 171,
                'borrower' => 'AFFRIZAL',
                'department' => 'IT',
                'lend_date' => '2026-03-12',
                'due_date' => '2026-03-31',
                'return_date' => null,
                'notes' => 'OPERASIONAL',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'asset_id' => 175,
                'borrower' => 'Toufan',
                'department' => 'MA',
                'lend_date' => '2026-03-26',
                'due_date' => '2026-03-31',
                'return_date' => null,
                'notes' => 'buat zoom meet',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'asset_id' => 176,
                'borrower' => 'Toufan',
                'department' => 'MA',
                'lend_date' => '2026-03-26',
                'due_date' => '2026-03-31',
                'return_date' => null,
                'notes' => 'keperluan zoom meet',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
