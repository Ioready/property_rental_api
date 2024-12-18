<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Permission;

class Role extends Model
{
    
    protected $fillable = ['name'];

    // const ROLE_SUPERADMIN = 1;
    const ADMIN = 1;
    const AGENT = 2;
    const OWNER = 3;
    const USER = 4;
    


    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
