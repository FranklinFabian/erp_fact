<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Admin extends RestController
{
    const HABILITADO = '1';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Sis_Localidad_model');
        $this->load->model('Sis_Zona_model');
        $this->load->model('Sis_Calle_model');
        $this->load->model('Sis_Centro_Transformacion_model');
        $this->load->model('Sis_Poste_model');
        $this->load->model('Sis_Tipo_Suministro_model');
        $this->load->model('Sis_Tipo_Consumidor_model');
        $this->load->model('Sis_Tipo_Medicion_model');
        $this->load->model('Sis_Servicio_model');
        $this->load->model('Sis_Servicio_Costo_model');
        $this->load->model('Fact_Liberacion_Servicio_model');
        $this->load->model('Fact_Emision_model');
    }

    public function localidades_get($id = null)
    {
        $this->response(Sis_Localidad_model::all(), RestController::HTTP_OK);
    }

    public function zonas_get($id = null)
    {
        $this->response(Sis_Zona_model::all(), RestController::HTTP_OK);
    }

    public function zonas_by_localidad_get($id = null)
    {
        $this->response(Sis_Zona_model::where('Localidad', $id)->get(), RestController::HTTP_OK);
    }

    public function calles_get($id = null)
    {
        $this->response(Sis_Calle_model::all(), RestController::HTTP_OK);
    }

    public function calles_by_zona_get($id = null)
    {
        $this->response(Sis_Calle_model::where('Zona', $id)->get(), RestController::HTTP_OK);
    }

    public function centros_get($id = null)
    {
        $this->response(Sis_Centro_Transformacion_model::all(), RestController::HTTP_OK);
    }

    public function centros_by_localidad_get($id = null)
    {
        $this->response(Sis_Centro_Transformacion_model::where('Localidad', $id)->get(), RestController::HTTP_OK);
    }

    public function postes_get($id = null)
    {
        $this->response(Sis_Poste_model::all(), RestController::HTTP_OK);
    }

    public function postes_by_centro_get($id = null)
    {
        $this->response(Sis_Poste_model::where('Centro_Transformacion', $id)->get(), RestController::HTTP_OK);
    }

    public function tipo_suministros_get($id = null)
    {
        $this->response(Sis_Tipo_Suministro_model::all(), RestController::HTTP_OK);
    }

    public function tipo_consumidores_get($id = null)
    {
        $this->response(Sis_Tipo_Consumidor_model::all(), RestController::HTTP_OK);
    }

    public function tipo_mediciones_get($id = null)
    {
        $this->response(Sis_Tipo_Medicion_model::all(), RestController::HTTP_OK);
    }

    public function servicios_get($id = null)
    {
        $this->response(Sis_Servicio_model::all(), RestController::HTTP_OK);
    }

    public function costo_servicio_get($servicio)
    {
//        if (date('m',strtotime(date('Y-m-d'))) == date('m')){
//
//        }
        $emision = Fact_Emision_model::where('Abierto', self::HABILITADO)
            ->where('Emision', '>', date('Y-m-d'))
            ->get(['Id_Emision'])
            ->first();

//        print_r($emision->Id_Emision);
//        die();

        if($emision){
            $costo = Sis_Servicio_Costo_model::where('Servicio', $servicio)
                ->where('Emision', $emision->Id_Emision)
                ->get()
                ->first();
            $this->response($costo, RestController::HTTP_OK);
        } else {
            $result['error'] = 'No existe emisión para este servicio.';
            $this->response($result, RestController::HTTP_OK);
        }
    }

    public function tipo_liberaciones_servicios_get($id = null)
    {
        $this->response(Fact_Liberacion_Servicio_model::all(), RestController::HTTP_OK);
    }
}
