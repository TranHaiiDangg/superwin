<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\Category;

class CategoryComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        // Load main categories (parent_id = null) with their children
        $mainCategories = Category::with(['children' => function($query) {
            $query->active()->orderBy('sort_order');
        }])
        ->active()
        ->root()
        ->orderBy('sort_order')
        ->get();

        // Add emoji to each category
        $mainCategories->each(function($category) {
            $category->emoji = $this->extractEmoji($category->description);
        });

        $view->with('mainCategories', $mainCategories);
    }

    /**
     * Extract emoji from description
     */
    private function extractEmoji(?string $description): string
    {
        if (!$description) {
            return '📦';
        }

        // Extract first emoji from description
        preg_match('/[\x{1F600}-\x{1F64F}]|[\x{1F300}-\x{1F5FF}]|[\x{1F680}-\x{1F6FF}]|[\x{1F1E0}-\x{1F1FF}]|[\x{2600}-\x{26FF}]|[\x{2700}-\x{27BF}]/u', $description, $matches);

        return $matches[0] ?? '📦';
    }
}
