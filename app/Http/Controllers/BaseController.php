<?php

namespace App\Http\Controllers;

use App\Services\LayoutDataService;
use Inertia\Inertia;

abstract class BaseController extends Controller
{
    protected $layoutDataService;

    public function __construct(LayoutDataService $layoutDataService)
    {
        $this->layoutDataService = $layoutDataService;
    }

    protected function renderWithLayoutData($component, $pageData = [], $layoutOptions = [])
    {
        $layoutData = $this->layoutDataService->getCommonLayoutData($layoutOptions);
        
        return Inertia::render($component, array_merge($pageData, $layoutData));
    }
}
