<?php

namespace Database\Seeders;

use App\Models\Metadata;
use Illuminate\Database\Seeder;

class MetadatasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $metadatas = [
            [
                'type'   => 'in_used',
                'label' => 'Used',
                'value' => 'used',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type'   => 'in_used',
                'label' => 'Not used',
                'value' => 'not_used',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type'   => 'in_used',
                'label' => 'Disabled',
                'value' => 'disabled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type'   => 'expired',
                'label' => 'Expired',
                'value' => 'expired',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type'   => 'expired',
                'label' => 'Not expired',
                'value' => 'not_expired',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type'   => 'credit_package',
                'label' => 'Monthly points',
                'value' => 'm',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type'   => 'credit_package',
                'label' => 'Annual points',
                'value' => 'a',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type'   => 'status',
                'label' => 'Active',
                'value' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type'   => 'status',
                'label' => 'Inactive',
                'value' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type'   => 'status_credit',
                'label' => 'Recharge',
                'value' => 'recharge',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type'   => 'status_credit',
                'label' => 'Deduction',
                'value' => 'dediction',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Metadata::insert($metadatas);
    }
}
