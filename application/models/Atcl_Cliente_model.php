<?php defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Eloquent;

class Atcl_Cliente_model extends Eloquent
{
    protected $table = 'atcl_clientes';
    protected $Ci;
    protected $primaryKey = 'Id_Cliente';
    public $timestamps = true;
    const CREATED_AT = '_Creado_El';
    const UPDATED_AT = '_Actualizado_El';
    protected $dateFormat = 'Y-m-d H:i:s';

    public function __construct()
    {
        $this->Ci = &get_instance();
    }

    function abonados(){
        return $this->hasMany('Atcl_Abonado_model', 'Id_Abonado');
    }
}
