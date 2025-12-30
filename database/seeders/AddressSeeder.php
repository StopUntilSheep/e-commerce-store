<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'shopper')->get();
        $cities = [
            ['city' => 'London', 'county' => 'Greater London', 'postcode' => 'SW1A 1AA', 'country' => 'United Kingdom'],
            ['city' => 'Manchester', 'county' => 'Greater Manchester', 'postcode' => 'M1 1AB', 'country' => 'United Kingdom'],
            ['city' => 'Birmingham', 'county' => 'West Midlands', 'postcode' => 'B1 1AA', 'country' => 'United Kingdom'],
            ['city' => 'Glasgow', 'county' => 'Lanarkshire', 'postcode' => 'G1 1AA', 'country' => 'United Kingdom'],
            ['city' => 'Liverpool', 'county' => 'Merseyside', 'postcode' => 'L1 1AA', 'country' => 'United Kingdom'],
        ];

        foreach ($users as $user) {
            // Each user gets 1-3 addresses
            $addressCount = rand(1, 3);
            $cityData = $cities[array_rand($cities)];
            
            for ($i = 1; $i <= $addressCount; $i++) {
                $isDefault = $i === 1;
                $type = $i === 1 ? 'both' : ($i === 2 ? 'shipping' : 'billing');
                
                Address::create([
                    'user_id' => $user->id,
                    'type' => $type,
                    'first_name' => explode(' ', $user->name)[0],
                    'last_name' => explode(' ', $user->name)[1] ?? 'Smith',
                    'company' => rand(0, 1) ? $user->name . "'s Company" : null,
                    'address_line_1' => rand(1, 999) . ' Main Street',
                    'address_line_2' => rand(0, 1) ? 'Apt ' . rand(1, 99) : null,
                    'city' => $cityData['city'],
                    'county' => $cityData['county'],
                    'postcode' => $cityData['postcode'],
                    'country' => $cityData['country'],
                    'phone' => $user->phone,
                    'is_default' => $isDefault,
                ]);
            }
        }
    }
}