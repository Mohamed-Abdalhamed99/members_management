<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TenantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'domain' => $this->domain,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'password' => $this->password,
            'telephone' => $this->telephone,
            'address' => $this->address,
            'avatar' => $this->avatar,
            'plan_id' => $this->plan_id,
            'company_name' => $this->company_name,
            'company_email' => $this->company_email,
            'company_phone' => $this->company_phone,
            'company_fax' => $this->company_fax,
            'company_website' => $this->company_website,
            'company_bank' => $this->company_bank,
            'company_bank_account' => $this->company_bank_account,
            'company_notes' => $this->company_notes,
            'company_fiscal_code' => $this->company_fiscal_code,
            'company_logo' => $this->company_logo,
            'plan' => [
                'id' => $this->plans->id,
                'name' => $this->plans->name,
            ],
            'permissions' => collect($this->plans->permissions)->transform(function ($item){
                return [ 'id' => $item->id, 'display_name' => $item->{'display_name_'.app()->getLocale()}];
            })
        ];
    }
}
