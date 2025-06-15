<?php

namespace App\Http\Controllers;
use App\Models\Sale;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $sales = Sale::all();
        // dd($sales);  // Tambahkan ini untuk debugging

        return view('transactions.index', compact('sales'));
    }

}
