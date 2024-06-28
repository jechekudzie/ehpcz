<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\FeeItem;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ExportDatabaseData extends Command
{
    protected $signature = 'export:data';
    protected $description = 'Export FeeItems and Profession Fees data for seeding purposes';

    public function handle()
    {
        $feeItems = FeeItem::with('professions')->get()->map(function ($feeItem) {
            return [
                'fee_category_id' => $feeItem->fee_category_id,
                'currency_id' => $feeItem->currency_id,
                'name' => $feeItem->name,
                'amount' => $feeItem->amount,
                'description' => $feeItem->description,
                'slug' => $feeItem->slug,
                'created_at' => $feeItem->created_at ? $feeItem->created_at->toDateTimeString() : now()->toDateTimeString(),
                'updated_at' => $feeItem->updated_at ? $feeItem->updated_at->toDateTimeString() : now()->toDateTimeString(),
                'professions' => $feeItem->professions->map(function ($profession) {
                    return [
                        'profession_id' => $profession->id,
                        'fee_item_id' => $profession->pivot->fee_item_id,
                        'amount' => $profession->pivot->amount,
                        'created_at' => now()->toDateTimeString(), // Pivot table does not have timestamps by default
                        'updated_at' => now()->toDateTimeString(),
                    ];
                })->toArray()
            ];
        })->toArray();

        // The JSON encoded string will be quite long, consider writing to a file instead of logging
        $jsonString = json_encode($feeItems, JSON_PRETTY_PRINT);
        Log::info($jsonString);

        // Alternatively, save to a .json file in the storage path
        $filePath = storage_path('app/public/fee_items.json');
        file_put_contents($filePath, $jsonString);

        $this->info("Data exported to 'storage/app/public/fee_items.json'.");
    }
}
