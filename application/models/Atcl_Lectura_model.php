<?php defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Eloquent;

class Atcl_Lectura_model extends Eloquent
{
    protected $table = 'atcl_lecturas';
    protected $Ci;
    protected $primaryKey = 'Id_Lectura';
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

    function categoria(){
        return $this->belongsTo('Fact_Categoria_model', 'Categoria');
    }

    function emision(){
        return $this->belongsTo('Fact_Emision_model', 'Emision');
    }

    function deuda(){
        return $this->hasOne('Atcl_Deuda_model', 'Lectura', 'Id_Lectura');
    }

}
