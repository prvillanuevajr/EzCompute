<?php

namespace App\Http\Controllers;

use App\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function show(Invoice $invoice)
    {
        $details = $invoice->details;
        return view('invoices.show',compact('invoice','details'));
    }
}
