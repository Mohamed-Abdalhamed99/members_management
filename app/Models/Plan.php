<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class Plan extends Model {
    use HasFactory;

    protected $guarded = [];

    public function features() {
        return $this->hasMany( PlansFeature::class, 'plan_id' );
    }

}
