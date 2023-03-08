<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class Plan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class , 'plan_permission');
    }

    public function getNameAttribute(){
        return $this->{'name_'.app()->getLocale()};
    }

    public function getDescriptionAttribute(){
        return $this->{'description_'.app()->getLocale()};
    }
}
