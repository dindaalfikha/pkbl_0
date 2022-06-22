<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CsvToTable extends Model
{
    use HasFactory;
    protected $table = 'master_csv_to_table';
    protected $guarded = [];
}
