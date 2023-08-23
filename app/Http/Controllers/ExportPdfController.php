<?php

namespace App\Http\Controllers;

use App\Models\export_pdf;
use Illuminate\Http\Request;
use PDF;

class ExportPdfController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($param)
    {
        // สร้าง pdf
        $pdf = PDF::loadView('export-pdf', ['product' => $param]);
        return $pdf->stream('document.pdf');
        // return view('export-pdf', ['product' => $param]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(export_pdf $export_pdf)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(export_pdf $export_pdf)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, export_pdf $export_pdf)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(export_pdf $export_pdf)
    {
        //
    }
}
