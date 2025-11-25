<?php

namespace App\Http\Controllers;

use App\Models\TrackingLayanan;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackingLayananController extends Controller
{
    public function index()
    {
        $tracking = TrackingLayanan::with('layanan')->paginate(10);
        return view('tracking_layanan.index', compact('tracking'));
    }

    public function create()
    {
        $this->authorize('isAdmin');
        $layanan = Layanan::all();
        return view('tracking_layanan.create', compact('layanan'));
    }

    public function store(Request $request)
    {
        $this->authorize('isAdmin');
        $request->validate([
            'layanan_id'=>'required|exists:layanan,id',
            'status'=>'required'
        ]);

        TrackingLayanan::create([
            'layanan_id'=>$request->layanan_id,
            'status'=>$request->status,
            'keterangan'=>$request->keterangan,
            'updated_by'=>Auth::id(),
        ]);

        return redirect()->route('tracking_layanan.index')->with('success','Tracking layanan ditambahkan.');
    }

    public function show(TrackingLayanan $tracking_layanan)
    {
        return view('tracking_layanan.show', compact('tracking_layanan'));
    }

    public function edit(TrackingLayanan $tracking_layanan)
    {
        $this->authorize('isAdmin');
        return view('tracking_layanan.edit', compact('tracking_layanan'));
    }

    public function update(Request $request, TrackingLayanan $tracking_layanan)
    {
        $this->authorize('isAdmin');
        $tracking_layanan->update($request->all());
        return redirect()->route('tracking_layanan.index')->with('success','Tracking diperbarui.');
    }

    public function destroy(TrackingLayanan $tracking_layanan)
    {
        $this->authorize('isAdmin');
        $tracking_layanan->delete();
        return redirect()->route('tracking_layanan.index')->with('success','Data dihapus.');
    }
}
