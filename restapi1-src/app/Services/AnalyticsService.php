<?php

namespace App\Services;

use Illuminate\Http\Request;

class AnalyticsService
{
    public function track(Request $request): void
    {
        // Write event to message bus
    }
}
