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
                'name' => 'Apex Tech & Lifestyle Hub',
                'password' => Hash::make('password123'),
                'role' => 'seller',
                'phone' => '+880 1811 000002',
                'address' => 'Saidpur / Dhaka Commercial Hub',
            ]
        );

        $customer1 = User::updateOrCreate(
            ['email' => 'customer@cartiva.com'],
            [
                'name' => 'Arif Shahriar',
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'phone' => '+880 1911 000003',
                'address' => 'Saidpur Commercial Area, Nilphamari',
            ]
        );

        $customer2 = User::updateOrCreate(
            ['email' => 'tahmid@cartiva.com'],
            [
                'name' => 'Ashikur Rahman',
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'phone' => '+880 1611 000004',
                'address' => 'Dhanmondi, Dhaka',
            ]
        );

        $customer3 = User::updateOrCreate(
            ['email' => 'farhana@cartiva.com'],
            [
                'name' => 'Fuad Hossain',
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'phone' => '+880 1511 000005',
                'address' => 'Uttara, Dhaka',
            ]
        );

        // 2. Categories matching the prompt checklist
        $categoriesData = [
            [
                'name' => 'ইলেকট্রনিক্স (Electronics)',
                'slug' => 'tech-accessories',
                'icon' => '🎧',
                'description' => 'স্মার্ট গ্যাজেটস, নয়েজ ক্যান্সেলিং হেডফোন, কিবোর্ড ও পাওয়ার ব্যাংক',
            ],
            [
                'name' => 'উইন্টার ও লাইফস্টাইল (Winter & Lifestyle)',
                'slug' => 'winter-specials',
                'icon' => '🧥',
                'description' => 'প্রিমিয়াম উইন্টার হুডি, ওয়াটারপ্রুফ ট্রাভেল ব্যাগ ও কমফোর্ট এক্সেসরিজ',
            ],
            [
                'name' => 'গ্রোসারি ও খাদ্যদ্রব্য (Grocery & Food)',
                'slug' => 'dry-food-fmcg',
                'icon' => '🥫',
                'description' => 'প্যাকেজড প্রিমিয়াম বাদাম, মধু, অর্গানিক চা ও গ্রোসারি কম্বো',
            ],
            [
                'name' => 'হোম ও লিভিং (Home & Living)',
                'slug' => 'home-lifestyle',
                'icon' => '🏠',
                'description' => 'মডার্ন ফার্নিচার, রিডিং ল্যাম্প ও হোম ডেকর এক্সেসরিজ',
            ],
            [
                'name' => 'ফ্যাশন ও পোশাক (Fashion & Apparel)',
                'slug' => 'fashion-wearables',
                'icon' => '👕',
                'description' => 'স্মার্টওয়াচ, সানগ্লাস, উইন্টার কালেকশন ও প্রিমিয়াম আউটফিট',
            ],
            [
                'name' => 'মোবাইল ও এক্সেসরিজ (Mobile & Accessories)',
                'slug' => 'mobile-accessories',
                'icon' => '📱',
                'description' => 'ফাস্ট চার্জার, ম্যাগসেফ কেস, পাওয়ার ব্যাংক ও ওটিজি ক্যাবল',
            ],
            [
                'name' => 'কম্পিউটার ও ল্যাপটপ (Computers & IT)',
                'slug' => 'computers-accessories',
                'icon' => '💻',
                'description' => 'মেকানিক্যাল কিবোর্ড, ওয়্যারলেস মাউস, ইউএসবি হাব ও মনিটর স্ট্যান্ড',
            ],
            [
                'name' => 'বিউটি ও কেয়ার (Beauty & Care)',
                'slug' => 'beauty-personal-care',
                'icon' => '✨',
                'description' => 'অর্গানিক স্কিনকেয়ার, সানস্ক্রিন ও পারসোনাল হাইজিন কিট',
            ],
            [
                'name' => 'কিচেন ও অ্যাপ্লায়েন্স (Kitchen Appliances)',
                'slug' => 'kitchen-appliances',
                'icon' => '🍳',
                'description' => 'এয়ার ফ্রায়ার, ব্লেন্ডার, ইলেকট্রিক কেটলি ও কফি মেকার',
            ],
            [
                'name' => 'স্পোর্টস ও ফিটনেস (Sports & Fitness)',
                'slug' => 'sports-fitness',
                'icon' => '🏋️',
                'description' => 'জিম ডাম্বেল, রেজিস্ট্যান্স ব্যান্ড, ইয়োগা ম্যাট ও শেকার',
            ],
            [
                'name' => 'বই ও স্টেশনারি (Books & Stationery)',
                'slug' => 'books-stationery',
                'icon' => '📚',
                'description' => 'একাডেমিক বই, প্রিমিয়াম জার্নাল, ফাউন্টেন পেন ও ক্যালকুলেটর',
            ],
            [
                'name' => 'বেবি ও কিডস (Baby & Kids)',
                'slug' => 'baby-kids',
                'icon' => '🧸',
                'description' => 'বেবি ডায়াপার, টয় সেট, স্টাডি টেবিল ও কিডস নিউট্রিশন',
            ],
        ];

        $categories = [];
        foreach ($categoriesData as $c) {
            $categories[$c['slug']] = Category::updateOrCreate(['slug' => $c['slug']], $c);
        }

        // 3. Products with BDT pricing tiers and images
        $productsData = [
            [
                'title' => 'SoundCore Ultra ANC Active Noise Cancelling Headphones',
                'slug' => 'soundcore-ultra-anc-headphones',
                'category_slug' => 'tech-accessories',
                'description' => 'অ্যাডাপ্টিভ অ্যাক্টিভ নয়েজ ক্যান্সেলেশন (ANC), ৪০ মিমি বেরিলিয়াম ড্রাইভার, ৪০ ঘণ্টা ব্যাটারি লাইফ এবং প্রিমিয়াম মেমোরি ফোম কুশন সহ হাই-রেজুলিউশন অডিও।',
                'image_url' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800&q=80',
                'single_price' => 4500.00,
                'group_price' => 3150.00,
                'group_size_required' => 2,
                'group_duration_hours' => 24,
                'stock' => 35,
                'rating' => 4.9,
                'sales_count' => 148,
            ],
            [
                'title' => 'Cartiva Heavyweight Premium Fleece Winter Hoodie',
                'slug' => 'premium-fleece-winter-hoodie',
                'category_slug' => 'winter-specials',
                'description' => '৪৫০ জিএসএম প্রিমিয়াম কটন ফ্লিস ফ্যাব্রিক, ড্রপ শোল্ডার ওভারসাইজড কমফোর্ট ফিট, প্রিমিয়াম ফিনিশ। বন্ধুদের সাথে গ্রুপ করে কিনলে সর্বোচ্চ ছাড়!',
                'image_url' => 'https://images.unsplash.com/photo-1556905055-8f358a7a47b2?w=800&q=80',
                'single_price' => 1000.00,
                'group_price' => 750.00,
                'group_size_required' => 5,
                'group_duration_hours' => 48,
                'stock' => 120,
                'rating' => 4.95,
                'sales_count' => 320,
            ],
            [
                'title' => 'Organic Medjool Premium Dates & Dry Fruit Mega Box (1kg Bulk Pack)',
                'slug' => 'organic-medjool-dates-dry-fruit-pack',
                'category_slug' => 'dry-food-fmcg',
                'description' => 'আমদানি করা শতভাগ ন্যাচারাল মদিনার মেদজুল খেজুর, কাঠবাদাম, কাজুবাদাম এবং কিশমিশের হাইজিনিক এয়ারটাইট কম্বো প্যাক। পরিবার বা বন্ধুদের সাথে শেয়ারিংয়ে দারুণ সাশ্রয়।',
                'image_url' => 'https://images.unsplash.com/photo-1596040033229-a9821ebd058d?w=800&q=80',
                'single_price' => 1800.00,
                'group_price' => 1250.00,
                'group_size_required' => 3,
                'group_duration_hours' => 24,
                'stock' => 45,
                'rating' => 4.88,
                'sales_count' => 195,
            ],
            [
                'title' => 'Keyforge K8 Pro Wireless RGB Mechanical Keyboard (Hot-Swap)',
                'slug' => 'keyforge-k8-pro-mechanical-keyboard',
                'category_slug' => 'tech-accessories',
                'description' => 'হট-সোয়াপ্যাবল ব্রাউন ট্যাকটাইল সুইচ, পিবিটি ডাবল-শট কি-ক্যাপস, সাউন্ড ড্যাম্পেনিং সিলিকন প্যাড এবং ব্লুটুথ ৫.২ মাল্টি-ডিভাইস কানেক্টিভিটি।',
                'image_url' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=800&q=80',
                'single_price' => 3800.00,
                'group_price' => 2700.00,
                'group_size_required' => 2,
                'group_duration_hours' => 24,
                'stock' => 40,
                'rating' => 4.92,
                'sales_count' => 210,
            ],
            [
                'title' => 'Barista Artisan Compact Espresso & Latte Maker (19-Bar Italian Pump)',
                'slug' => 'barista-artisan-compact-espresso-maker',
                'category_slug' => 'home-lifestyle',
                'description' => 'ক্যাফে কোয়ালিটি হাই-প্রেসার এক্সট্রাকশন, স্টেইনলেস স্টিল থার্মোব্লক হিটিং, মাইক্রো-ফোম স্টিম ওয়ান্ড এবং ফাস্ট ৩০-সেকেন্ড হিট-আপ সিস্টেম।',
                'image_url' => 'https://images.unsplash.com/photo-1517668808822-9ebb02f2a0e6?w=800&q=80',
                'single_price' => 6500.00,
                'group_price' => 4800.00,
                'group_size_required' => 3,
                'group_duration_hours' => 36,
                'stock' => 20,
                'rating' => 4.82,
                'sales_count' => 64,
            ],
            [
                'title' => 'Nomad Explorer Waterproof Tech Backpack with USB Charging Port',
                'slug' => 'nomad-explorer-waterproof-backpack',
                'category_slug' => 'winter-specials',
                'description' => 'ওয়াটারপ্রুফ কর্ডুরা নাইলন, ১৬ ইঞ্চি প্যাডেড ল্যাপটপ চেম্বার, অ্যান্টি-থেফ্ট ব্যাক পকেট এবং ইর্গোনমিক ভেন্টিলেটেড ব্যাক প্যানেল। অফিস ও ট্রাভেলের জন্য পারফেক্ট।',
                'image_url' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=800&q=80',
                'single_price' => 2200.00,
                'group_price' => 1550.00,
                'group_size_required' => 2,
                'group_duration_hours' => 24,
                'stock' => 60,
                'rating' => 4.87,
                'sales_count' => 275,
            ],
            [
                'title' => 'Lumina Eye-Care Magnetic LED Desk Reading Lamp with 15W Qi Charger',
                'slug' => 'lumina-eyecare-led-desk-lamp',
                'category_slug' => 'home-lifestyle',
                'description' => 'স্টেপ-লেস টাচ ডিমিং, ৫টি কালার টেম্পারেচার মোড, ফ্লিকার-ফ্রি আই-প্রোটেকশন এবং ইন্টিগ্রেটেড ফাস্ট ওয়্যারলেস স্মার্টফোন চার্জিং প্যাড।',
                'image_url' => 'https://images.unsplash.com/photo-1534349762230-e0cadf78f5da?w=800&q=80',
                'single_price' => 1650.00,
                'group_price' => 1150.00,
                'group_size_required' => 2,
                'group_duration_hours' => 24,
                'stock' => 50,
                'rating' => 4.79,
                'sales_count' => 110,
            ],
            [
                'title' => 'Horizon Ultra Titan Smartwatch with AMOLED Display & Bluetooth Call',
                'slug' => 'horizon-ultra-titan-smartwatch',
                'category_slug' => 'fashion-wearables',
                'description' => 'অ্যারোস্পেস টাইটানিয়াম কেসিং, সাফায়ার গ্লাস স্ক্রিন, হার্ট রেট ও SpO2 সেন্সর, ১০০টির বেশি স্পোর্টস মোড এবং ৭ দিনের লং ব্যাটারি লাইফ।',
                'image_url' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=800&q=80',
                'single_price' => 3500.00,
                'group_price' => 2450.00,
                'group_size_required' => 3,
                'group_duration_hours' => 48,
                'stock' => 25,
                'rating' => 4.91,
                'sales_count' => 135,
            ],
            [
                'title' => 'Anker 65W GaN III Fast Charger with Dual Type-C & USB-A Ports',
                'slug' => 'anker-65w-gan-fast-charger',
                'category_slug' => 'mobile-accessories',
                'description' => 'আল্ট্রা-কম্প্যাক্ট গ্যালিয়াম নাইট্রাইড (GaN) প্রযুক্তি, ল্যাপটপ ও স্মার্টফোনে হাই-স্পিড পিডি চার্জিং সাপোর্ট।',
                'image_url' => 'https://images.unsplash.com/photo-1583863788434-e58a36330cf0?w=800&q=80',
                'single_price' => 2800.00,
                'group_price' => 1950.00,
                'group_size_required' => 3,
                'group_duration_hours' => 24,
                'stock' => 40,
                'rating' => 4.93,
                'sales_count' => 180,
            ],
            [
                'title' => 'Logitech MX Master 3S Ergonomic Wireless Performance Mouse',
                'slug' => 'logitech-mx-master-3s-mouse',
                'category_slug' => 'computers-accessories',
                'description' => '৮০০০ ডিপিআই ট্র্যাকিং, ম্যাগস্পিড ইলেক্ট্রোম্যাগনেটিক স্ক্রোলিং এবং সাইলেন্ট ক্লিক মেকানিজম। কোডিং ও ডিজাইনের জন্য সেরা।',
                'image_url' => 'https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?w=800&q=80',
                'single_price' => 9500.00,
                'group_price' => 7600.00,
                'group_size_required' => 2,
                'group_duration_hours' => 48,
                'stock' => 15,
                'rating' => 4.98,
                'sales_count' => 95,
            ],
            [
                'title' => 'DermaPro SPF 50+ Aqua Sunscreen & Hyaluronic Serum Combo Pack',
                'slug' => 'dermapro-sunscreen-serum-combo',
                'category_slug' => 'beauty-personal-care',
                'description' => 'হোয়াইট কাস্ট ফ্রি, ওয়াটার-রেজিস্ট্যান্ট ইউভি প্রোটেকশন এবং স্কিন হাইড্রেটিং হায়ালুরোনিক অ্যাসিড ফর্মুলা।',
                'image_url' => 'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=800&q=80',
                'single_price' => 1500.00,
                'group_price' => 990.00,
                'group_size_required' => 3,
                'group_duration_hours' => 24,
                'stock' => 60,
                'rating' => 4.85,
                'sales_count' => 140,
            ],
            [
                'title' => 'Philips Essential 4.1L Rapid Air Digital Air Fryer (Low Oil Cooking)',
                'slug' => 'philips-essential-digital-air-fryer',
                'category_slug' => 'kitchen-appliances',
                'description' => '৯০% কম তেলে স্বাস্থ্যকর ফ্রাইং, টাচস্ক্রিন ৭টি প্রিসেট মোড এবং নন-স্টিক ডিশওয়াশার সেফ বাস্কেট।',
                'image_url' => 'https://images.unsplash.com/photo-1585515320310-259814833e62?w=800&q=80',
                'single_price' => 12500.00,
                'group_price' => 9400.00,
                'group_size_required' => 2,
                'group_duration_hours' => 36,
                'stock' => 12,
                'rating' => 4.94,
                'sales_count' => 52,
            ],
            [
                'title' => 'TitanFit Hex Rubber Dumbbell Set (10kg Pair + Workout Mat)',
                'slug' => 'titanfit-hex-dumbbell-set-10kg',
                'category_slug' => 'sports-fitness',
                'description' => 'নন-স্লিপ ক্রোম হ্যান্ডেল, হাই-কোয়ালিটি রাবার কোটেড বডি এবং ১০ মিমি থিক প্রিমিয়াম অ্যান্টি-টিয়ার ম্যাট।',
                'image_url' => 'https://images.unsplash.com/photo-1584735935682-2f2b69dff9d2?w=800&q=80',
                'single_price' => 3200.00,
                'group_price' => 2300.00,
                'group_size_required' => 3,
                'group_duration_hours' => 24,
                'stock' => 30,
                'rating' => 4.86,
                'sales_count' => 88,
            ],
            [
                'title' => 'Classic Leather Bound Journal & Metal Calligraphy Pen Set',
                'slug' => 'classic-leather-bound-journal-set',
                'category_slug' => 'books-stationery',
                'description' => 'হাতে তৈরি জেনুইন লেদার কভার, ১০০ জিএসএম ব্লিড-প্রুফ ভিন্টেজ পেপার ও প্রিমিয়াম রিলোড্যাবল পেন।',
                'image_url' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=800&q=80',
                'single_price' => 1100.00,
                'group_price' => 750.00,
                'group_size_required' => 4,
                'group_duration_hours' => 48,
                'stock' => 70,
                'rating' => 4.89,
                'sales_count' => 165,
            ],
            [
                'title' => 'EcoBaby Non-Toxic Soft Silicone Feeding & Teether Set (BPA Free)',
                'slug' => 'ecobaby-silicone-feeding-teether-set',
                'category_slug' => 'baby-kids',
                'description' => 'ফুড-গ্রেড নরম সিলিকন বাটি, সেকশন প্লেট, প্রশিক্ষণ চামচ ও পানির বোতল কম্বো। শিশুদের জন্য ১০০% নিরাপদ।',
                'image_url' => 'https://images.unsplash.com/photo-1515488042361-ee00e0ddd4e4?w=800&q=80',
                'single_price' => 1400.00,
                'group_price' => 920.00,
                'group_size_required' => 3,
                'group_duration_hours' => 24,
                'stock' => 45,
                'rating' => 4.95,
                'sales_count' => 115,
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

        // 4. Create Active Group Buy Sessions (Ending Soon & Hot Groups with Ticking Timers!)
        // Session 1: SoundCore Headphones - 1 of 2 joined (Only 1 slot remaining!)
        $session1 = GroupBuySession::updateOrCreate(
            ['group_code' => 'GRP-SOUND99'],
            [
                'product_id' => $createdProducts[0]->id,
                'leader_user_id' => $customer1->id,
                'required_members' => 2,
                'current_members' => 1,
                'status' => 'active',
                'expires_at' => now()->addHours(3)->addMinutes(12)->addSeconds(40), // 3 hours 12 mins left!
            ]
        );

        GroupBuyMember::updateOrCreate(
            ['group_buy_session_id' => $session1->id, 'user_id' => $customer1->id],
            ['is_leader' => true, 'joined_at' => now()->subHours(2)]
        );

        // Session 2: Fleece Hoodie - 4 of 5 joined (Only 1 slot remaining for Tier 3 750 taka unlock!)
        $session2 = GroupBuySession::updateOrCreate(
            ['group_code' => 'GRP-HOODIE05'],
            [
                'product_id' => $createdProducts[1]->id,
                'leader_user_id' => $customer2->id,
                'required_members' => 5,
                'current_members' => 4,
                'status' => 'active',
                'expires_at' => now()->addHours(5)->addMinutes(45)->addSeconds(20), // 5 hours 45 mins left!
            ]
        );

        GroupBuyMember::updateOrCreate(
            ['group_buy_session_id' => $session2->id, 'user_id' => $customer2->id],
            ['is_leader' => true, 'joined_at' => now()->subHours(6)]
        );
        GroupBuyMember::updateOrCreate(
            ['group_buy_session_id' => $session2->id, 'user_id' => $customer1->id],
            ['is_leader' => false, 'joined_at' => now()->subHours(4)]
        );
        GroupBuyMember::updateOrCreate(
            ['group_buy_session_id' => $session2->id, 'user_id' => $customer3->id],
            ['is_leader' => false, 'joined_at' => now()->subHours(2)]
        );
        GroupBuyMember::updateOrCreate(
            ['group_buy_session_id' => $session2->id, 'user_id' => $admin->id],
            ['is_leader' => false, 'joined_at' => now()->subHour()]
        );

        // Session 3: Organic Dates Pack - 2 of 3 joined (1 slot remaining!)
        $session3 = GroupBuySession::updateOrCreate(
            ['group_code' => 'GRP-DATES33'],
            [
                'product_id' => $createdProducts[2]->id,
                'leader_user_id' => $customer3->id,
                'required_members' => 3,
                'current_members' => 2,
                'status' => 'active',
                'expires_at' => now()->addHours(8)->addMinutes(18)->addSeconds(15),
            ]
        );

        GroupBuyMember::updateOrCreate(
            ['group_buy_session_id' => $session3->id, 'user_id' => $customer3->id],
            ['is_leader' => true, 'joined_at' => now()->subHours(4)]
        );
        GroupBuyMember::updateOrCreate(
            ['group_buy_session_id' => $session3->id, 'user_id' => $customer2->id],
            ['is_leader' => false, 'joined_at' => now()->subHours(1)]
        );

        // Session 4: Keyforge Keyboard - 1 of 2 joined (1 slot left)
        $session4 = GroupBuySession::updateOrCreate(
            ['group_code' => 'GRP-KEYK8P'],
            [
                'product_id' => $createdProducts[3]->id,
                'leader_user_id' => $customer1->id,
                'required_members' => 2,
                'current_members' => 1,
                'status' => 'active',
                'expires_at' => now()->addHours(6)->addMinutes(50)->addSeconds(10),
            ]
        );

        GroupBuyMember::updateOrCreate(
            ['group_buy_session_id' => $session4->id, 'user_id' => $customer1->id],
            ['is_leader' => true, 'joined_at' => now()->subHours(1)]
        );

        // Session 5: Horizon Ultra Titan Smartwatch - 2 of 3 joined (1 slot left!)
        if (isset($createdProducts[7])) {
            $session5 = GroupBuySession::updateOrCreate(
                ['group_code' => 'GRP-TITAN7'],
                [
                    'product_id' => $createdProducts[7]->id,
                    'leader_user_id' => $customer2->id,
                    'required_members' => 3,
                    'current_members' => 2,
                    'status' => 'active',
                    'expires_at' => now()->addHours(2)->addMinutes(15)->addSeconds(45), // 2h 15m left!
                ]
            );

            GroupBuyMember::updateOrCreate(
                ['group_buy_session_id' => $session5->id, 'user_id' => $customer2->id],
                ['is_leader' => true, 'joined_at' => now()->subHours(3)]
            );
            GroupBuyMember::updateOrCreate(
                ['group_buy_session_id' => $session5->id, 'user_id' => $customer3->id],
                ['is_leader' => false, 'joined_at' => now()->subHours(1)]
            );
        }

        // Session 6: Anker 65W GaN Fast Charger - 2 of 3 joined (1 slot left!)
        if (isset($createdProducts[8])) {
            $session6 = GroupBuySession::updateOrCreate(
                ['group_code' => 'GRP-ANK65'],
                [
                    'product_id' => $createdProducts[8]->id,
                    'leader_user_id' => $customer3->id,
                    'required_members' => 3,
                    'current_members' => 2,
                    'status' => 'active',
                    'expires_at' => now()->addHours(4)->addMinutes(40)->addSeconds(30), // 4h 40m left!
                ]
            );

            GroupBuyMember::updateOrCreate(
                ['group_buy_session_id' => $session6->id, 'user_id' => $customer3->id],
                ['is_leader' => true, 'joined_at' => now()->subHours(2)]
            );
            GroupBuyMember::updateOrCreate(
                ['group_buy_session_id' => $session6->id, 'user_id' => $admin->id],
                ['is_leader' => false, 'joined_at' => now()->subMinutes(45)]
            );
        }

        // Session 7: Philips Air Fryer - 1 of 2 joined (1 slot left!)
        if (isset($createdProducts[11])) {
            $session7 = GroupBuySession::updateOrCreate(
                ['group_code' => 'GRP-FRY08'],
                [
                    'product_id' => $createdProducts[11]->id,
                    'leader_user_id' => $customer1->id,
                    'required_members' => 2,
                    'current_members' => 1,
                    'status' => 'active',
                    'expires_at' => now()->addHours(1)->addMinutes(25)->addSeconds(50), // 1h 25m left! Super urgent!
                ]
            );

            GroupBuyMember::updateOrCreate(
                ['group_buy_session_id' => $session7->id, 'user_id' => $customer1->id],
                ['is_leader' => true, 'joined_at' => now()->subMinutes(30)]
            );
        }

        // Session 8: Logitech MX Master 3S - 1 of 2 joined (1 slot left!)
        if (isset($createdProducts[9])) {
            $session8 = GroupBuySession::updateOrCreate(
                ['group_code' => 'GRP-MX3S01'],
                [
                    'product_id' => $createdProducts[9]->id,
                    'leader_user_id' => $customer2->id,
                    'required_members' => 2,
                    'current_members' => 1,
                    'status' => 'active',
                    'expires_at' => now()->addHours(7)->addMinutes(55)->addSeconds(20),
                ]
            );

            GroupBuyMember::updateOrCreate(
                ['group_buy_session_id' => $session8->id, 'user_id' => $customer2->id],
                ['is_leader' => true, 'joined_at' => now()->subHours(1)]
            );
        }
    }
}
