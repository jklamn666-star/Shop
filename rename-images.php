<?php

use Illuminate\Support\Str;

require __DIR__ . '/vendor/autoload.php';

$folders = [
    'public/product-image' => 'database/data/danh_sach_san_pham_cong_nghe.csv',
    'public/laptop-va-tai-nghe' => 'database/data/Laptop và tai nghe.csv',
];

foreach ($folders as $folder => $csvPath) {
    if (!file_exists($csvPath)) {
        echo "Không tìm thấy file CSV: $csvPath\n";
        continue;
    }

    $csv = fopen($csvPath, 'r');
    $headers = fgetcsv($csv);

    $nameIndex = array_search('name', $headers);
    if ($nameIndex === false) {
        echo "Không tìm thấy cột 'name' trong $csvPath\n";
        continue;
    }

    while (($row = fgetcsv($csv)) !== false) {
        $productName = $row[$nameIndex];
        $slug = Str::slug($productName);

        // Tìm file khớp tên gốc (gần đúng)
        $files = scandir($folder);
        foreach ($files as $file) {
            if (str_contains(strtolower($file), strtolower($productName))) {
                $ext = pathinfo($file, PATHINFO_EXTENSION);
                $newName = "{$slug}.{$ext}";
                $oldPath = "{$folder}/{$file}";
                $newPath = "{$folder}/{$newName}";

                if (!file_exists($newPath)) {
                    rename($oldPath, $newPath);
                    echo "Đã đổi tên: $file → $newName\n";
                } else {
                    echo "Bỏ qua (đã tồn tại): $newName\n";
                }

                break;
            }
        }
    }

    fclose($csv);
}

echo "✅ Đã hoàn tất đổi tên tất cả ảnh.\n";
