<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CsvDB extends Model
{
    use HasFactory;
    protected $table = 'csv_db_associate';
    protected $guarded = [];
}
