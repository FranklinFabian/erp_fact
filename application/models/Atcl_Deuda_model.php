<?php defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Eloquent;

class Atcl_Deuda_model extends Eloquent
{
    protected $table = 'atcl_deudas';
    protected $Ci;
    protected $primaryKey = 'Id_Deuda';
    public $timestamps = true;
    const CREATED_AT = '_Creado_El';
    const UPDATED_AT = '_Actualizado_El';
    protected $dateFormat = 'Y-m-d H:i:s';

    public function __construct()
    {
        $this->Ci = &get_instance();
    }

    function lectura(){
        return $this->belongsTo('Atcl_Lectura_model', 'Lectura');
    }
}
