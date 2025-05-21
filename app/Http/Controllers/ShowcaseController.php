<?php

namespace App\Http\Controllers;

use App\Models\Showcase;
use Illuminate\Http\Request;

class ShowcaseController extends Controller
{
    public function index()
    {
        $showcases = Showcase::with('student')->latest()->get();

        // Log data showcases untuk debugging
        \Log::info('Showcases data:', $showcases->toArray());

        return view('showcases.index', compact('showcases'));
    }
}
