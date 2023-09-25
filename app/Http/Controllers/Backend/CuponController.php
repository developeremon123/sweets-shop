<?php

namespace App\Http\Controllers\Backend;

use App\Models\Cupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\CuponStoreRequest;
use App\Http\Requests\CuponUpdateRequest;

class CuponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cupons = Cupon::latest('id')
        ->select(['id','cuponName','discount_amount','validity_till','updated_at'])
        ->paginate(10);
        $delcupons = Cupon::onlyTrashed()
        ->latest('id')
        ->select(['id','cuponName','discount_amount','validity_till','updated_at'])
        ->paginate(10);
        return view('backend.pages.cupon.index',compact('cupons','delcupons'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.cupon.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CuponStoreRequest $request)
    {
        $cupons = Cupon::create([
            'cuponName' => $request->cuponName,
            'discount_amount' => $request->discount_amount,
            'minimum_purchase_amount' => $request->minimum_purchase_amount,
            'validity_till' => $request->validity_till,
        ]);

        if ($cupons) {
            Toastr::success('Store new cupon');
            return redirect()->route('admin.cupon.index');
        }else{
            Toastr::errorr('Cupon not store! Somethings went wrong');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cupons = Cupon::find($id);
        return view('backend.pages.cupon.edit',compact('cupons'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CuponUpdateRequest $request, string $id)
    {
        $cupons = Cupon::find($id);
        $cupons->update([
            'cuponName' => $request->cuponName,
            'discount_amount' => $request->discount_amount,
            'minimum_purchase_amount' => $request->minimum_purchase_amount,
            'validity_till' => $request->validity_till,
            'is_active' => $request->filled('is_active'),
        ]);
        if ($cupons) {
            Toastr::success('Cupon Update successfully');
            return redirect()->route('admin.cupon.index');
        }else{
            Toastr::errorr('Cupon not update! Somethings went wrong');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cupons = Cupon::find($id)->delete();
        if ($cupons) {
            Toastr::success('Cupon trashed');
            return redirect()->back();
        }else{
            Toastr::errorr('Cupon not trashed! Somethings went wrong');
            return redirect()->back();
        }
    }

    public function restore($id){
        $delcupons = Cupon::onlyTrashed()
        ->find($id)
        ->restore();
        if ($delcupons) {
            Toastr::success("Cupon restored");
            return back();
        }else {
            Toastr::error("Cupon not restored! Somethings went worng");
            return back();
        }
    }

    public function delete($id)
    {
        $delcupon = Cupon::onlyTrashed()->find($id);
        if ($delcupon) {
            $delcupon->forceDelete();
            Toastr::success("Cupon permanently deleted");
        } else {
            Toastr::error("Cupon not found or already deleted");
        }
    
        return back();
    }
}
