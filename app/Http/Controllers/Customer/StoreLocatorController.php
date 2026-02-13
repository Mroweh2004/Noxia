<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class StoreLocatorController extends Controller
{
    public function index(): View
    {
        return view('customer.store.index');
    }

    public function map(): View
    {
        return view('customer.store.map');
    }
}
