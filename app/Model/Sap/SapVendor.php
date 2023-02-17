<?php

namespace App\Model\Sap;

use Illuminate\Database\Eloquent\Model;

class SapVendor extends Model
{
    protected $table = "helpdesk_sap_vendor";
    protected $fillable = [
                            'helpdesk_id', 'grouping_id', 'title_id', 'name', 'address',
                            'city',  'postal_code', 'region', 'country', 'phone', 
                            'mobile_phone', 'email', 'bank_name', 'bank_rek', 'bank_acct_name',
                            'tax_number', 'tax_name', 'order_currency','top', 'recon_acct_id', 
                            'wht_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 
                            'is_active'
                        ];


}
