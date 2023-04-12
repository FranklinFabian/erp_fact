<?php defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Eloquent;

class Fact_Factor_model extends Eloquent
{
    protected $table = 'fact_factores';
    protected $Ci;
    protected $primaryKey = 'Id_Factor';
    public $timestamps = true;
    const CREATED_AT = '_Creado_El';
    const UPDATED_AT = '_Actualizado_El';
    protected $dateFormat = 'Y-m-d H:i:s';

    public function __construct()
    {
        $this->Ci = &get_instance();
    }

    function emision(){
        return $this->hasOne('Fact_Emision_model', 'Emision');
    }
//
//    public $table = "fact_factores";
//    public $table_id = "Id_Factor";
//
//    function getByEmision($id_emision) {
//
//        $this->db->select('*');
//        $this->db->from($this->table);
//        $this->db->where("Emision", $id_emision);
//
//        $query = $this->db->get();
//
//        return $query->row();
//    }
}
