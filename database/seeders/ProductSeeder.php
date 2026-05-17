<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::pluck('id', 'name');

        $products = [
            // ── Electronics ──────────────────────────────────────────────────
            [
                'category'          => 'Electronics',
                'name'              => 'ProSound Wireless ANC Headphones',
                'short_description' => 'Premium 40-hour battery life with active noise cancellation and Hi-Res audio certification.',
                'description'       => '<p>Experience music the way the artist intended. The ProSound ANC Headphones deliver studio-quality sound with adaptive three-level noise cancellation. The 40mm dynamic drivers produce deep, punchy bass alongside crystal-clear highs.</p><p>Features: Bluetooth 5.3, 40-hour playback, 10-minute quick charge gives 3 hours of listening, foldable design, and built-in voice assistant support.</p>',
                'sku'               => 'ELC-HP-001',
                'price'             => 179.99,
                'compare_price'     => 229.99,
                'stock_quantity'    => 45,
                'brand'             => 'ProSound',
                'is_featured'       => true,
            ],
            [
                'category'          => 'Electronics',
                'name'              => 'UltraView 4K Portable Monitor',
                'short_description' => 'Stunning 15.6" 4K IPS display with USB-C single cable connectivity.',
                'description'       => '<p>The UltraView portable monitor is the ultimate companion for professionals on the move. Its 15.6-inch IPS panel delivers 3840×2160 resolution with 100% sRGB color accuracy.</p><p>Single USB-C cable provides both power and video signal. Features include HDR400, 178° wide-view angle, and a built-in kickstand.</p>',
                'sku'               => 'ELC-MN-002',
                'price'             => 349.00,
                'compare_price'     => null,
                'stock_quantity'    => 22,
                'brand'             => 'UltraView',
                'is_featured'       => true,
            ],
            [
                'category'          => 'Electronics',
                'name'              => 'NovaMech Mechanical Keyboard TKL',
                'short_description' => 'Compact tenkeyless layout with RGB per-key illumination and hot-swap switches.',
                'description'       => '<p>Engineered for performance and customisation, the NovaMech TKL features hot-swappable PCB — change switches without soldering. Ships with NovaMech Red linear switches (45g actuation).</p><p>Aircraft-grade aluminium top plate, gasket-mounted PCB for quieter typing feel, USB-C detachable cable, and full RGB programmability via NovaMech software.</p>',
                'sku'               => 'ELC-KB-003',
                'price'             => 129.99,
                'compare_price'     => 149.99,
                'stock_quantity'    => 60,
                'brand'             => 'NovaMech',
                'is_featured'       => false,
            ],
            [
                'category'          => 'Electronics',
                'name'              => 'SwiftCharge 140W GaN Charger',
                'short_description' => '4-port GaN charger with 140W total output — charge your entire setup at once.',
                'description'       => '<p>Power up to four devices simultaneously with this compact GaN charger. Features two USB-C ports (140W + 65W) and two USB-A ports with intelligent power distribution.</p>',
                'sku'               => 'ELC-CH-004',
                'price'             => 64.99,
                'compare_price'     => null,
                'stock_quantity'    => 120,
                'brand'             => 'SwiftCharge',
                'is_featured'       => false,
            ],

            // ── Clothing & Apparel ────────────────────────────────────────────
            [
                'category'          => 'Clothing & Apparel',
                'name'              => 'Heritage Slim Fit Oxford Shirt',
                'short_description' => '100% premium Egyptian cotton slim-fit shirt with mother-of-pearl buttons.',
                'description'       => '<p>Crafted from long-staple Egyptian cotton, this Heritage Oxford shirt is woven for breathability and durability. The slim-fit silhouette cuts a clean, modern line without sacrificing comfort.</p><p>Available in White, Pale Blue, Lavender, and Sage. Machine washable.</p>',
                'sku'               => 'APP-SH-001',
                'price'             => 89.00,
                'compare_price'     => null,
                'stock_quantity'    => 200,
                'brand'             => 'Heritage Goods',
                'is_featured'       => true,
            ],
            [
                'category'          => 'Clothing & Apparel',
                'name'              => 'Alpine Merino Crew Neck Sweater',
                'short_description' => 'Fine 100% Merino wool sweater — naturally temperature-regulating and itch-free.',
                'description'       => '<p>The Alpine Merino Sweater is made from 17.5-micron fine Merino wool — the standard for luxury knitwear. Merino regulates body temperature naturally, keeps you warm in winter and cool in mild weather, and resists odour.</p>',
                'sku'               => 'APP-SW-002',
                'price'             => 145.00,
                'compare_price'     => 180.00,
                'stock_quantity'    => 80,
                'brand'             => 'Alpine Thread',
                'is_featured'       => false,
            ],
            [
                'category'          => 'Clothing & Apparel',
                'name'              => 'Velocity Performance Running Shorts',
                'short_description' => 'Lightweight 4-way stretch shorts with built-in liner and hidden zip pocket.',
                'description'       => '<p>Engineered for speed and comfort, the Velocity Running Shorts are made from our proprietary AeroWeave fabric — 87% recycled polyester, 13% elastane — offering maximum stretch, sweat-wicking, and UV50+ protection.</p>',
                'sku'               => 'APP-SH-003',
                'price'             => 55.00,
                'compare_price'     => null,
                'stock_quantity'    => 150,
                'brand'             => 'Velocity Active',
                'is_featured'       => false,
            ],

            // ── Home & Living ─────────────────────────────────────────────────
            [
                'category'          => 'Home & Living',
                'name'              => 'Ember Ceramic Pour-Over Coffee Set',
                'short_description' => 'Handcrafted ceramic dripper with borosilicate carafe for the perfect pour-over ritual.',
                'description'       => '<p>Each Ember Pour-Over dripper is hand-thrown by artisan potters and features a carefully calibrated ribbed interior to optimise water flow and extraction. The set includes a 600ml borosilicate glass carafe, ceramic dripper, and stainless steel mesh filter.</p>',
                'sku'               => 'HOM-CF-001',
                'price'             => 72.00,
                'compare_price'     => null,
                'stock_quantity'    => 35,
                'brand'             => 'Ember Workshop',
                'is_featured'       => true,
            ],
            [
                'category'          => 'Home & Living',
                'name'              => 'Dune Linen Duvet Cover Set — King',
                'short_description' => 'Stone-washed 100% French linen in a relaxed, lived-in finish. King size set.',
                'description'       => '<p>French flax linen, grown sustainably in Normandy, gets softer with every wash. The stone-washed finish creates an instantly relaxed aesthetic. Includes one king duvet cover (220×230cm) and two pillowcases (50×75cm).</p>',
                'sku'               => 'HOM-BD-002',
                'price'             => 189.00,
                'compare_price'     => 239.00,
                'stock_quantity'    => 25,
                'brand'             => 'Dune Home',
                'is_featured'       => true,
            ],
            [
                'category'          => 'Home & Living',
                'name'              => 'Modular Walnut Shelf System',
                'short_description' => 'FSC-certified solid walnut modular shelving — configure to any wall width.',
                'description'       => '<p>Each module (90×30cm) connects seamlessly to create a bespoke shelving wall. FSC-certified solid American walnut with natural oil finish. Steel wall brackets included. Compatible with matching door and drawer modules.</p>',
                'sku'               => 'HOM-SH-003',
                'price'             => 320.00,
                'compare_price'     => null,
                'stock_quantity'    => 15,
                'brand'             => 'Form & Grain',
                'is_featured'       => false,
            ],

            // ── Sports & Outdoors ─────────────────────────────────────────────
            [
                'category'          => 'Sports & Outdoors',
                'name'              => 'Summit Pro 45L Hiking Backpack',
                'short_description' => '45-litre technical hiking pack with integrated rain cover and adjustable torso fit.',
                'description'       => '<p>The Summit Pro is built for multi-day alpine adventures. Features a suspended mesh back panel for airflow, hip-belt pockets, hydration reservoir sleeve (3L compatible), aluminium frame stays, and a roll-top main compartment with weather seal.</p>',
                'sku'               => 'SPT-BP-001',
                'price'             => 215.00,
                'compare_price'     => 259.00,
                'stock_quantity'    => 30,
                'brand'             => 'Summit Gear',
                'is_featured'       => true,
            ],
            [
                'category'          => 'Sports & Outdoors',
                'name'              => 'TrailGrip Carbon Trekking Poles (Pair)',
                'short_description' => 'Ultra-light 190g carbon fibre poles with ergonomic cork grips and quick-lock system.',
                'description'       => '<p>At 190g per pole, TrailGrip Carbon poles set the benchmark for ultralight trekking. The 100% carbon fibre shaft absorbs vibration better than aluminium. Three-section QuickLock collapses to 63cm for pack attachment.</p>',
                'sku'               => 'SPT-TP-002',
                'price'             => 109.99,
                'compare_price'     => null,
                'stock_quantity'    => 50,
                'brand'             => 'TrailGrip',
                'is_featured'       => false,
            ],

            // ── Beauty & Personal Care ─────────────────────────────────────────
            [
                'category'          => 'Beauty & Personal Care',
                'name'              => 'Lumière Daily SPF50 Moisturiser',
                'short_description' => 'Lightweight daily moisturiser with broad-spectrum SPF50 protection and hyaluronic acid.',
                'description'       => '<p>Formulated by dermatologists, Lumière Daily SPF50 provides invisible broad-spectrum UV protection while deeply hydrating with three molecular weights of hyaluronic acid. Non-comedogenic, fragrance-free, and suitable for all skin types.</p>',
                'sku'               => 'BPC-SK-001',
                'price'             => 42.00,
                'compare_price'     => null,
                'stock_quantity'    => 100,
                'brand'             => 'Lumière Labs',
                'is_featured'       => true,
            ],
            [
                'category'          => 'Beauty & Personal Care',
                'name'              => 'Obsidian Grooming Kit — 5 Piece',
                'short_description' => 'Professional 5-piece grooming set with matte black stainless steel finish.',
                'description'       => '<p>The Obsidian Grooming Kit includes precision nail scissors, cuticle pusher, nail file, blackhead extractor, and tweezers. Each tool is forged from 430-grade stainless steel with a PVD black coating for durability and corrosion resistance. Presented in a full-grain leather roll case.</p>',
                'sku'               => 'BPC-GR-002',
                'price'             => 68.00,
                'compare_price'     => 85.00,
                'stock_quantity'    => 40,
                'brand'             => 'Obsidian Co.',
                'is_featured'       => false,
            ],
        ];

        foreach ($products as $data) {
            $categoryId = $categories[$data['category']] ?? 1;
            unset($data['category']);

            Product::create([
                ...$data,
                'category_id' => $categoryId,
                'slug'        => Str::slug($data['name']),
                'is_active'   => true,
                'views_count' => rand(100, 5000),
            ]);
        }
    }
}
