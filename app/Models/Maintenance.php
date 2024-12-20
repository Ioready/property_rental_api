<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_no',
        'property',
        'unit',
        'issue_type',
        'maintainer',
        'description',
        'images',
        'status'
    ];
}
