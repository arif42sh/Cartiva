<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $host = request()->getHost();
        if ($host !== 'localhost' && $host !== '127.0.0.1') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        View::composer('layouts.app', function ($view) {
            $navTotalProducts = \App\Models\Product::where('is_active', true)->count();
            
            $dbCategories = Category::withCount(['products' => function ($q) {
                $q->where('is_active', true);
            }])->get()->keyBy('slug');

            $categoryConfig = [
                'computers-accessories' => [
                    'name_bn' => 'কম্পিউটার ও ল্যাপটপ',
                    'icon' => '💻',
                    'discount' => 'Up to 35% Off',
                    'badge' => 'জনপ্রিয়',
                    'badge_color' => 'bg-blue-100 text-blue-700',
                    'related' => ['computers-accessories', 'computing-gaming'],
                ],
                'mobile-accessories' => [
                    'name_bn' => 'মোবাইল ও গ্যাজেট',
                    'icon' => '📱',
                    'discount' => 'Up to 40% Off',
                    'badge' => 'হট ডিল',
                    'badge_color' => 'bg-rose-100 text-rose-700',
                    'related' => ['mobile-accessories'],
                ],
                'tech-accessories' => [
                    'name_bn' => 'ইলেকট্রনিক্স ও অডিও',
                    'icon' => '🎧',
                    'discount' => 'Up to 45% Off',
                    'badge' => 'বেস্টসেলার',
                    'badge_color' => 'bg-emerald-100 text-emerald-700',
                    'related' => ['tech-accessories', 'smart-tech-audio'],
                ],
                'fashion-wearables' => [
                    'name_bn' => 'ফ্যাশন ও পোশাক',
                    'icon' => '👗',
                    'discount' => 'Up to 50% Off',
                    'badge' => 'অফার',
                    'badge_color' => 'bg-purple-100 text-purple-700',
                    'related' => ['fashion-wearables', 'winter-specials'],
                ],
                'kitchen-appliances' => [
                    'name_bn' => 'কিচেন অ্যাপ্লায়েন্স',
                    'icon' => '🍳',
                    'discount' => 'Up to 35% Off',
                    'badge' => null,
                    'related' => ['kitchen-appliances'],
                ],
                'dry-food-fmcg' => [
                    'name_bn' => 'গ্রোসারি ও ফুড',
                    'icon' => '🥑',
                    'discount' => 'Up to 30% Off',
                    'badge' => 'পাইকারি',
                    'badge_color' => 'bg-amber-100 text-amber-700',
                    'related' => ['dry-food-fmcg'],
                ],
                'home-lifestyle' => [
                    'name_bn' => 'হোম ও লিভিং',
                    'icon' => '🏠',
                    'discount' => 'Up to 40% Off',
                    'badge' => null,
                    'related' => ['home-lifestyle', 'home-living'],
                ],
                'winter-specials' => [
                    'name_bn' => 'উইন্টার ও লাইফস্টাইল',
                    'icon' => '🧥',
                    'discount' => 'Up to 45% Off',
                    'badge' => 'সিজনাল',
                    'badge_color' => 'bg-cyan-100 text-cyan-700',
                    'related' => ['winter-specials'],
                ],
                'wearables-watches' => [
                    'name_bn' => 'স্মার্টওয়াচ ও গ্যাজেট',
                    'icon' => '⌚',
                    'discount' => 'Up to 40% Off',
                    'badge' => 'ট্রেন্ডিং',
                    'badge_color' => 'bg-indigo-100 text-indigo-700',
                    'related' => ['wearables-watches'],
                ],
                'computing-gaming' => [
                    'name_bn' => 'গেমিং গিয়ার ও সেটআপ',
                    'icon' => '🎮',
                    'discount' => 'Up to 35% Off',
                    'badge' => null,
                    'related' => ['computing-gaming'],
                ],
                'beauty-personal-care' => [
                    'name_bn' => 'বিউটি ও কেয়ার',
                    'icon' => '✨',
                    'discount' => 'Up to 35% Off',
                    'badge' => null,
                    'related' => ['beauty-personal-care'],
                ],
                'sports-fitness' => [
                    'name_bn' => 'স্পোর্টস ও ফিটনেস',
                    'icon' => '🏋️',
                    'discount' => 'Up to 30% Off',
                    'badge' => null,
                    'related' => ['sports-fitness'],
                ],
                'books-stationery' => [
                    'name_bn' => 'বই ও স্টেশনারি',
                    'icon' => '📚',
                    'discount' => 'Up to 30% Off',
                    'badge' => null,
                    'related' => ['books-stationery'],
                ],
                'baby-kids' => [
                    'name_bn' => 'বেবি ও কিডস',
                    'icon' => '🧸',
                    'discount' => 'Up to 35% Off',
                    'badge' => null,
                    'related' => ['baby-kids'],
                ],
                'fashion-bags' => [
                    'name_bn' => 'ব্যাগ ও ট্রাভেল',
                    'icon' => '🎒',
                    'discount' => 'Up to 40% Off',
                    'badge' => null,
                    'related' => ['fashion-bags'],
                ],
            ];

            $megaCategories = [];
            foreach ($categoryConfig as $slug => $cfg) {
                $catModel = $dbCategories->get($slug);
                if (!$catModel) {
                    continue;
                }

                $count = 0;
                foreach ($cfg['related'] as $relSlug) {
                    $relModel = $dbCategories->get($relSlug);
                    if ($relModel) {
                        $count += $relModel->products_count;
                    }
                }
                if ($count === 0 && $catModel->products_count > 0) {
                    $count = $catModel->products_count;
                }

                $megaCategories[] = [
                    'id' => $catModel->id,
                    'slug' => $catModel->slug,
                    'name_bn' => $cfg['name_bn'],
                    'name_en' => $catModel->name,
                    'icon' => $cfg['icon'] ?? $catModel->icon ?? '🛍️',
                    'count' => $count,
                    'discount' => $cfg['discount'],
                    'badge' => $cfg['badge'] ?? null,
                    'badge_color' => $cfg['badge_color'] ?? null,
                ];
            }

            // Append any dynamically created seller categories not explicitly listed
            foreach ($dbCategories as $cat) {
                if (!array_key_exists($cat->slug, $categoryConfig) && !in_array($cat->slug, ['smart-tech-audio', 'home-living'])) {
                    $megaCategories[] = [
                        'id' => $cat->id,
                        'slug' => $cat->slug,
                        'name_bn' => $cat->name,
                        'name_en' => $cat->name,
                        'icon' => $cat->icon ?? '🛍️',
                        'count' => $cat->products_count,
                        'discount' => 'Up to 30% Off',
                        'badge' => null,
                        'badge_color' => null,
                    ];
                }
            }

            $view->with([
                'navCategories' => $dbCategories->values(),
                'megaCategories' => $megaCategories,
                'navTotalProducts' => $navTotalProducts,
            ]);
        });
    }
}
