<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterCSV extends Model
{
    use HasFactory;
    protected $table = 'master_csv_data';
    protected $guarded = [];
}
