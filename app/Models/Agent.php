<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;
    protected $fillable = [
        'full_name',
        'contact_number',
        'date',
        'cea_registration_number',
        'agency_name',
        'city',
        'state',
        'address',
        'email_address',
        'password',
        'profile_picture',
        'verification_document',
        'year_of_experience',
        'residential',
        'commercial',
        'land',
        'other',
        'area_of_operation',
        'terms_and_conditions',
        'ticket_subject',
        'type',
        'priority',
        'status',
        'approve_status'
    ];
}
