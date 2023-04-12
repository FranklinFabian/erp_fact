<?php defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Eloquent;

class Fact_Dosificacion_model extends Eloquent
{
    protected $table = 'fact_autorizaciones';
    protected $Ci;
    protected $primaryKey = 'Id_Autorizacion';
    public $timestamps = true;
    const CREATED_AT = '_Creado_El';
    const UPDATED_AT = '_Actualizado_El';
    protected $dateFormat = 'Y-m-d H:i:s';

    public function __construct()
    {
        $this->Ci = &get_instance();
    }
}
