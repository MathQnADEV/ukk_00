<?php

namespace App\Http\Controllers;

use App\Models\transactionDetail;
use App\Models\transactions;
use Illuminate\Http\Request;

class TransactionDetailController extends Controller
{
    public function show($id)
    {
        $transaction = transactions::find($id);
        $transaction_detail = transactionDetail::whereTransactionId($id)->get();
        // ddd($transaction_detail);
        return view("pages.transactions.invoice", compact("transaction", "transaction_detail"));
    }
    public function store(Request $request)
    {
        $product_id = $request->product_id;
        $transaction_id = $request->transaction_id;
        $td  = transactionDetail::whereProductId($product_id)->whereTransactionId($transaction_id)->first();
        $transaction = transactions::find($transaction_id);
        if (!$td) {
            $data = [
                'transaction_id' => $request->transaction_id,
                'product_id' => $request->product_id,
                'product_name' => $request->product_name,
                'qty' => $request->qty,
                'subtotal' => $request->subtotal
            ];
            TransactionDetail::create($data);

            $dt = [
                'total_harga' =>  $request->subtotal + $transaction->total_harga,
            ];

            $transaction->update($dt);
        } else {
            $data = [
                'qty' => $td->qty + $request->qty,
                'subtotal' => $td->subtotal + $request->subtotal
            ];
            $td->update($data);
            $dt = [
                'total_harga' =>  $request->subtotal + $transaction->total_harga,
            ];

            $transaction->update($dt);
        }

        return redirect('/transaction/' . $transaction_id . '/edit');
    }

    public function destroy($id)
    {
        $transaction_detail = transactionDetail::find($id);

        $transaction = transactions::find($transaction_detail->transaction_id);
        $data = [
            'total_harga' => $transaction->total_harga - $transaction_detail->subtotal,
        ];

        $transaction->update($data);
        $transaction_detail->delete();

        return redirect()->back();
    }
}
