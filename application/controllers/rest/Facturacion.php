<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Facturacion extends RestController
{
    const HABILITADO = '1';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Fact_Factor_model');
        $this->load->model('Fact_Emision_model');
    }

    public function categorias_get($id = null)
    {
        $this->load->model('Fact_Categoria_model');
        $this->response(Fact_Categoria_model::all(), 200);
    }

    public function factores_get($id = null)
    {
        $this->load->model('Fact_Factor_model');
        $this->response(Fact_Factor_model::all(), 200);
    }

    public function factores_post()
    {
        $id_factor = $this->post('Id_Factor');
        if($id_factor){
            $factor = Fact_Factor_model::find($id_factor);
            $msg = 'Registro actualizado correctamente.';
        }
        else{
            $factor = new Fact_Factor_model();
            $msg = 'Registro agregado correctamente.';
        }

        $factor->Emision = $this->post('emision');
        $factor->RE_020 = $this->post('RE_020');
        $factor->RE_100 = $this->post('RE_100');
        $factor->RE_ADE = $this->post('RE_ADE');
        $factor->GE_020 = $this->post('GE_020');
        $factor->GE_100 = $this->post('GE_100');
        $factor->GE_ADE = $this->post('GE_ADE');

        $chk = $factor->save();

        if ($chk) {
            $result['error'] = false;
            $result['msg'] = $msg;
            $this->response($result, RestController::HTTP_OK);
        } else {
            $result['error'] = true;
            $result['msg'] = 'Error al intentar guardar';
            $this->response($result, RestController::HTTP_BAD_REQUEST);
        }
    }

    public function factores_put()
    {
        $factor = new Fact_Factor_model();
        $factor->Emision = $this->post('emision');
        $factor->RE_020 = $this->post('RE_020');
        $factor->RE_100 = $this->post('RE_100');
        $factor->RE_ADE = $this->post('RE_ADE');
        $factor->GE_020 = $this->post('GE_020');
        $factor->GE_100 = $this->post('GE_100');
        $factor->GE_ADE = $this->post('GE_ADE');

        $chk = $factor->save();

        if ($chk) {
            $result['error'] = false;
            $result['msg'] = 'Usuario agregado satisfactoriamente';
            $this->response($result, RestController::HTTP_OK);
        } else {
            $result['error'] = true;
            $result['msg'] = 'Error al intentar guardar';
            $this->response($result, RestController::HTTP_BAD_REQUEST);
        }
    }

    public function factor_by_emision_get($id = null)
    {
        $factores = Fact_Factor_model::where('Emision', $id)->first();
        $this->response($factores, RestController::HTTP_OK);
    }

    public function emisiones_get($id = null)
    {
        $this->response(Fact_Emision_model::all(), RestController::HTTP_OK);
    }

    public function emision_actual_get($id = null)
    {
        $emision = Fact_Emision_model::where('Abierto', self::HABILITADO)
            ->where('Emision', '>', date('Y-m-d'))
            ->get(['Id_Emision', 'Emision'])
            ->first();

        $this->response($emision, RestController::HTTP_OK);
    }
}
