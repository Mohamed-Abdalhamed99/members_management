<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains ,Notifiable;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tenants = Tenant::with('domains')->paginate(100);
        return view('admin.tenants.index', compact('tenants'));
    }


    public function plans(){
        return $this->belongsTo(Plan::class , 'plan_id');
    }

}
