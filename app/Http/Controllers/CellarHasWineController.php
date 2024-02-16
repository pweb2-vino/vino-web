<?php

namespace App\Http\Controllers;

use App\Models\CellarHasWine;
use App\Models\Cellar;
use App\Models\Wine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CellarHasWineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function collection()
    {
        $collection = [];
        $wines = Auth::user()->wine;
        $cellars = Auth::user()->cellar;
        foreach($cellars as $cellar) {
            foreach($cellar->cellarHasWines as $wine) {
                if(array_key_exists($wine->wine_id, $collection)) {
                    $collection[$wine->wine_id]['quantities']['totalQty'] += $wine->quantity;
                    $collection[$wine->wine_id]['quantities']['perCellar'][] = ['cellar' => $wine->cellar, 'qty'=>$wine->quantity];
                } else {
                    $collection[$wine->wine_id] = [
                        'wine'=> $wine->wine,
                        'quantities' => [
                            'perCellar' => [['cellar' => $wine->cellar, 'qty'=>$wine->quantity]],
                            'totalQty' => $wine->quantity,
                        ]
                    ];
                }
            }
        }
        return Inertia::render('CollectionView', compact('collection'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Cellar $cellar) {
        $collection = [];
        foreach($cellar->cellarHasWines as $wine) {
            $collection[] = ['wine' => $wine->wine, 'qty' => $wine->quantity];
        }
        return Inertia::render('Cellar/CellarWinesView', compact('collection'));
    }

    /**
     * Add one bottle 
     */
    public function addOne(Cellar $cellar, Wine $wine) {
        $target = CellarHasWine::find([$cellar->id, $wine->id]);
        $newQuantity = $target->quantity + 1;
        $target->update([
            'cellar_id'=> $cellar->id,
            'wine_id' => $wine->id,
            'quantity' => $newQuantity
        ]);
    }
    /**
     * Remove one bottle
     */
    public function removeOne(Cellar $cellar, Wine $wine) {
        $target = CellarHasWine::find([$cellar->id, $wine->id]);
        $newQuantity = $target->quantity -1;
        if($newQuantity >= 0) {
            $target->update([
                'cellar_id'=> $cellar->id,
                'wine_id' => $wine->id,
                'quantity' => $newQuantity
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Wine $wine)
    {   
        $cellars = Auth::user()->cellar;
        return Inertia::render('CellarWine/CreateView', compact('cellars', 'wine'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $target = CellarHasWine::find([$request->cellar_id, $request->wine_id]);
        if($target) {
            $newQuantity = $request->quantity + $target->quantity;
            $target->update([
                'cellar_id'=> $request->cellar_id,
                'wine_id' => $request->wine_id,
                'quantity'=> $newQuantity
            ]);
        } else {
            CellarHasWine::create([
                'cellar_id'=>$request->cellar_id,
                'wine_id' => $request->wine_id,
                'quantity'=> $request->quantity
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CellarHasWine  $cellarHasWine
     * @return \Illuminate\Http\Response
     */
    public function show(CellarHasWine $cellarHasWine)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CellarHasWine  $cellarHasWine
     * @return \Illuminate\Http\Response
     */
    public function edit(CellarHasWine $cellarHasWine)
    {
        //Ajouter les btn delete et changer la quantité sur chaque bouteille + btn edit si bouteille custom
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CellarHasWine  $cellarHasWine
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CellarHasWine $cellarHasWine)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CellarHasWine  $cellarHasWine
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cellar $cellar, Wine $wine)
    {
        $cellarHasWine = new CellarHasWine;
        $cellarHasWine::where('cellar_id', $cellar->id)->where('wine_id', $wine->id)->delete();
    }
}
