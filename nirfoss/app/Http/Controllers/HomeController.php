<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MasterCSV;
use App\Models\CsvDB;
use App\Models\CsvToTable;
use Illuminate\Support\Facades\Storage;
use File;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['table'] = CsvToTable::get();
        return view('home', $data);
    }

    public function AddTable()
    {
        return view('add_table');
    }

    public function AddTableProcess(Request $request)
    {
        // dd($request);
        $dataColumn = MasterCSV::get();
        $sql = "CREATE TABLE `" . DB::connection()->getDatabaseName() . "`.`" . $request->table_name . "` (`id_" . $request->table_name . "` INT NOT NULL AUTO_INCREMENT, ";

        // dd($request);

        foreach ($dataColumn as $value) {
            $sql .= " `" . $value->col_table_name . "` " . $value->type . ", ";
        }

        foreach ($request->col_table_name as $value) {
            $sql .= " `" . $value . "` INT NOT NULL, ";
        }

        $sql .= " `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY  (`id_" . $request->table_name . "`)) ENGINE = InnoDB";

        
        $id = CsvToTable::create([
            'table_name' => $request->table_name
        ]);
        
        foreach ($request->col_table_name as $key => $value) {
            CsvDB::create([
                'id_table' => $id->id,
                'csv_col_name' => $request->col_csv_name[$key],
                'csv_col_index' => $request->col_csv_index[$key],
                'table_col_name' => $value,
            ]);
        }

        DB::select($sql);

        return redirect()->route('home');
    }

    public function AddMasterCsv()
    {
        $data['csv'] = MasterCSV::get();
        return view('master_csv', $data);
    }

    public function AddMasterCsvProcess(Request $request)
    {
        MasterCSV::create([
            'col_table_name' => $request->col_table_name,
            'col_csv_name' => $request->col_csv_name,
            'col_csv_index' => $request->col_csv_index
        ]);

        return back();
    }

    public function ImportCsv(Request $request)
    {
        if ($request->hasFile('csv')) {
            $fileName = $request->file('csv')->getClientOriginalName();
            $file = fopen($request->file('csv'), "r");

            $name = explode('_', $fileName);
            $name = str_replace(' ', '_', strtolower($name[0]));

            $sql = "INSERT INTO `" . $name . "`, ";
            $colSql = '(';
            $valSql = '(';

            $columnMaster = MasterCSV::get();
            $columnCustom = CsvDB::get();

            while (($column = fgetcsv($file, 10000, ",")) !== false) {
                // print_r($column);
                foreach ($columnMaster as $key => $value) {
                    if ($value->type === "DATE") {
                        $colSql .= " `" . $value->col_table_name . "`, ";
                        $valSql .= " '" . date('Y-m-d', strtotime($column[$value->col_csv_index])) . "', ";
                    } else if ($value->type === "DATETIME") {
                        $colSql .= " `" . $value->col_table_name . "`, ";
                        $valSql .= " '" . date('Y-m-d H:i:s', strtotime($column[$value->col_csv_index])) . "', ";
                    } else {
                        $colSql .= " `" . $value->col_table_name . "`, ";
                        $valSql .= " '" . $column[$value->col_csv_index] . "', ";
                    }
                }

                $count = $columnCustom->count();
                foreach ($columnCustom as $key => $value) {
                    if (($count - 1) > $key) {
                        $colSql .= " `" . $value->table_col_name . "`, ";
                        $valSql .= " '" . $column[$value->csv_col_index] . "', ";
                    } else {
                        $colSql .= " `" . $value->table_col_name . "`) ";
                        $valSql .= " '" . $column[$value->csv_col_index] . "') ";
                    }
                }
            }

            DB::select($sql . $colSql . " VALUES " . $valSql);
            // echo $sql . $colSql . " VALUES " . $valSql;
        }

        return back();
    }

    public function File()
    {
        $files = File::allFiles(public_path() . '/assets/file_csv/');
        foreach ($files as $key => $value) {
            $filename = explode('/', $value);
            $filename = array_pop($filename);
            $table_name = explode('_', $filename);
            $table_name = str_replace(' ', '_', $table_name[0]);
            echo strtolower($table_name);
            echo "<br>";
        }
    }
}
