<?php

namespace App\Model\Phonebook;

use Illuminate\Database\Eloquent\Model;

class Phonebook extends Model
{
    public $timestamps = true;
    
    protected $table = 'info_phonebook';
    protected $fillable = [ 'id',
                            'nama_perusahaan',
                            'alamat_perusahaan',
                            'kota_perusahaan',
                            'telp_perusahaan',
                            'fax_perusahaan',
                            'ket_perusahaan',
                            'nama_person',
                            'alamat_person',
                            'kota_person',
                            'telp_person',
                            'fax_person',
                            'hp_person',
                            'ket_person',
                            'is_deleted'];
}
