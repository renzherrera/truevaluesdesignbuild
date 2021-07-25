<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $table = "company_profile";


    protected $fillable = [
        'company_name',
        'nature_of_business',
        'office_address',
        'contact_number',
        'email_address',
        'facebook',
        'instagram',
        'twitter',
        'about_company',
        'image',
    ];
}
