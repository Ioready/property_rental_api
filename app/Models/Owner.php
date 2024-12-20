<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;
    protected $fillable = [
        'owner_type',
        'full_name',
        'contact_number',
        'date',
        'company_name',
        'email_address',
        'password',
        'city',
        'state',
        'address',
        'profile_picture',
        'company_registration_number_uen',
        'gst_number',
        'billing_address',
        'same_as_address',
        'verification_document',
        'terms_and_conditions',
        'ticket_subject',
        'type',
        'priority',
        'status',
        'assign_package'
    ];
}
