<?php
<<<<<<< HEAD
// FILE PATH: database/seeders/DatabaseSeeder.php
=======
>>>>>>> 65b51754ff66c222a1d9fdc027683d09d9afc9cc

namespace Database\Seeders;

use App\Models\User;
<<<<<<< HEAD
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Users ─────────────────────────────────────────────
        User::truncate();

        User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@inventory.com',
            'role'     => 'admin',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name'     => 'Jose Reyes',
            'email'    => 'manager@inventory.com',
            'role'     => 'manager',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name'     => 'Maria Santos',
            'email'    => 'staff@inventory.com',
            'role'     => 'staff',
            'password' => Hash::make('password'),
        ]);

        // ── Categories ────────────────────────────────────────
        Category::truncate();
        foreach ([
            ['name' => 'Electronics',    'description' => 'Electronic devices and components'],
            ['name' => 'Office Supplies', 'description' => 'Stationery and office materials'],
            ['name' => 'Furniture',       'description' => 'Office and warehouse furniture'],
            ['name' => 'Raw Materials',   'description' => 'Production raw materials'],
        ] as $cat) Category::create($cat);

        // ── Suppliers ─────────────────────────────────────────
        Supplier::truncate();
        foreach ([
            ['name' => 'TechWorld Inc.',  'email' => 'orders@techworld.com', 'phone' => '+63-912-000-0101', 'address' => '123 Tech Ave, Makati City'],
            ['name' => 'Office Pro Ltd.', 'email' => 'supply@officepro.com', 'phone' => '+63-917-000-0202', 'address' => '456 Business Blvd, BGC, Taguig'],
            ['name' => 'FurniCo Global',  'email' => 'info@furnico.com',     'phone' => '+63-920-000-0303', 'address' => '789 Industrial Rd, Caloocan'],
        ] as $sup) Supplier::create($sup);

        // ── Products ──────────────────────────────────────────
        Product::truncate();
        foreach ([
            ['name' => 'Laptop Pro 15"',     'sku' => 'ELEC-001', 'category_id' => 1, 'supplier_id' => 1, 'price' => 54999.00, 'quantity' => 45,  'reorder_level' => 10,  'unit' => 'pcs'],
            ['name' => 'Wireless Mouse',     'sku' => 'ELEC-002', 'category_id' => 1, 'supplier_id' => 1, 'price' => 1299.00,  'quantity' => 120, 'reorder_level' => 20,  'unit' => 'pcs'],
            ['name' => 'USB-C Hub 7-Port',   'sku' => 'ELEC-003', 'category_id' => 1, 'supplier_id' => 1, 'price' => 2499.00,  'quantity' => 8,   'reorder_level' => 15,  'unit' => 'pcs'],
            ['name' => 'Mechanical Keyboard','sku' => 'ELEC-004', 'category_id' => 1, 'supplier_id' => 1, 'price' => 3899.00,  'quantity' => 30,  'reorder_level' => 10,  'unit' => 'pcs'],
            ['name' => 'A4 Bond Paper Ream', 'sku' => 'OFFC-001', 'category_id' => 2, 'supplier_id' => 2, 'price' => 285.00,   'quantity' => 500, 'reorder_level' => 100, 'unit' => 'ream'],
            ['name' => 'Ballpen Box (Black)','sku' => 'OFFC-002', 'category_id' => 2, 'supplier_id' => 2, 'price' => 95.00,    'quantity' => 200, 'reorder_level' => 50,  'unit' => 'box'],
            ['name' => 'Stapler Heavy Duty', 'sku' => 'OFFC-003', 'category_id' => 2, 'supplier_id' => 2, 'price' => 450.00,   'quantity' => 4,   'reorder_level' => 10,  'unit' => 'pcs'],
            ['name' => 'Executive Desk',     'sku' => 'FURN-001', 'category_id' => 3, 'supplier_id' => 3, 'price' => 18500.00, 'quantity' => 12,  'reorder_level' => 3,   'unit' => 'pcs'],
            ['name' => 'Ergonomic Chair',    'sku' => 'FURN-002', 'category_id' => 3, 'supplier_id' => 3, 'price' => 12999.00, 'quantity' => 5,   'reorder_level' => 5,   'unit' => 'pcs'],
            ['name' => 'Steel Shelving Unit','sku' => 'FURN-003', 'category_id' => 3, 'supplier_id' => 3, 'price' => 7500.00,  'quantity' => 20,  'reorder_level' => 5,   'unit' => 'pcs'],
            ['name' => 'Cement Bag 40kg',    'sku' => 'RAW-001',  'category_id' => 4, 'supplier_id' => 3, 'price' => 285.00,   'quantity' => 0,   'reorder_level' => 50,  'unit' => 'bag'],
            ['name' => 'Steel Rod 10mm',     'sku' => 'RAW-002',  'category_id' => 4, 'supplier_id' => 3, 'price' => 180.00,   'quantity' => 3,   'reorder_level' => 30,  'unit' => 'pcs'],
        ] as $prod) {
            Product::create(array_merge($prod, ['description' => 'Quality inventory product.', 'status' => 'active']));
        }
    }
}
=======
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
>>>>>>> 65b51754ff66c222a1d9fdc027683d09d9afc9cc
