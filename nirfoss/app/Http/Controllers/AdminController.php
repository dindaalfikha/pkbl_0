<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MasterCSV;
use App\Models\CsvDB;
use App\Models\CsvToTable;
use App\Models\Norma;
use App\Models\Unit;
use File;

class AdminController extends Controller
{
	function __construct() {
    	$this->data['measure_data'] = CsvToTable::get();
    }

    public function index()
    {
        $this->data['transaction'] = CsvToTable::get();
        $this->data['title'] = 'Dashboard';
        $this->data['active'] = 1;

        return view('admin.dashboard', $this->data);
    }

    public function MasterCsvData()
    {
        $this->data['csv'] = MasterCSV::get();
        $this->data['title'] = 'Master CSV Data';
        $this->data['active'] = 2;

        return view('admin.master_csv_data', $this->data);
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

    public function MasterCsvTable()
    {
        $this->data['csv'] = CsvToTable::get();
        $this->data['title'] = 'Master CSV to Table';
        $this->data['active'] = 3;

        return view('admin.master_table_csv', $this->data);
    }
    
    public function AddTable()
    {
        $this->data['unit'] = Unit::get();
        $this->data['title'] = 'Add Table';
        $this->data['active'] = '3';

        return view('admin.add_table', $this->data);
    }

    public function AddTableProcess(Request $request)
    {
        $dataColumn = MasterCSV::get();
        $sql = "CREATE TABLE `" . DB::connection()->getDatabaseName() . "`.`" . $request->table_name . "` (`id_" . $request->table_name . "` INT NOT NULL AUTO_INCREMENT, ";

        foreach ($dataColumn as $value) {
            $sql .= " `" . $value->col_table_name . "` " . $value->type . ", ";
        }

        foreach ($request->col_table_name as $value) {
            $sql .= " `" . $value . "` DOUBLE NOT NULL, ";
        }

        $sql .= " `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY  (`id_" . $request->table_name . "`)) ENGINE = InnoDB";

        
        $id = CsvToTable::create([
            'table_name' => $request->table_name,
            'unit' => implode(',', $request->unit)
        ]);
        
        foreach ($request->col_table_name as $key => $value) {
            $id_csv = CsvDB::create([
                'id_table' => $id->id,
                'csv_col_name' => $request->col_csv_name[$key],
                'csv_col_index' => $request->col_csv_index[$key],
                'table_col_name' => $value
            ]);

            // foreach ($request->unit as $k => $v) {
            Norma::create([
                'id_csv' => $id_csv->id,
                'use_warning' => $request->use_warning[$key],
                'jml_norma' => $request->norma_value[$key]
            ]);
            // }
        }

        DB::select($sql);

        return redirect()->route('admin.master.csv.table');
    }

    public function EditTable($id_table)
    {
        $this->data['unit'] = Unit::get();
        $this->data['table_detail'] = CsvToTable::where(['id_table' => $id_table])->first();
        $this->data['col'] = CsvDB::leftJoin('norma', 'csv_db_associate.id_csv', '=', 'norma.id_csv')->where(['csv_db_associate.id_table' => $this->data['table_detail']->id_table])->get();
        $this->data['active'] = 3;
        $this->data['title'] = 'Edit Table';

        return view('admin.edit_table', $this->data);
    }

    public function EditTableProcess(Request $request)
    {
        CsvToTable::where(['id_table' => $request->id_table])->update([
            'table_name' => $request->table_name,
            'unit' => implode(',', $request->unit)
        ]);

        foreach($request->id_csv as $key => $value) {
            $dataToInput = [
                'csv_col_name' =>  $request->col_csv_name[$key],
                'csv_col_index' =>  $request->col_csv_index[$key],
                'table_col_name' =>  $request->col_table_name[$key],
                'use_warning' => $request->use_warning[$key]
            ];

            CsvDB::where(['id_csv' => $value])->update($dataToInput);
        }

        foreach ($request->id_norma as $key => $value) {
            Norma::where(['id_norma' => $value])->update([
                'jml_norma' => $request->norma_value[$key]
            ]);
        }

        return redirect()->route('admin.master.csv.table');
    }

    public function DataSync()
    {
        $files = File::allFiles(storage_path() . '/file_csv/');
        foreach ($files as $key => $value) {
            $file = File::get($value);
            $filename = explode('/', $value);
            $filename = array_pop($filename);
            $table_name = explode('_', $filename);
            $table_name = str_replace(' ', '_', strtolower($table_name[0]));
            $file = fopen($value, "r");
            
            $check_exist = CsvToTable::where(['table_name' => $table_name])->first();

            if(!$check_exist) {
                $dataColumn = MasterCSV::get();
                $sql = "CREATE TABLE `" . DB::connection()->getDatabaseName() . "`.`" . $table_name . "` (`id_" . $table_name . "` INT NOT NULL AUTO_INCREMENT, ";
                $csv_insert = [];

                foreach ($dataColumn as $value) {
                    $sql .= " `" . $value->col_table_name . "` " . $value->type . ", ";
                }

                while (($column = fgetcsv($file, 1000, ',')) !== false) {
                    // 17, 1, 19
                    $plus = 11;
                    if($column[20] != "[%]") {
                        $sql .= " `" . str_replace('/', '_', strtolower($column[20])) . "` DOUBLE NOT NULL, ";
                        $plus += 1;
                    }

                    if(!empty($column[17]) && $column[17] !== " ") {
                        $tbl_col = str_replace('/', '_', strtolower($column[17]));
                        $sql .= " `" . $tbl_col . "` DOUBLE NOT NULL, ";
                        $csv_insert['csv_index_col'][] = 17 + $plus;
                        $csv_insert['table_col_name'][] = $tbl_col;
                        $csv_insert['csv_col_name'][] = $column[17];
                    }

                    if(!empty($column[18]) && $column[18] !== " ") {
                        $tbl_col = str_replace('/', '_', strtolower($column[18]));
                        $sql .= " `" . $tbl_col . "` DOUBLE NOT NULL, ";
                        $csv_insert['csv_index_col'][] = 18 + $plus;
                        $csv_insert['table_col_name'][] = $tbl_col;
                        $csv_insert['csv_col_name'][] = $column[18];
                    }

                    if(!empty($column[19]) && $column[19] !== " ") {
                        $tbl_col = str_replace('/', '_', strtolower($column[19]));
                        $sql .= " `" . $tbl_col . "` DOUBLE NOT NULL, ";
                        $csv_insert['csv_index_col'][] = 19 + $plus;
                        $csv_insert['table_col_name'][] = $tbl_col;
                        $csv_insert['csv_col_name'][] = $column[19];
                    }
                }

                $sql .= " `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY  (`id_" . $table_name . "`)) ENGINE = InnoDB";
                DB::select($sql);
                $table_id = CsvToTable::create([
                    'table_name' => $table_name,
                    'unit' => ""
                ]);

                foreach ($csv_insert['csv_index_col'] as $key => $value) {
                    $id_csv = CsvDB::create([
                        'id_table' => $table_id->id,
                        'csv_col_name' => $csv_insert['csv_col_name'][$key],
                        'csv_col_index' => $csv_insert['csv_index_col'][$key],
                        'table_col_name' => $csv_insert['table_col_name'][$key],
                        'use_warning' => 1,
                    ]);

                    Norma::create([
                        'id_csv' => $id_csv->id,
                        'jml_norma' => 0
                    ]);
                }
            }

            $sql = "INSERT INTO `" . $table_name . "` ";
            $colSql = '(';
            $valSql = '(';

            $columnMaster = MasterCSV::get();
            $columnCustom = CsvDB::join('master_csv_to_table', 'csv_db_associate.id_table', '=', 'master_csv_to_table.id_table')->where(['master_csv_to_table.table_name' => $table_name])->get();

            while (($column = fgetcsv($file, 10000, ",")) !== false) {
                $sql_check = "SELECT `date`, `time` FROM `" . $table_name . "` WHERE `date` = '" . date('Y-m-d', strtotime($column[25])) . "' AND `time` = '" . $column[26] . "'";
                $sql_check = DB::select($sql_check);
                if(!$sql_check) {
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

                    DB::select($sql . $colSql . " VALUES " . $valSql);
                }
            }
        }

        return back();
    }

    public function MasterUnit()
    {
        $this->data['title'] = 'Master Unit';
        $this->data['active'] = 4;
        $this->data['unit'] = Unit::get();

        return view('admin.master_unit', $this->data);
    }

    public function AddUnit(Request $request)
    {
        // echo storage_path();
        File::makeDirectory(storage_path() . '/file_csv/' . $request->name, 0777, true, true);
        Unit::create(['nama_unit' => $request->name]);

        return back();
    }

    public function MeasureData($id_table)
    {
        $table_name = CsvToTable::where(['id_table' => $id_table])->first();
        $sql = "SELECT * FROM `".$table_name->table_name."` ";
        if(!empty($_GET)) {
            $sql .= "WHERE ";
            $where = [];
            if(!empty($_GET['start_date'])) {
                $where[] = "`date` >= '" . date('Y-m-d', strtotime($_GET['start_date'])) . "' ";
            }

            if(!empty($_GET['start_time'])) {
                $where[] = "`time` >= '" . date('Y-m-d', strtotime($_GET['start_time'])) . "' ";
            }

            if(!empty($_GET['end_date'])) {
                $where[] = "`date` <= '" . date('Y-m-d', strtotime($_GET['end_date'])) . "' ";
            }

            if(!empty($_GET['end_time'])) {
                $where[] = "`time` <= '" . date('Y-m-d', strtotime($_GET['end_time'])) . "' ";
            }

            if(!empty($_GET['unit']) && $_GET['unit'] != 'all') {
                $where[] = "`unit` LIKE '%" . $_GET['unit'] . "' ";
            }

            if(!empty($_GET['sample_number'])) {
                $where[] = "`sample_number` LIKE '%" . $_GET['sample_number'] . "%' ";
            }

            $sql .= implode(' AND ', $where);
        }

        $sql .= "ORDER BY `date` DESC, `time` DESC";
        // echo $sql;
        // exit;
        $this->data['unit'] = Unit::get();
        $this->data['table_name'] = $table_name;
        $this->data['data'] = DB::select($sql);
        $this->data['col'] = CsvDB::where(['id_table' => $id_table])->get();
        $this->data['title'] = 'Measure Data';
        $this->data['active'] = 5;

        return view('admin.measure_detail', $this->data);
    }
}
