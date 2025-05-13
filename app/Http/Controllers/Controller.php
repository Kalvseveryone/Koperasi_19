<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Kolektor;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function show($id)
    {
        $kolektor = Kolektor::find($id);
        return response()->json($kolektor);
    }

    public function recordPayment(Request $request)
    {
        // Logika untuk mencatat pembayaran angsuran
        // Misalnya, mencatat tanggal dan jumlah pembayaran
    }
}
