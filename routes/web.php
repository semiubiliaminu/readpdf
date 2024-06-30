<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;
use TCPDF;

Route::get('/', function () {
    return view('index');
});


Route::get('/upload', function () {
    return view('upload');
});

Route::post('/pdfparse', function (Request $request) {

    // dd($request->url());

    // dd($request->input('pdf'));




    $validate = $request->validate([
        'pdf' => 'required|max:2048'
    ]);

    // dd($_FILES);
    // dd($request->file('pdf')->getErrorMessage());
    

    if ($request->hasFile('pdf')) {
        //path to the image on client system
        $filePath = $request->file('pdf')->getRealPath();
        //get the image
        $image = $request->file('pdf');
        //get the real name
        $name = $request->file('pdf')->getClientOriginalName();

        
        // Using smalot/pdfparser for basic text extraction
        $parser = new Parser();
        // $pdf = $parser->parseFile($filePath);
        $pdf = $parser->parseFile($filePath);
        $text = $pdf->getText();

        // dd($text);
        dd();

        // Use TCPDF to handle more complex PDF features if needed
        $tcpdf = new TCPDF();
        $tcpdf->setSourceFile($filePath);
        $pageCount = $tcpdf->getNumPages(); //setSourceFile($filePath);

        // Process each page using TCPDF if necessary
        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $pageId = $tcpdf->importPage($pageNo);
            $tcpdf->AddPage();
            $tcpdf->useTemplate($pageId);
            // Additional processing for each page
        }
    }

    // Here you can process the extracted text and/or handle more complex structures


    // dd($request);

    // if($request->input('pdf')){
    //     dd($request->file('entry_level_data_analysis.pdf'));
    // }

    //dd($request->file($request->getContent(true)));
    // $file = $request->file('pdf');
    // $filePath = $file->getPathname();
    // $fileName = $file->getClientOriginalName();
    // $filePath = $file->store('uploads', 'public');

    // if($filePath){
    //     dd("File stored");
    // }

    // // Using smalot/pdfparser for basic text extraction
    // $parser = new Parser();
    // // $pdf = $parser->parseFile($filePath);
    // $pdf = $parser->parseFile($filePath);
    // $text = $pdf->getText();

    // // Use TCPDF to handle more complex PDF features if needed
    // $tcpdf = new TCPDF();
    // $tcpdf->setSourceFile($filePath);
    // $pageCount = $tcpdf->setSourceFile($filePath);

    // // Process each page using TCPDF if necessary
    // for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
    //     $pageId = $tcpdf->importPage($pageNo);
    //     $tcpdf->AddPage();
    //     $tcpdf->useTemplate($pageId);
    //     // Additional processing for each page
    // }

    // // Here you can process the extracted text and/or handle more complex structures
    dd($text);
    // return view('result', ['text' => $text]);

    // dd("not haeppend");

});