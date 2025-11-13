<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use League\Csv\Reader;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $this->importCSV('danh_sach_san_pham_cong_nghe.csv', 'Điện thoại', 'product-image');
        $this->importCSV('Laptop và tai nghe.csv', 'Laptop / Phụ kiện', 'laptop-va-tai-nghe');
    }

    private function importCSV(string $filename, string $category, string $folder): void
    {
        $path = base_path("database/data/{$filename}");

        if (!file_exists($path)) {
            echo "❌ Không tìm thấy file CSV: {$filename}\n";
            return;
        }

        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();

        foreach ($records as $record) {
            $image = $record['image'] ?? null;

            Product::create([
                'name'        => $record['name'],
                'price'       => $record['price'],
                'description' => $record['description'] ?? '',
                'image'       => $image,
                'category'    => $category,
            ]);
        }

        echo "✅ Nhập xong file: {$filename}\n";
    }
}
