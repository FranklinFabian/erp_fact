<?php defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Eloquent;

class Fact_Liberacion_Servicio_model extends Eloquent
{
    protected $table = 'fact_liberacion_servicios';
    protected $Ci;
    protected $primaryKey = 'Id_Liberacion_Servicio';
    public $timestamps = true;
    const CREATED_AT = '_Creado_El';
    const UPDATED_AT = '_Actualizado_El';
    protected $dateFormat = 'Y-m-d H:i:s';

    public function __construct()
    {
        $this->Ci = &get_instance();
    }
}
