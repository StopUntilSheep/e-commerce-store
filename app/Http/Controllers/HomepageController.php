<?php

namespace App\Http\Controllers;

class HomepageController extends BaseController
{
    public function index()
    {
        return $this->renderWithLayoutData('Homepage', [], [
            'with_categories' => true,
            'with_brands' => true,
            'with_featured' => true,
            'with_new_arrivals' => true,
        ]);
    }
}
