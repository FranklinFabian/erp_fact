<?php defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Eloquent;

class Fact_Emision_model extends Eloquent
{
//    public $table = "fact_emisiones";
//    public $table_id = "Id_Emision";
    protected $table = 'fact_emisiones';
    protected $Ci;
    protected $primaryKey = 'Id_Emision';
    public $timestamps = true;
    const CREATED_AT = '_Creado_El';
    const UPDATED_AT = '_Actualizado_El';

    public function __construct()
    {
        $this->Ci = &get_instance();
    }

    function factor(){
        return $this->belongsTo('Fact_Factor_model', 'Emision');
    }
}
