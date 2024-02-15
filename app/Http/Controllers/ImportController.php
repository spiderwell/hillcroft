<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Product;
use Illuminate\Support\Collection;
use App\Mail\ImportReport;
use Illuminate\Support\Facades\Mail;

class ImportController extends Controller
{
    /**
     * import form
     */
    public function import(): View
    {
        return view('import');
    }

    /**
     * import processing
     */
    public function importProcess(Request $request): View
    {
        $file = $request->file('file');
        $xml = new \SimpleXMLElement($file->getRealPath(), null, true);
        $collection = collect();

        foreach ($xml->ExportData as $data) {
            $dataArray = json_decode(json_encode($data), true);
            $product = new Product();
            $product->fill($dataArray);
            $product->save();
            $collection->push($product);
        }
        
        $productNames = $collection->reject(function ($product) {
            return $product->stock != 0;
        })
        ->map(function ($product) {
            return $product->name;
        });
        
        Mail::to('Someone@hillcroftsupplies.com')->send(new ImportReport($productNames)); 
        
        return view('import', ['products' => $collection]);
    }

}
