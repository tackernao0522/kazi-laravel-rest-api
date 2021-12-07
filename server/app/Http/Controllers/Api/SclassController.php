<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sclass;
use Illuminate\Http\Request;

class SclassController extends Controller
{
    public function index()
    {
        $sclass = Sclass::latest()->get();

        return response()->json($sclass);
    }
}
