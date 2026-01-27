<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class SeoController extends Controller
{
    /**
     * Placeholder SEO management page (V1).
     */
    public function index()
    {
        return view('admin.seo.index');
    }
}
