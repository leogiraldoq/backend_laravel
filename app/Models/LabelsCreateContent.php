<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabelsCreateContent extends Model
{
    use HasFactory;
    
    protected $table='labels_create_content';
    protected $primaryKey='id_label_content';
    protected $fillable=[
        'title_content',
        'list_contents',
        'active'
    ];
}
