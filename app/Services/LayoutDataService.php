<?php

namespace App\Services;

use Illuminate\Support\Facades\Route;

class LayoutDataService
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function getCommonLayoutData($options = [])
    {
        $data = [];

        if ($options['with_categories'] ?? false) {
            $data['categories'] = $this->productService->getCategories(
                $options['categories_limit'] ?? 6
            );
        }

        if ($options['with_brands'] ?? false) {
            $data['brands'] = $this->productService->getBrands();
        }

        if ($options['with_featured'] ?? false) {
            $data['featuredProducts'] = $this->productService->getFeaturedProducts(
                $options['featured_limit'] ?? 8
            );
        }

        if ($options['with_new_arrivals'] ?? false) {
            $data['newArrivals'] = $this->productService->getNewArrivals(
                $options['new_arrivals_limit'] ?? 12
            );
        }

        // Authentication routes
        $data['canLogin'] = Route::has('login');
        $data['canRegister'] = Route::has('register');

        return $data;
    }
}
