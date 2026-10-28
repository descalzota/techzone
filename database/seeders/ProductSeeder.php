<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['Acer Aspire 5 Laptop', 'Laptop', 34995.00, 12, 'Acer Philippines', 'Available', '15.6" FHD, Core i5, 8GB RAM, 512GB SSD'],
            ['ASUS VivoBook 15', 'Laptop', 29995.00, 4, 'ASUS Philippines', 'Low Stock', '15.6" FHD, Ryzen 5, 8GB RAM, 512GB SSD'],
            ['Kingston Fury 16GB DDR4', 'RAM', 2450.00, 30, 'Kingston Technology', 'Available', '3200MHz desktop memory'],
            ['Crucial MX500 500GB SSD', 'Storage', 3200.00, 25, 'Crucial', 'Available', '2.5" SATA solid state drive'],
            ['Samsung 980 1TB NVMe', 'Storage', 5400.00, 3, 'Samsung Electronics', 'Low Stock', 'M.2 NVMe PCIe 3.0 SSD'],
        ];

        foreach ($products as $p) {
            Product::create([
                'name' => $p[0],
                'category' => $p[1],
                'price' => $p[2],
                'quantity' => $p[3],
                'supplier' => $p[4],
                'status' => $p[5],
                'description' => $p[6],
            ]);
        }

        Product::factory()->count(10)->create();
    }
}
