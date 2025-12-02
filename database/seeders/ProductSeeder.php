<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all active categories
        $categories = Category::where('is_active', true)->get();

        if ($categories->isEmpty()) {
            $this->command->warn('Tidak ada kategori aktif. Silakan buat kategori terlebih dahulu.');
            return;
        }

        // Product data for each category type
        $productsData = [
            'laptop' => [
                ['name' => 'Laptop ASUS ROG Strix G15', 'price' => 15999000, 'original_price' => 18999000, 'description' => 'Laptop gaming dengan processor AMD Ryzen 9, RTX 4060, 16GB RAM, 512GB SSD', 'stock' => 15],
                ['name' => 'Laptop Acer Predator Helios 300', 'price' => 12499000, 'original_price' => 14999000, 'description' => 'Laptop gaming Intel i7, RTX 4050, 16GB RAM, 1TB SSD', 'stock' => 12],
                ['name' => 'Laptop HP Pavilion 15', 'price' => 8999000, 'original_price' => 10999000, 'description' => 'Laptop untuk produktivitas, Intel i5, 8GB RAM, 512GB SSD', 'stock' => 20],
                ['name' => 'Laptop Lenovo ThinkPad E14', 'price' => 11499000, 'original_price' => 13499000, 'description' => 'Laptop bisnis dengan Intel i7, 16GB RAM, 512GB SSD', 'stock' => 18],
                ['name' => 'Laptop Dell XPS 13', 'price' => 18999000, 'original_price' => 21999000, 'description' => 'Laptop premium dengan Intel i7, 16GB RAM, 1TB SSD', 'stock' => 10],
                ['name' => 'Laptop MacBook Air M2', 'price' => 19999000, 'original_price' => 22999000, 'description' => 'Laptop Apple dengan chip M2, 8GB RAM, 256GB SSD', 'stock' => 8],
                ['name' => 'Laptop ASUS ZenBook 14', 'price' => 9999000, 'original_price' => 11999000, 'description' => 'Laptop ultrabook dengan Intel i5, 8GB RAM, 512GB SSD', 'stock' => 15],
                ['name' => 'Laptop MSI Katana 15', 'price' => 13999000, 'original_price' => 16999000, 'description' => 'Laptop gaming dengan Intel i7, RTX 4060, 16GB RAM', 'stock' => 12],
                ['name' => 'Laptop Acer Swift 3', 'price' => 7999000, 'original_price' => 9999000, 'description' => 'Laptop ringan dengan AMD Ryzen 5, 8GB RAM, 512GB SSD', 'stock' => 25],
                ['name' => 'Laptop HP Victus 16', 'price' => 11999000, 'original_price' => 13999000, 'description' => 'Laptop gaming dengan AMD Ryzen 7, RTX 4050, 16GB RAM', 'stock' => 14],
            ],
            'pc' => [
                ['name' => 'PC Gaming Intel i7 RTX 4060', 'price' => 12499000, 'original_price' => 14999000, 'description' => 'PC Gaming dengan Intel i7-13700, RTX 4060, 16GB RAM, 512GB SSD', 'stock' => 10],
                ['name' => 'PC Gaming AMD Ryzen 7 RTX 4070', 'price' => 15999000, 'original_price' => 18999000, 'description' => 'PC Gaming dengan AMD Ryzen 7 7700X, RTX 4070, 32GB RAM, 1TB SSD', 'stock' => 8],
                ['name' => 'PC Workstation Intel Xeon', 'price' => 24999000, 'original_price' => 28999000, 'description' => 'PC Workstation dengan Intel Xeon, 64GB RAM, 2TB SSD', 'stock' => 5],
                ['name' => 'PC All-in-One HP 27"', 'price' => 8999000, 'original_price' => 10999000, 'description' => 'PC All-in-One dengan layar 27", Intel i5, 8GB RAM, 512GB SSD', 'stock' => 12],
                ['name' => 'PC Mini Intel NUC', 'price' => 6999000, 'original_price' => 7999000, 'description' => 'PC Mini dengan Intel i5, 8GB RAM, 256GB SSD', 'stock' => 15],
                ['name' => 'PC Gaming Budget RTX 3050', 'price' => 9999000, 'original_price' => 11999000, 'description' => 'PC Gaming budget dengan Intel i5, RTX 3050, 16GB RAM', 'stock' => 18],
                ['name' => 'PC Gaming AMD Ryzen 5 RTX 3060', 'price' => 10999000, 'original_price' => 12999000, 'description' => 'PC Gaming dengan AMD Ryzen 5 5600X, RTX 3060, 16GB RAM', 'stock' => 12],
                ['name' => 'PC Office Intel i3', 'price' => 4999000, 'original_price' => 5999000, 'description' => 'PC Office dengan Intel i3, 8GB RAM, 256GB SSD', 'stock' => 30],
            ],
            'keyboard' => [
                ['name' => 'Keyboard Mechanical RGB', 'price' => 899000, 'original_price' => 1299000, 'description' => 'Keyboard mechanical dengan switch RGB, full layout', 'stock' => 50],
                ['name' => 'Mouse Wireless Logitech MX Master 3', 'price' => 799000, 'original_price' => 999000, 'description' => 'Mouse wireless premium dengan sensor high precision', 'stock' => 40],
                ['name' => 'Keyboard Wireless Logitech K380', 'price' => 699000, 'original_price' => 899000, 'description' => 'Keyboard wireless compact untuk produktivitas', 'stock' => 45],
                ['name' => 'Mouse Gaming RGB Razer DeathAdder', 'price' => 1299000, 'original_price' => 1599000, 'description' => 'Mouse gaming dengan sensor 20K DPI, RGB lighting', 'stock' => 35],
                ['name' => 'Keyboard Gaming Corsair K70', 'price' => 1999000, 'original_price' => 2299000, 'description' => 'Keyboard gaming mechanical dengan Cherry MX switches', 'stock' => 25],
                ['name' => 'Mouse Pad Gaming RGB', 'price' => 299000, 'original_price' => 399000, 'description' => 'Mouse pad gaming dengan RGB lighting, ukuran besar', 'stock' => 60],
                ['name' => 'Keyboard Mechanical Keychron K2', 'price' => 1499000, 'original_price' => 1799000, 'description' => 'Keyboard mechanical wireless dengan keycaps PBT', 'stock' => 30],
                ['name' => 'Mouse Wireless Logitech G Pro', 'price' => 999000, 'original_price' => 1199000, 'description' => 'Mouse gaming wireless dengan sensor Hero 25K', 'stock' => 38],
            ],
            'game' => [
                ['name' => 'PlayStation 5 Console', 'price' => 7999000, 'original_price' => 8999000, 'description' => 'Console gaming PlayStation 5 dengan 825GB SSD', 'stock' => 15],
                ['name' => 'Xbox Series X', 'price' => 7499000, 'original_price' => 8499000, 'description' => 'Console gaming Xbox Series X dengan 1TB SSD', 'stock' => 12],
                ['name' => 'Nintendo Switch OLED', 'price' => 4999000, 'original_price' => 5999000, 'description' => 'Console gaming portable dengan layar OLED 7"', 'stock' => 20],
                ['name' => 'Steam Deck 512GB', 'price' => 8999000, 'original_price' => 9999000, 'description' => 'Handheld gaming PC dengan storage 512GB', 'stock' => 8],
                ['name' => 'Controller PS5 DualSense', 'price' => 899000, 'original_price' => 1099000, 'description' => 'Controller wireless untuk PlayStation 5', 'stock' => 40],
                ['name' => 'Controller Xbox Wireless', 'price' => 799000, 'original_price' => 999000, 'description' => 'Controller wireless untuk Xbox Series X/S', 'stock' => 35],
            ],
            'printer' => [
                ['name' => 'Printer Epson L3210', 'price' => 2499000, 'original_price' => 2999000, 'description' => 'Printer all-in-one dengan sistem tinta infus', 'stock' => 25],
                ['name' => 'Printer Canon Pixma G3010', 'price' => 1899000, 'original_price' => 2299000, 'description' => 'Printer all-in-one dengan sistem tinta infus', 'stock' => 30],
                ['name' => 'Printer HP LaserJet Pro', 'price' => 2999000, 'original_price' => 3499000, 'description' => 'Printer laser monochrome untuk kantor', 'stock' => 20],
                ['name' => 'Printer Canon PIXMA TS3420', 'price' => 999000, 'original_price' => 1299000, 'description' => 'Printer all-in-one inkjet untuk rumah', 'stock' => 40],
                ['name' => 'Scanner Epson V39', 'price' => 1499000, 'original_price' => 1799000, 'description' => 'Scanner flatbed dengan resolusi tinggi', 'stock' => 15],
            ],
            'hp' => [
                ['name' => 'Samsung Galaxy Tab S9', 'price' => 8999000, 'original_price' => 10999000, 'description' => 'Tablet Android dengan layar 11", S Pen included', 'stock' => 12],
                ['name' => 'iPad Air 5th Gen', 'price' => 9999000, 'original_price' => 11999000, 'description' => 'Tablet Apple dengan chip M1, 64GB storage', 'stock' => 10],
                ['name' => 'Samsung Galaxy S24 Ultra', 'price' => 17999000, 'original_price' => 19999000, 'description' => 'Smartphone flagship dengan S Pen, 256GB', 'stock' => 8],
                ['name' => 'iPhone 15 Pro Max', 'price' => 19999000, 'original_price' => 22999000, 'description' => 'Smartphone Apple dengan chip A17 Pro, 256GB', 'stock' => 6],
                ['name' => 'Xiaomi Pad 6', 'price' => 4999000, 'original_price' => 5999000, 'description' => 'Tablet Android dengan layar 11", 128GB', 'stock' => 20],
            ],
            'audio' => [
                ['name' => 'Speaker Bluetooth JBL Flip 6', 'price' => 799000, 'original_price' => 999000, 'description' => 'Speaker portable dengan bass yang kuat', 'stock' => 50],
                ['name' => 'Earphone Gaming HyperX Cloud II', 'price' => 599000, 'original_price' => 750000, 'description' => 'Headset gaming dengan microphone detachable', 'stock' => 45],
                ['name' => 'Headset Gaming RGB', 'price' => 1899000, 'original_price' => 2299000, 'description' => 'Headset gaming dengan RGB lighting, 7.1 surround', 'stock' => 30],
                ['name' => 'Speaker Bluetooth Sony SRS-XB33', 'price' => 2999000, 'original_price' => 3499000, 'description' => 'Speaker portable dengan Extra Bass', 'stock' => 25],
                ['name' => 'Earbuds AirPods Pro 2', 'price' => 3999000, 'original_price' => 4499000, 'description' => 'Earbuds wireless dengan Active Noise Cancellation', 'stock' => 20],
                ['name' => 'Headset Sony WH-1000XM5', 'price' => 5999000, 'original_price' => 6999000, 'description' => 'Headset wireless dengan noise cancellation premium', 'stock' => 15],
            ],
            'aksesoris' => [
                ['name' => 'Webcam Logitech C920', 'price' => 1299000, 'original_price' => 1599000, 'description' => 'Webcam HD 1080p dengan autofocus', 'stock' => 40],
                ['name' => 'USB Hub 7-Port', 'price' => 199000, 'original_price' => 250000, 'description' => 'USB Hub dengan 7 port USB 3.0', 'stock' => 60],
                ['name' => 'Kabel HDMI 2.1 3 Meter', 'price' => 149000, 'original_price' => 199000, 'description' => 'Kabel HDMI untuk 4K 120Hz', 'stock' => 80],
                ['name' => 'Stand Laptop Adjustable', 'price' => 299000, 'original_price' => 399000, 'description' => 'Stand laptop dengan tinggi adjustable', 'stock' => 50],
                ['name' => 'Cooling Pad Laptop RGB', 'price' => 399000, 'original_price' => 499000, 'description' => 'Cooling pad dengan 5 fan dan RGB lighting', 'stock' => 45],
                ['name' => 'Kamera Webcam Logitech Brio', 'price' => 2499000, 'original_price' => 2999000, 'description' => 'Webcam 4K dengan HDR dan autofocus', 'stock' => 20],
                ['name' => 'USB-C Hub Multiport', 'price' => 499000, 'original_price' => 699000, 'description' => 'USB-C Hub dengan HDMI, USB 3.0, dan card reader', 'stock' => 35],
            ],
        ];

        $totalProducts = 0;

        foreach ($categories as $category) {
            $categorySlug = $category->slug;
            $categoryName = strtolower($category->name);

            // Find matching products data
            $products = [];

            // Try to match by slug first
            if (isset($productsData[$categorySlug])) {
                $products = $productsData[$categorySlug];
            } else {
                // Try to match by category name keywords
                foreach ($productsData as $key => $data) {
                    if (str_contains($categoryName, $key) || str_contains($key, $categoryName)) {
                        $products = $data;
                        break;
                    }
                }
            }

            // If no match found, use generic products
            if (empty($products)) {
                $products = [
                    ['name' => $category->name . ' - Produk 1', 'price' => 1999000, 'original_price' => 2499000, 'description' => 'Produk berkualitas tinggi dari kategori ' . $category->name, 'stock' => 20],
                    ['name' => $category->name . ' - Produk 2', 'price' => 2999000, 'original_price' => 3499000, 'description' => 'Produk premium dari kategori ' . $category->name, 'stock' => 15],
                    ['name' => $category->name . ' - Produk 3', 'price' => 1499000, 'original_price' => 1999000, 'description' => 'Produk terjangkau dari kategori ' . $category->name, 'stock' => 25],
                ];
            }

            // Create products for this category
            foreach ($products as $productData) {
                // Check if product already exists
                $existingProduct = Product::where('name', $productData['name'])->first();

                if (!$existingProduct) {
                    // Generate unique slug
                    $slug = Str::slug($productData['name']);
                    $counter = 1;
                    while (Product::where('slug', $slug)->exists()) {
                        $slug = Str::slug($productData['name']) . '-' . $counter;
                        $counter++;
                    }

                    // Use Unsplash images based on category
                    $imageUrls = [
                        'laptop' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=600&h=600&fit=crop',
                        'pc' => 'https://images.unsplash.com/photo-1587825140708-dfaf72ae4b04?w=600&h=600&fit=crop',
                        'keyboard' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=600&h=600&fit=crop',
                        'game' => 'https://images.unsplash.com/photo-1606144042614-b2417e99c4e3?w=600&h=600&fit=crop',
                        'printer' => 'https://images.unsplash.com/photo-1535585209827-a15fcdbc4c2d?w=600&h=600&fit=crop',
                        'hp' => 'https://images.unsplash.com/photo-1525547719571-a2d4ac8945e2?w=600&h=600&fit=crop',
                        'audio' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600&h=600&fit=crop',
                        'aksesoris' => 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=600&h=600&fit=crop',
                    ];

                    $imageUrl = $imageUrls[$categorySlug] ?? 'https://images.unsplash.com/photo-1525547719571-a2d4ac8945e2?w=600&h=600&fit=crop';

                    Product::create([
                        'category_id' => $category->id,
                        'name' => $productData['name'],
                        'slug' => $slug,
                        'description' => $productData['description'],
                        'image' => $imageUrl,
                        'price' => $productData['price'],
                        'original_price' => $productData['original_price'],
                        'stock' => $productData['stock'],
                        'is_active' => true,
                        'is_featured' => rand(0, 1) == 1, // Random featured
                        'sort_order' => 0,
                    ]);

                    $totalProducts++;
                }
            }
        }

        $this->command->info("Berhasil membuat {$totalProducts} produk dummy untuk semua kategori!");
    }
}
