<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\MasterCSV;
use App\Models\CsvDB;
use App\Models\CsvToTable;
use File;

class DataSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
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
    }
}
