<?php defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Eloquent;

class Atcl_Abonado_model extends Eloquent
{
    protected $table = 'atcl_abonados';
    protected $Ci;
    protected $primaryKey = 'Id_Abonado';
    public $timestamps = true;
    const CREATED_AT = '_Creado_El';
    const UPDATED_AT = '_Actualizado_El';
    protected $dateFormat = 'Y-m-d H:i:s';

    public function __construct()
    {
        $this->Ci = &get_instance();
    }

    function cliente(){
        return $this->belongsTo('Atcl_Cliente_model', 'Cliente');
    }

    function categoria(){
        return $this->belongsTo('Fact_Categoria_model', 'Categoria');
    }

    function emision(){
        return $this->hasOne('Fact_Emision_model', 'Emision');
    }

    function lecturas(){
        return $this->hasMany('Atcl_Lectura_model', 'Abonado', 'Id_Abonado')->take(6)->orderBy('Id_Lectura', 'desc');
    }
}
