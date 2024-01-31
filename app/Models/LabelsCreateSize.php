<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabelsCreateSize extends Model
{
    use HasFactory;
    
    protected $table='labels_create_size';
    protected $primaryKey='id_label_size';
    protected $fillable=[
        'title_label_size',
        'list_size',
        'active'
    ];
}
