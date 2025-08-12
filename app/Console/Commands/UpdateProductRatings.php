<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Review;

class UpdateProductRatings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:update-ratings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update rating average and count for all products based on approved reviews';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to update product ratings...');
        
        $products = Product::all();
        $progressBar = $this->output->createProgressBar($products->count());
        $progressBar->start();
        
        $updatedCount = 0;
        
        foreach ($products as $product) {
            $approvedReviews = Review::where('product_id', $product->id)
                                   ->where('is_approved', true)
                                   ->get();
            
            if ($approvedReviews->count() > 0) {
                $averageRating = round($approvedReviews->avg('rating'), 1);
                $ratingCount = $approvedReviews->count();
                
                $product->update([
                    'rating_average' => $averageRating,
                    'rating_count' => $ratingCount
                ]);
                
                $this->line("\nProduct ID {$product->id}: {$ratingCount} reviews, average {$averageRating}");
            } else {
                // No approved reviews
                $product->update([
                    'rating_average' => 0,
                    'rating_count' => 0
                ]);
            }
            
            $updatedCount++;
            $progressBar->advance();
        }
        
        $progressBar->finish();
        
        $this->newLine(2);
        $this->info("Successfully updated ratings for {$updatedCount} products.");
        
        return Command::SUCCESS;
    }
}