<?php

namespace App\model\Sap;

use Illuminate\Database\Eloquent\Model;

class SapReconcAcct extends Model
{
    public $timestamps = true;
    
    protected $table = 'sap_reconciliation_acct';
    protected $fillable = ['id','reconciliation_name'];
}
