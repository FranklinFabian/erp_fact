<?php defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Eloquent;

class Atcl_Orden_model extends Eloquent
{
    protected $table = 'atcl_ordenes';
    protected $Ci;
    protected $primaryKey = 'Id_Orden';
    public $timestamps = true;
    const CREATED_AT = '_Creado_El';
    const UPDATED_AT = '_Actualizado_El';
    protected $dateFormat = 'Y-m-d H:i:s';

    public function __construct()
    {
        $this->Ci = &get_instance();
    }

    function abonado(){
        return $this->belongsTo('Atcl_Abonado_model', 'Abonado');
    }

    function emision(){
        return $this->hasOne('Fact_Emision_model', 'Emision');
    }

    function servicio(){
        return $this->belongsTo('Sis_Servicio_model', 'Servicio');
    }

//    function conexion(){
//        return $this->hasOne('Atcl_Conexion_model');
//    }
}
