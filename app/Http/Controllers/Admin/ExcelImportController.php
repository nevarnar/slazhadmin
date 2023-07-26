<?php

namespace App\Http\Controllers\Admin;

use App\Models\Division;
use App\Models\Township;
use Illuminate\Http\Request;
use App\Imports\CountryImport;
use App\Imports\DivisionsImport;
use App\Imports\TownshipsImport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Schema;
use App\Http\Actions\NameTranslation\NameSaving;



class ExcelImportController extends Controller
{
    public function importTownship(Request $request){
        Schema::disableForeignKeyConstraints();
        DB::table('townships')->truncate();
        Schema::enableForeignKeyConstraints();
        
        $this->import(new TownshipsImport(),$request->sheet);
        responseStatus('Import Successfully',200);
    }
    public function importDivision(Request $request){
        $to_delete_townships=Township::all();
        foreach($to_delete_townships as $t){
            // Schema::disableForeignKeyConstraints();
            (new NameSaving())->detachName($t,['mm','en']);
            $t->delete();
            // Schema::enableForeignKeyConstraints();
        }
        $to_delete_divisions=Division::all();
        foreach($to_delete_divisions as $d){
            (new NameSaving())->detachName($d,['mm','en']);
            $d->delete();
        }
        Schema::disableForeignKeyConstraints();
        DB::table('divisions')->truncate();
        Schema::enableForeignKeyConstraints();
        $this->import(new DivisionsImport(),$request->sheet);
        responseStatus('Import Successfully',200);
    }
    public function importCountry(Request $request){
        $this->import(new CountryImport(),$request->sheet);
        responseStatus('Import Successfully',200);
    }
    
    protected function import($import,$file){
        Excel::import($import, $file);
    }
}
