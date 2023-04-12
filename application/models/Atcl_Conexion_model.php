<?php defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Eloquent;

class Atcl_Conexion_model extends Eloquent
{
    protected $table = 'atcl_conexiones';
    protected $Ci;
    protected $primaryKey = 'Id_Conexion';
    public $timestamps = true;
    const CREATED_AT = '_Creado_El';
    const UPDATED_AT = '_Actualizado_El';
    protected $dateFormat = 'Y-m-d H:i:s';

    public function __construct()
    {
        $this->Ci = &get_instance();
    }

    function orden(){
        return $this->belongsTo('Atcl_Orden_model', 'Orden');
    }

}
