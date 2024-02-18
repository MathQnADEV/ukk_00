<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\transactionDetail;
use App\Models\transactions;
use App\Models\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    public function index(Request $request)
    {
        // $transactions = transactions::paginate(10);
        $transactions = transactions::with('user')
        ->when($request->name, function ($query, $name) {
            return $query->where("name", "like", "%" . $name . "%");
        })
            ->paginate(10);

        $users = User::get();

        return view("pages.transactions.index", compact("transactions", "users"));
    }

    public function create(Request $request)
    {
        $data = [
            "user_id" => auth()->user()->id,
            "total_harga" => 0
        ];
        $transaction =  transactions::create($data);
        return redirect()->route("transaction.edit", $transaction);
    }

    public function edit(Request $request, $id)
    {
        $products = Product::all();
        $transaction_detail = transactionDetail::whereTransactionId($id)->paginate(10);
        $transaction = transactions::findOrFail($id);

        $dibayarkan = $request->dibayarkan;
        $kembalian = $dibayarkan - $transaction->total_harga;

        if ($request->produk_id) {
            $act = $request->act;
            $p_detail = Product::find($request->produk_id);
            $qty = $request->qty;
            if ($act == 'min') {
                if ($qty <= 1) {
                    $qty = 1;
                } else {
                    $qty = $qty - 1;
                }
            } else {
                $qty = $qty + 1;
            }
            $subtotal = 0;
            if ($p_detail) {
                $subtotal = $qty * $p_detail->price;
            }
            return view("pages.transactions.create", compact("products", "p_detail", "qty", 'subtotal', 'transaction', 'transaction_detail', 'kembalian'));
        }
        return view("pages.transactions.create", compact("products", 'transaction', 'transaction_detail', 'kembalian'));
    }
}
