<?php defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Eloquent;

class Sis_Tipo_Consumidor_model extends Eloquent
{
    protected $table = 'sis_tipos_consumidores';
    protected $Ci;
    protected $primaryKey = 'Id_Tipo_Consumidor';
    public $timestamps = true;
    const CREATED_AT = '_Creado_El';
    const UPDATED_AT = '_Actualizado_El';
    protected $dateFormat = 'Y-m-d H:i:s';

    public function __construct()
    {
        $this->Ci = &get_instance();
    }
}
