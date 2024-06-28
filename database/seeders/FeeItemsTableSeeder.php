<?php

namespace Database\Seeders;

use App\Models\FeeItem;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FeeItemsTableSeeder extends Seeder
{

    public function run()
    {
        // Make sure to use the correct path to your JSON file.
        $jsonPath = storage_path('app/public/fee_items.json'); // Update the path if needed

        // Check if the file exists before attempting to read
        if (Storage::disk('public')->exists('fee_items.json')) {
            // Get the JSON data from the file
            $jsonData = Storage::disk('public')->get('fee_items.json');
            $feeItemsData = json_decode($jsonData, true);

            foreach ($feeItemsData as $feeItem) {
                // Insert into fee_items table and get the inserted ID
                $feeItemId = DB::table('fee_items')->insertGetId([
                    'fee_category_id' => $feeItem['fee_category_id'],
                    'currency_id' => $feeItem['currency_id'],
                    'name' => $feeItem['name'],
                    'amount' => $feeItem['amount'],
                    'description' => $feeItem['description'],
                    'slug' => $feeItem['slug'],
                    'created_at' => $feeItem['created_at'] ?? Carbon::now(),
                    'updated_at' => $feeItem['updated_at'] ?? Carbon::now(),
                ]);

                // Check if there are any associated professions and insert them
                if (!empty($feeItem['professions'])) {
                    foreach ($feeItem['professions'] as $profession) {
                        DB::table('profession_fees')->insert([
                            'profession_id' => $profession['profession_id'],
                            'fee_item_id' => $feeItemId, // Use the ID from the fee_items insert.
                            'amount' => $profession['amount'],
                            'created_at' => $profession['created_at'] ?? Carbon::now(),
                            'updated_at' => $profession['updated_at'] ?? Carbon::now(),
                        ]);
                    }
                }
            }

            $this->command->info('Fee Items and Profession Fees seeded successfully!');
        } else {
            $this->command->error('JSON file does not exist.');
        }

    }
}
