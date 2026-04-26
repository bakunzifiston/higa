<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Reporting\Services\DashboardService;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct(private readonly DashboardService $dashboardService)
    {
    }

    public function index()
    {
        return response()->json([
            'data' => $this->dashboardService->build(),
        ]);
    }
}
