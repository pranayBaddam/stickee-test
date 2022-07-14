<?php

namespace App\Http\Controllers;

use App\Actions\WidgetPacks;
use Illuminate\Http\Request;

class WidgetController extends Controller
{
    public function __invoke()
    {
        $objWidgetPacks = new WidgetPacks([250, 500, 1000, 2000, 5000]);
        return $objWidgetPacks->setPack(750)->calculateMinimumWidgetsPacks(502);
    }
}
