<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vehicle;

class VehicleSeeder extends Seeder
{
    public function run(): void
    {
        // Misalnya user_id = 1 untuk sementara
        Vehicle::create([
            'user_id' => 1,
            'license_plate' => 'BA234ABC',
            'type' => 'Motor',
            'brand' => 'Yamaha',
            'color' => 'Merah',
            'is_stolen' => false,
        ]);
    }
}