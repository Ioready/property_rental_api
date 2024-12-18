<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;
    protected $fillable = [
        'full_name',
        'contact_number',
        'email_address',
        'ticket_subject',
        'type',
        'priority',
    ];
}
