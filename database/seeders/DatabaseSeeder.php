<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\GroupBuyMember;
use App\Models\GroupBuySession;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Users
        $admin = User::updateOrCreate(
            ['email' => 'admin@cartiva.com'],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '+880 1711 000001',
                'address' => 'Gulshan 2, Dhaka, Bangladesh',
            ]
        );

        $seller = User::updateOrCreate(
            ['email' => 'seller@cartiva.com'],
            [
                'name' => 'Apex Tech & Lifestyle Store',
                'password' => Hash::make('password123'),
                'role' => 'seller',
                'phone' => '+880 1811 000002',
                'address' => 'Banani Commercial Area, Dhaka',
            ]
        );

        $customer1 = User::updateOrCreate(
            ['email' => 'customer@cartiva.com'],
            [
                'name' => 'Arif Rahman',
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'phone' => '+880 1911 000003',
                'address' => 'Dhanmondi 27, Dhaka',
            ]
        );

        $customer2 = User::updateOrCreate(
            ['email' => 'tahmid@cartiva.com'],
            [
                'name' => 'Tahmid Hasan',
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'phone' => '+880 1611 000004',
                'address' => 'Uttara Sector 7, Dhaka',
            ]
        );

        $customer3 = User::updateOrCreate(
            ['email' => 'farhana@cartiva.com'],
            [
                'name' => 'Farhana Kabir',
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'phone' => '+880 1511 000005',
                'address' => 'Mirpur DOHS, Dhaka',
            ]
        );

        // 2. Categories
        $categoriesData = [
            [
                'name' => 'Smart Tech & Audio',
                'slug' => 'smart-tech-audio',
                'icon' => '🎧',
                'description' => 'Premium noise-cancelling headphones, wireless earbuds, and smart accessories',
            ],
            [
                'name' => 'Wearables & Watches',
                'slug' => 'wearables-watches',
                'icon' => '⌚',
                'description' => 'Next-gen fitness trackers, titanium smartwatches, and stylish bands',
            ],
            [
                'name' => 'Computing & Gaming',
                'slug' => 'computing-gaming',
                'icon' => '💻',
                'description' => 'Mechanical keyboards, ergonomic setups, and productivity gadgets',
            ],
            [
                'name' => 'Home & Living',
                'slug' => 'home-living',
                'icon' => '☕',
                'description' => 'Modern espresso machines, ambient desk lamps, and air purifiers',
            ],
            [
                'name' => 'Fashion & Bags',
                'slug' => 'fashion-bags',
                'icon' => '🎒',
                'description' => 'Waterproof commuter backpacks, minimalist wallets, and sunglasses',
            ],
        ];

        $categories = [];
        foreach ($categoriesData as $c) {
            $categories[$c['slug']] = Category::updateOrCreate(['slug' => $c['slug']], $c);
        }

        // 3. Products
        $productsData = [
            [
                'title' => 'Aura Pro Active Noise-Cancelling Wireless Headphones',
                'slug' => 'aura-pro-anc-headphones',
                'category_slug' => 'smart-tech-audio',
                'description' => 'Immerse yourself in concert-hall acoustics with adaptive ANC, 40mm beryllium drivers, and up to 45 hours of battery life with ultra-plush memory foam cushions.',
                'image_url' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800&q=80',
                'single_price' => 199.00,
                'group_price' => 129.00,
                'group_size_required' => 2,
                'group_duration_hours' => 24,
                'stock' => 45,
                'rating' => 4.9,
                'sales_count' => 142,
            ],
            [
                'title' => 'Horizon Ultra Titan Smartwatch with Sapphire Glass',
                'slug' => 'horizon-ultra-titan-smartwatch',
                'category_slug' => 'wearables-watches',
                'description' => 'Engineered for extreme performance with aerospace-grade titanium, dual-frequency GPS, 100m water resistance, ECG tracking, and 7-day battery life.',
                'image_url' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=800&q=80',
                'single_price' => 289.00,
                'group_price' => 189.00,
                'group_size_required' => 3,
                'group_duration_hours' => 48,
                'stock' => 30,
                'rating' => 4.85,
                'sales_count' => 88,
            ],
            [
                'title' => 'Keyforge K8 Pro Wireless Mechanical Keyboard (Gateron Red)',
                'slug' => 'keyforge-k8-pro-wireless-keyboard',
                'category_slug' => 'computing-gaming',
                'description' => 'Hot-swappable tactile mechanical keyboard featuring custom PBT double-shot keycaps, RGB backlighting, sound-absorbing silicone damping, and Bluetooth 5.2.',
                'image_url' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=800&q=80',
                'single_price' => 135.00,
                'group_price' => 89.00,
                'group_size_required' => 2,
                'group_duration_hours' => 24,
                'stock' => 60,
                'rating' => 4.95,
                'sales_count' => 210,
            ],
            [
                'title' => 'Barista Artisan Compact Espresso & Latte Machine 19-Bar',
                'slug' => 'barista-artisan-espresso-machine',
                'category_slug' => 'home-living',
                'description' => 'Cafe-grade high-pressure extraction with stainless steel thermoblock heating, micro-foam steam wand, and fast 25-second warm-up for rich morning crema.',
                'image_url' => 'https://images.unsplash.com/photo-1517668808822-9ebb02f2a0e6?w=800&q=80',
                'single_price' => 249.00,
                'group_price' => 159.00,
                'group_size_required' => 3,
                'group_duration_hours' => 36,
                'stock' => 25,
                'rating' => 4.78,
                'sales_count' => 74,
            ],
            [
                'title' => 'Nomad Explorer Waterproof Tech Backpack 28L',
                'slug' => 'nomad-explorer-waterproof-backpack',
                'category_slug' => 'fashion-bags',
                'description' => 'Cordura ballistic nylon with weatherproof YKK zippers, dedicated 16-inch padded laptop sleeve, quick-access passport pocket, and breathable ergonomic backpanel.',
                'image_url' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=800&q=80',
                'single_price' => 119.00,
                'group_price' => 75.00,
                'group_size_required' => 2,
                'group_duration_hours' => 24,
                'stock' => 50,
                'rating' => 4.9,
                'sales_count' => 190,
            ],
            [
                'title' => 'VibePulse Studio ANC True Wireless Earbuds',
                'slug' => 'vibepulse-studio-anc-earbuds',
                'category_slug' => 'smart-tech-audio',
                'description' => 'Spatial audio with dynamic head tracking, transparency mode, wireless Qi charging case, and IPX7 sweatproof design for workouts and daily commutes.',
                'image_url' => 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=800&q=80',
                'single_price' => 99.00,
                'group_price' => 59.00,
                'group_size_required' => 2,
                'group_duration_hours' => 24,
                'stock' => 80,
                'rating' => 4.8,
                'sales_count' => 312,
            ],
            [
                'title' => 'Lumina Minimalist Magnetic Desk Lamp with Qi Fast Charger',
                'slug' => 'lumina-minimalist-desk-lamp',
                'category_slug' => 'home-living',
                'description' => 'Anodized aluminum body with step-less touch dimming, 5 color temperature presets, flicker-free eye care LED, and 15W integrated wireless smartphone charger.',
                'image_url' => 'https://images.unsplash.com/photo-1534349762230-e0cadf78f5da?w=800&q=80',
                'single_price' => 85.00,
                'group_price' => 52.00,
                'group_size_required' => 2,
                'group_duration_hours' => 24,
                'stock' => 40,
                'rating' => 4.7,
                'sales_count' => 95,
            ],
            [
                'title' => 'Apex Pro Ergonomic Wireless Vertical Mouse',
                'slug' => 'apex-pro-ergonomic-vertical-mouse',
                'category_slug' => 'computing-gaming',
                'description' => 'Designed by orthopedic physiotherapists to eliminate wrist strain. Features 4000 DPI optical sensor, quiet click switches, and dual Bluetooth/2.4G connectivity.',
                'image_url' => 'https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?w=800&q=80',
                'single_price' => 69.00,
                'group_price' => 42.00,
                'group_size_required' => 2,
                'group_duration_hours' => 24,
                'stock' => 70,
                'rating' => 4.88,
                'sales_count' => 160,
            ],
        ];

        $createdProducts = [];
        foreach ($productsData as $p) {
            $cat = $categories[$p['category_slug']];
            unset($p['category_slug']);
            $p['seller_id'] = $seller->id;
            $p['category_id'] = $cat->id;
            $createdProducts[] = Product::updateOrCreate(['slug' => $p['slug']], $p);
        }

        // 4. Create Active Group Buy Sessions (with countdown timers ticking!)
        // Session 1: Aura Pro Headphones - 1 of 2 members joined (needs 1 more!)
        $session1 = GroupBuySession::updateOrCreate(
            ['group_code' => 'GRP-AURA99'],
            [
                'product_id' => $createdProducts[0]->id,
                'leader_user_id' => $customer1->id,
                'required_members' => 2,
                'current_members' => 1,
                'status' => 'active',
                'expires_at' => now()->addHours(14)->addMinutes(32)->addSeconds(45), // Live countdown!
            ]
        );

        GroupBuyMember::updateOrCreate(
            ['group_buy_session_id' => $session1->id, 'user_id' => $customer1->id],
            ['is_leader' => true, 'joined_at' => now()->subHours(2)]
        );

        // Session 2: Horizon Ultra Titan Watch - 2 of 3 members joined (needs 1 more!)
        $session2 = GroupBuySession::updateOrCreate(
            ['group_code' => 'GRP-TITAN7'],
            [
                'product_id' => $createdProducts[1]->id,
                'leader_user_id' => $customer2->id,
                'required_members' => 3,
                'current_members' => 2,
                'status' => 'active',
                'expires_at' => now()->addHours(21)->addMinutes(15)->addSeconds(10), // Live countdown!
            ]
        );

        GroupBuyMember::updateOrCreate(
            ['group_buy_session_id' => $session2->id, 'user_id' => $customer2->id],
            ['is_leader' => true, 'joined_at' => now()->subHours(5)]
        );

        GroupBuyMember::updateOrCreate(
            ['group_buy_session_id' => $session2->id, 'user_id' => $customer3->id],
            ['is_leader' => false, 'joined_at' => now()->subHours(1)]
        );

        // Session 3: Keyforge K8 Pro Keyboard - 1 of 2 joined
        $session3 = GroupBuySession::updateOrCreate(
            ['group_code' => 'GRP-KEYK8P'],
            [
                'product_id' => $createdProducts[2]->id,
                'leader_user_id' => $customer3->id,
                'required_members' => 2,
                'current_members' => 1,
                'status' => 'active',
                'expires_at' => now()->addHours(8)->addMinutes(45)->addSeconds(20), // Live countdown!
            ]
        );

        GroupBuyMember::updateOrCreate(
            ['group_buy_session_id' => $session3->id, 'user_id' => $customer3->id],
            ['is_leader' => true, 'joined_at' => now()->subHours(3)]
        );

        // 5. Sample completed order for Customer 1
        $sampleOrder = Order::updateOrCreate(
            ['order_number' => 'ORD-CARTIVA-001'],
            [
                'user_id' => $customer1->id,
                'order_type' => 'single',
                'group_buy_session_id' => null,
                'total_amount' => 119.00,
                'payment_method' => 'Cash on Delivery',
                'payment_status' => 'paid',
                'order_status' => 'processing',
                'shipping_name' => $customer1->name,
                'shipping_phone' => $customer1->phone,
                'shipping_address' => $customer1->address,
            ]
        );

        OrderItem::updateOrCreate(
            ['order_id' => $sampleOrder->id, 'product_id' => $createdProducts[4]->id],
            [
                'quantity' => 1,
                'unit_price' => 119.00,
                'subtotal' => 119.00,
            ]
        );
    }
}
