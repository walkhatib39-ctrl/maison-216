<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class SeoController extends Controller
{
    public function index()
    {
        return view('admin.seo.index');
    }
}
