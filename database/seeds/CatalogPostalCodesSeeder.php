<?php

use App\Models\CatalogPostalCodes;
use Illuminate\Database\Seeder;

class CatalogPostalCodesSeeder extends Seeder
{

    private $total_insert = 0;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = storage_path('app/seeds/catalog_postalcodes.txt');
        $handler = fopen($file, 'r');
        if ($handler) {
            CatalogPostalCodes::truncate();
            $max_block = 5000;
            $block_data = [];
            $block_idx = 0;
            while (($line = fgetcsv($handler, 0, '|')) !== false) {
                $block_idx++;
                $block_data[] = [
                    'cp'         => $line[0],
                    'town_name'  => $line[3],
                    'town_key'   => $line[11],
                    'state_name' => $line[4],
                    'state_key'  => $line[7]
                ];

                if ($block_idx >= $max_block) {
                    $this->insert($block_data);
                    $block_data = [];
                    $block_idx = 0;
                }
            }

            if (count($block_data) > 0) {
                $this->insert($block_data);
                $block_data = [];
            }
            fclose($handler);

            unset($block_data, $block_idx);
        }
    }

    private function insert($data)
    {
        $this->total_insert += count($data);
        echo sprintf('Insert: % 7d / % 7d', count($data), $this->total_insert) . PHP_EOL;
        CatalogPostalCodes::insert($data);
    }
}
