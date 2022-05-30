<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Setting;
use DB;

class Main extends Controller
{
    public function index() {
        return view('welcome');
    }

    public function invoiceList() {
        $data['invoiceList'] = Invoice::with('invoiceProducts', 'customers')->paginate(10);
        $data['companyInfo'] = Setting::first();

        return response()->json($data, 200);
    }

    public function searchInvoice(Request $request) {
        $from    = $request->get('date_from');
        $to      = $request->get('date_to');
        $list = Invoice::with('invoiceProducts', 'customers')
                ->whereBetween('created_at', [$from, $to])
                ->get();       
        return response()->json($list,200);
    }

    public function addInvoiceView() {
        $data['products']    = Product::get();
        $data['customers']   = Customer::get();
        $data['companyInfo'] = Setting::first();

        return response()->json($data, 200);
    }

    public function addInvoice(Request $request) {
        
        try{

            \DB::transaction(function() use($request) {
                // dd($request->all());
                $validate = Validator::make($request->all(), [
                    'customer_id'         => 'required', 
                    'total_product_price' => 'required',
                    'status'              => 'required'
                ]);
        
                if(! $validate->fails()) {
                    $total_product_price = $request->total_product_price + $request->vat + $request->tax;
                    
                    $addInvoice = Invoice::create([
                        'customer_id'    => $request->customer_id,
                        'vat'            => $request->vat,
                        'tax'            => $request->tax,
                        'gross_total'    => $total_product_price,
                        'status'         => $request->status
                    ]);

                    InvoiceProduct::create([
                        'invoice_id'  => $addInvoice->id,
                        'product_id'  => $request->product_id,
                        'customer_id' => $request->customer_id,
                        'quantity'    => $request->quantity,
                        'total'       => $request->total_product_price
                    ]);
    
                    // foreach($request->invoice_product as $key => $product) {
                    //     InvoiceProduct::create([
                    //         'invoice_id'  => $addInvoice->id,
                    //         'product_id'  => $request->invoice_product[$key]['product_id'],
                    //         'customer_id' => $request->invoice_product[$key]['customer_id'],
                    //         'quantity'    => $request->invoice_product[$key]['quantity'],
                    //         'total'       => $request->invoice_product[$key]['total']
                    //     ]);
                    // }
                    return response()->json(200);
                }else{
                    return response()->json(['errors' => $validate->errors()],401);
                }
            });
        }catch(\Exception $e) {
            return response()->json(500);
        }
    }

    public function singleInvoice(Request $request, $id) {
        $data['invoice']     = Invoice::with('invoiceProducts', 'customers')->where('id', $id)->first();
        $data['products']    = Product::get();
        $data['customers']   = Customer::get();
        $data['companyInfo'] = Setting::first();
        return response()->json($data,200);
    }

    public function updateInvoice(Request $request, $id) {
        try{
            DB::transaction(function() use($request, $id){
                $validation = Validator::make($request->all(),[
                    'customer_id'         => 'required', 
                    'total_product_price' => 'required',
                    'status'              => 'required'
                ]);
        
                $total_product_price = $request->total_product_price + $request->vat + $request->tax;
        
                if(!$validation->fails()) {
                    $update = Invoice::where('id', $id)->update([
                       'customer_id'    => $request->customer_id,
                       'vat'            => $request->vat,
                       'tax'            => $request->tax,
                       'gross_total'    => $total_product_price,
                       'status'         => $request->status
                    ]);
        
                    foreach($request->invoice_product as $key => $product) {
        
                        $data['invoice_id']  = $id;
                        $data['product_id']  = $request->invoice_product[$key]['product_id'];
                        $data['customer_id'] = $request->invoice_product[$key]['customer_id'];
                        $data['quantity']    = $request->invoice_product[$key]['quantity'];
                        $data['total']       = $request->invoice_product[$key]['total'];
        
                        $update_invoice_product = InvoiceProduct::updateOrCreate([
                            'invoice_id'=> $id, 
                            'product_id'=> $request->invoice_product[$key]['product_id']], $data);
                    }
        
                    if($update) {
                        return response()->json(200);
                    }
                }else{
                    return response()->json(['errors' => $validation->errors()],401);
                }
            });

        }catch(\Exception $e) {
            return response()->json(500);
        }
    }

    public function deleteInvoice(Request $request, $id) {
        try{
            DB::transaction(function() use($id) {
                $get_invoice_product = InvoiceProduct::where('invoice_id', $id)->get(['id']);
                $deleteInvoice = Invoice::destroy(array('id',$id));
                $deleteInvoiceProduct = InvoiceProduct::destroy($get_invoice_product->toArray());
                if($deleteInvoice && $deleteInvoiceProduct) {
                   return response()->json(200);
                }else{
                    return response()->json(401);
                }
            });
        }catch(Exception $e) {
            return response()->json(500);
        }
    }

    public function costCalculator(Request $request) {
        $quantity = 0;
        $product_cost = Product::where('id', $request->get('product_id'))->first();
        if($request->get('quantity') == 'unidentified') {
            $quantity = 0;
        }else{
            $quantity = $request->get('quantity');
        }
       
        $total_cost = $product_cost->rate * $quantity;

        return response()->json($total_cost, 200);
    }
}
