<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'shopper')->get();
        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        $paymentMethods = ['stripe', 'paypal', 'bank_transfer'];
        $paymentStatuses = ['pending', 'paid', 'failed'];

        foreach ($users as $user) {
            // Each user gets 0-5 orders
            $orderCount = rand(0, 5);
            
            for ($i = 1; $i <= $orderCount; $i++) {
                $status = $statuses[array_rand($statuses)];
                $subtotal = rand(5000, 50000) / 100; // £50-£500
                $shipping = rand(0, 1) ? 4.99 : 9.99;
                $tax = $subtotal * 0.2; // 20% VAT
                $total = $subtotal + $shipping + $tax;
                
                $address = $user->addresses()->first();
                $shippingAddress = $address ? [
                    'first_name' => $address->first_name,
                    'last_name' => $address->last_name,
                    'company' => $address->company,
                    'address_line_1' => $address->address_line_1,
                    'address_line_2' => $address->address_line_2,
                    'city' => $address->city,
                    'county' => $address->county,
                    'postcode' => $address->postcode,
                    'country' => $address->country,
                    'country_code' => $address->country_code,
                    'phone' => $address->phone,
                ] : null;

                Order::create([
                    'user_id' => $user->id,
                    'order_number' => 'ORD-' . date('Y') . '-' . str_pad(Order::count() + 1, 6, '0', STR_PAD_LEFT),
                    'status' => $status,
                    'subtotal' => $subtotal,
                    'tax_amount' => $tax,
                    'shipping_amount' => $shipping,
                    'total' => $total,
                    'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                    'payment_status' => $paymentStatuses[array_rand($paymentStatuses)],
                    'shipping_address' => $shippingAddress,
                    'billing_address' => $shippingAddress, // Same as shipping for simplicity
                    'notes' => rand(0, 1) ? 'Please leave with neighbor if not home.' : null,
                    'admin_notes' => $status === 'cancelled' ? 'Customer requested cancellation' : null,
                    'metadata' => [
                        'source' => 'website',
                        'ip_address' => '192.168.1.' . rand(1, 255),
                    ],
                ]);
            }
        }
    }
}