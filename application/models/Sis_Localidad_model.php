<?php defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Eloquent;

class Sis_Localidad_model extends Eloquent
{
    protected $table = 'sis_localidades';
    protected $Ci;
    protected $primaryKey = 'Id_Localidad';
    public $timestamps = true;
    const CREATED_AT = '_Creado_El';
    const UPDATED_AT = '_Actualizado_El';
    protected $dateFormat = 'Y-m-d H:i:s';

    public function __construct()
    {
        $this->Ci = &get_instance();
    }
//
//    function emision(){
//        return $this->hasOne('Fact_Emision_model', 'Emision');
//    }
}
