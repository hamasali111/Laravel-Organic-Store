<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name'     => 'Admin User',
            'email'    => 'admin@organicshop.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        User::factory()->create([
            'name'     => 'Jane Customer',
            'email'    => 'customer@organicshop.com',
            'password' => bcrypt('password'),
            'is_admin' => false,
        ]);

        $categories = [
            ['name' => 'Fresh Vegetables', 'slug' => 'fresh-vegetables', 'description' => 'Locally grown, certified organic vegetables harvested at peak freshness.', 'image' => 'https://images.unsplash.com/photo-1540420773420-3366772f4999?w=600&q=80'],
            ['name' => 'Fresh Fruits', 'slug' => 'fresh-fruits', 'description' => 'Sun-ripened organic fruits bursting with natural sweetness.', 'image' => 'https://images.unsplash.com/photo-1619566636858-adf3ef46400b?w=600&q=80'],
            ['name' => 'Grains & Cereals', 'slug' => 'grains-cereals', 'description' => 'Wholesome organic grains, seeds, and cereals for a nourishing diet.', 'image' => 'https://images.unsplash.com/photo-1586201375761-83865001e31c?w=600&q=80'],
            ['name' => 'Dairy & Eggs', 'slug' => 'dairy-eggs', 'description' => 'Farm-fresh organic dairy products and free-range eggs.', 'image' => 'https://images.unsplash.com/photo-1550583724-b2692b85b150?w=600&q=80'],
            ['name' => 'Herbs & Spices', 'slug' => 'herbs-spices', 'description' => 'Aromatic organic herbs and spices to elevate every dish.', 'image' => 'https://images.unsplash.com/photo-1532336414038-cf19250c5757?w=600&q=80'],
            ['name' => 'Superfoods', 'slug' => 'superfoods', 'description' => 'Nutrient-dense organic superfoods for optimal wellness.', 'image' => 'https://images.unsplash.com/photo-1511688878353-3a2f5be94cd7?w=600&q=80'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        $products = [
            ['category_id' => 1, 'name' => 'Organic Kale Bundle', 'slug' => 'organic-kale-bundle', 'description' => 'Crisp, dark green kale leaves packed with vitamins K, A, and C. Grown without pesticides on our partner farms.', 'price' => 1099, 'stock' => 50, 'image' => 'https://images.unsplash.com/photo-1524179091875-bf99a9a6af57?w=600&q=80', 'is_featured' => true, 'weight' => '250g'],
            ['category_id' => 1, 'name' => 'Rainbow Carrots', 'slug' => 'rainbow-carrots', 'description' => 'A colorful mix of purple, yellow, and orange organic carrots. Sweet and tender with earthy undertones.', 'price' => 1249, 'stock' => 40, 'image' => 'https://images.unsplash.com/photo-1447175008436-054170c2e979?w=600&q=80', 'is_featured' => true, 'weight' => '500g'],
            ['category_id' => 1, 'name' => 'Baby Spinach', 'slug' => 'baby-spinach', 'description' => 'Tender organic baby spinach leaves, perfect for salads, smoothies, and sautéing.', 'price' => 979, 'stock' => 60, 'image' => 'https://images.unsplash.com/photo-1576045057995-568f588f82fb?w=600&q=80', 'weight' => '200g'],
            ['category_id' => 1, 'name' => 'Heirloom Tomatoes', 'slug' => 'heirloom-tomatoes', 'description' => 'Beautifully misshapen, richly flavored heirloom tomatoes in a variety of colors.', 'price' => 1699, 'stock' => 35, 'image' => 'https://images.unsplash.com/photo-1592924357228-91a4daadcfea?w=600&q=80', 'is_featured' => true, 'weight' => '500g'],
            ['category_id' => 2, 'name' => 'Wild Blueberries', 'slug' => 'wild-blueberries', 'description' => 'Hand-harvested wild blueberries, smaller and more intensely flavored than cultivated varieties.', 'price' => 1949, 'stock' => 30, 'image' => 'https://images.unsplash.com/photo-1498557850523-fd3d118b962e?w=600&q=80', 'is_featured' => true, 'weight' => '300g'],
            ['category_id' => 2, 'name' => 'Pink Lady Apples', 'slug' => 'pink-lady-apples', 'description' => 'Crisp, tangy-sweet organic Pink Lady apples with a beautiful rosy blush skin.', 'price' => 1549, 'stock' => 55, 'image' => 'https://images.unsplash.com/photo-1567306226416-28f0efdc88ce?w=600&q=80', 'weight' => '1kg'],
            ['category_id' => 2, 'name' => 'Ataulfo Mangoes', 'slug' => 'ataulfo-mangoes', 'description' => 'Buttery, sweet Ataulfo mangoes with a thin pit and no fibrous texture. Pure tropical bliss.', 'price' => 2249, 'stock' => 25, 'image' => 'https://images.unsplash.com/photo-1553279768-865429fa0078?w=600&q=80', 'weight' => '2 pack'],
            ['category_id' => 3, 'name' => 'Quinoa Tri-Color', 'slug' => 'quinoa-tri-color', 'description' => 'A blend of white, red, and black quinoa. Complete protein source, gluten-free, and incredibly versatile.', 'price' => 2499, 'stock' => 45, 'image' => 'https://images.unsplash.com/photo-1586201375761-83865001e31c?w=600&q=80', 'is_featured' => true, 'weight' => '500g'],
            ['category_id' => 3, 'name' => 'Steel Cut Oats', 'slug' => 'steel-cut-oats', 'description' => 'Minimally processed organic oats with a chewy texture and nutty flavor. Low glycemic index.', 'price' => 1699, 'stock' => 60, 'image' => 'https://images.unsplash.com/photo-1571748982800-fa51082c2224?w=600&q=80', 'weight' => '1kg'],
            ['category_id' => 3, 'name' => 'Brown Basmati Rice', 'slug' => 'brown-basmati-rice', 'description' => 'Aromatic whole grain basmati rice with a delicate nutty flavor and fluffy texture.', 'price' => 1799, 'stock' => 50, 'image' => 'https://images.unsplash.com/photo-1536304993881-ff6e9eefa2a6?w=600&q=80', 'weight' => '1kg'],
            ['category_id' => 4, 'name' => 'Free-Range Eggs', 'slug' => 'free-range-eggs', 'description' => 'Eggs from hens raised on pasture with full outdoor access. Deep golden yolks and rich flavor.', 'price' => 1699, 'stock' => 40, 'image' => 'https://images.unsplash.com/photo-1582722872445-44dc5f7e3c8f?w=600&q=80', 'is_featured' => true, 'weight' => '12 pack'],
            ['category_id' => 4, 'name' => 'Grass-Fed Butter', 'slug' => 'grass-fed-butter', 'description' => 'Creamy butter from grass-fed cows with higher omega-3s and a richer, more complex flavor.', 'price' => 2099, 'stock' => 30, 'image' => 'https://images.unsplash.com/photo-1589985270826-4b7bb135bc9d?w=600&q=80', 'weight' => '250g'],
            ['category_id' => 5, 'name' => 'Fresh Basil', 'slug' => 'fresh-basil', 'description' => 'Fragrant organic sweet basil, perfect for pesto, caprese, and Italian dishes.', 'price' => 849, 'stock' => 35, 'image' => 'https://images.unsplash.com/photo-1618375529676-28e43f1e7ce0?w=600&q=80', 'weight' => '30g'],
            ['category_id' => 5, 'name' => 'Turmeric Root', 'slug' => 'turmeric-root', 'description' => 'Fresh organic turmeric root with powerful anti-inflammatory curcumin compounds.', 'price' => 1399, 'stock' => 45, 'image' => 'https://images.unsplash.com/photo-1615485500704-8e990f9900f7?w=600&q=80', 'weight' => '200g'],
            ['category_id' => 6, 'name' => 'Chia Seeds', 'slug' => 'chia-seeds', 'description' => 'Tiny but mighty organic chia seeds loaded with omega-3s, fiber, and plant protein.', 'price' => 2799, 'stock' => 55, 'image' => 'https://images.unsplash.com/photo-1514733670139-4d237900d325?w=600&q=80', 'is_featured' => true, 'weight' => '300g'],
            ['category_id' => 6, 'name' => 'Spirulina Powder', 'slug' => 'spirulina-powder', 'description' => 'Certified organic blue-green algae powder. One of the most nutrient-dense foods on earth.', 'price' => 4199, 'stock' => 30, 'image' => 'https://images.unsplash.com/photo-1622484211747-04a80c166cfe?w=600&q=80', 'weight' => '200g'],
            ['category_id' => 6, 'name' => 'Raw Cacao Nibs', 'slug' => 'raw-cacao-nibs', 'description' => 'Crushed organic raw cacao beans. Intensely chocolaty with antioxidants and magnesium.', 'price' => 3349, 'stock' => 40, 'image' => 'https://images.unsplash.com/photo-1606312619070-d48b4c652a52?w=600&q=80', 'is_featured' => true, 'weight' => '250g'],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        $coupons = [
            ['code' => 'WELCOME10', 'type' => 'percent', 'value' => 10,   'min_order' => 0,     'uses_left' => null, 'expires_at' => null,         'active' => true],
            ['code' => 'ORGANIC20', 'type' => 'percent', 'value' => 20,   'min_order' => 5000,  'uses_left' => 100,  'expires_at' => '2026-12-31', 'active' => true],
            ['code' => 'SAVE500',   'type' => 'fixed',   'value' => 500,  'min_order' => 3000,  'uses_left' => null, 'expires_at' => null,         'active' => true],
        ];

        foreach ($coupons as $coupon) {
            Coupon::create($coupon);
        }
    }
}
