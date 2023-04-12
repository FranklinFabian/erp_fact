<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class FactGeneraFactura
{

    const CATEGORIA_RESIDENCIAL = 4;
    const CATEGORIA_GENERAL = 8;
    const SIN_ASEO = 2;
    const SIN_ALUMBRADO = 3;
    const SIN_ASEO_NI_ALUMBRADO = 4;
    const DECIMALES = 1;

    public function calcular_deudas($id_abonado, $id_emision, $userid)
    {

        $CI = &get_instance();
        $CI->load->helper('facturacion_helper');
        $CI->load->model('Invoices');
        $CI->load->model('Atcl_Lectura_model');
        $CI->load->model('Atcl_Cliente_model');
        $CI->load->model('Atcl_Abonado_model');
        $CI->load->model('Atcl_Orden_model');
        $CI->load->model('Atcl_Deuda_model');
        $CI->load->model('Fact_Emision_model');
        $CI->load->model('Conf_Energia_model');
        $CI->load->model('Fact_Factor_model');
        $CI->load->model('Fact_Categoria_model');
        $CI->load->model('Fact_Factura_model');
        $CI->load->model('Fact_Dosificacion_model');

        $lectura = Atcl_Lectura_model::with('categoria', 'abonado.cliente')
            ->where('Abonado', $id_abonado)
            ->where('Emision', $id_emision)
            ->get()
            ->first();

        if ($lectura) {

            $conf_energia = Conf_Energia_model::find(1);
            $factores = Fact_Factor_model::where('Emision', $id_emision)->get()->first();
            $costo_servicios_ordenes = Atcl_Orden_model::where('Estado', 'FINALIZADO')
                ->where('Cobrado', 'NO')
                ->where('Abonado', $id_abonado)
                ->sum('Costo');

            // IMPORTES DE ENERGIA
            $importes_energia = $this->getImportesEnergia($lectura, $factores, $conf_energia);

            // LIBRERACION DE SERVICIOS
            list($importe_aseo, $importe_alumbrado) = $this->getImportesLiberados($lectura,
                $conf_energia,
                $importes_energia['total']);

            // IMPORTES DE SERVICIOS
            $importe_servicios = round($costo_servicios_ordenes, self::DECIMALES);

            //CALCULOS PARA FACTURA
            $importe_neto = round(($importes_energia['total'] + $importe_servicios), self::DECIMALES);
            $importe_excento = round(($importe_aseo + $importe_alumbrado), self::DECIMALES);
            $importe_factura = round(($importe_neto + $importe_excento), self::DECIMALES);
            $importe_iva = round(($importe_neto * 0.13), self::DECIMALES);
            $importe_ite = round(($importe_neto * 0.03), self::DECIMALES);

            //genera deuda
            $deuda = new Atcl_Deuda_model();
            $deuda->Lectura = $lectura->Id_Lectura;
            $deuda->Importe_Fijo = $importes_energia['fijo'];
            $deuda->Importe_Adicional = $importes_energia['intermedio'] + $importes_energia['adicional'];
            $deuda->Importe_Potencia = $importes_energia['demanda'];
            $deuda->Importe_Total = $importes_energia['total'];
            $deuda->Importe_Conexion = $importe_servicios;
//        $deuda->Importe_Reposicion = $importe_reposicion;
//        $deuda->Importe_Recargo = $importe_recargo;
            $deuda->Importe_Aseo = $importe_aseo;
            $deuda->Importe_Alumbrado = $importe_alumbrado;
            $deuda->Importe_Dignidad_1 = $importes_energia['dignidad_base'];
            $deuda->Importe_Dignidad_2 = $importes_energia['dignidad_compl'];
//        $deuda->Devolucion = $devolucion;
            $deuda->Observacion = 'DEUDA GENERADA POR SISTEMA';
            $deuda->_Creado_Por = $userid;
            $chk = $deuda->save();

            if ($chk) {
                //Genera Factura
                $dosificacion = Fact_Dosificacion_model::where('Estado', 'ACTIVO')->get()->first();
                $factura = new Fact_Factura_model();
                $fecha_hoy = date('Y-m-d');
                $id_factura = Fact_Factura_model::orderBy('_Creado_El', 'desc')->first() + 1;
                $cc = controlCode($dosificacion->Autorizacion,
                    $id_factura,
                    $lectura->abonado->cliente->Nit,
                    $fecha_hoy,
                    $importe_factura,
                    $dosificacion->Llave);

                $factura->Id_Factura = $id_factura;
                $factura->Autorizacion = $dosificacion->Autorizacion;
                $factura->Lectura = $lectura->Id_Lectura;
                $factura->Razon = $lectura->abonado->cliente->Nombres;
                $factura->Nit = $lectura->abonado->cliente->Nit;
                $factura->Emision = $id_emision;
                $factura->Excento = $importe_excento;
                $factura->Neto = $importe_neto;
                $factura->Importe = $importe_factura;
                $factura->Iva = $importe_iva;
                $factura->Ite = $importe_ite;
                $factura->Codigo_Control = $cc;
                $factura->save();

                $result['error'] = false;
                $result['msg'] = 'DEUDA GENERADA';
            } else {
                $result['error'] = true;
                $result['msg'] = 'DEUDA NO GENERADA';
            }
        } else {
            $result['error'] = true;
            $result['msg'] = 'DEUDA NO GENERADA';
        }

        return $result;
    }

    public function getImportesEnergia($lectura, $factores, $conf_energia)
    {
        $importe_fijo = $importe_adicional = $importe_intermedio = $importe_diginidad_1 = $importe_diginidad_2 = $importe_diginidad_3 = $importe_demanda = 0;

        if ($lectura->Categoria == self::CATEGORIA_RESIDENCIAL) {
            $importe_fijo = round($factores->RE_020, self::DECIMALES);

            if ($lectura->Consumo_Actual > 20 && $lectura->Consumo_Actual < 51) {
                $importe_intermedio = round((($lectura->Consumo_Actual - 20) * $factores->RE_100), self::DECIMALES);
            }

            if ($lectura->Consumo_Actual > 50) {
                $importe_intermedio = round((30 * $factores->RE_100), self::DECIMALES);
                $importe_adicional = round((($lectura->Consumo_Actual - 50) * $factores->RE_100), self::DECIMALES);
            }

            if ($lectura->Consumo_Actual < 71) {
                $importe_diginidad_1 = round(($importe_fijo * $conf_energia->Dignidad), self::DECIMALES);
                $importe_diginidad_2 = round(($importe_intermedio * $conf_energia->Dignidad), self::DECIMALES);
                $importe_diginidad_3 = round(($importe_adicional * $conf_energia->Dignidad), self::DECIMALES);
            }

            //TODO hacer beneficiario LEY1886

            $importe_fijo = round(($importe_fijo - ($importe_diginidad_1)), self::DECIMALES);
            $importe_intermedio = round(($importe_intermedio - ($importe_diginidad_2)), self::DECIMALES);
            $importe_adicional = round(($importe_adicional - ($importe_diginidad_3)), self::DECIMALES);
        }

        if ($lectura->Categoria == self::CATEGORIA_GENERAL) {
            $importe_fijo = round($factores->GE_020, self::DECIMALES);

            if ($lectura->Consumo_Actual > 20 && $lectura->Consumo_Actual < 51) {
                $importe_intermedio = round((($lectura->Consumo_Actual - 20) * $factores->GE_100), self::DECIMALES);
            }

            if ($lectura->Consumo_Actual > 50) {
                $importe_intermedio = round((30 * $factores->GE_100), self::DECIMALES);
                $importe_adicional = round((($lectura->Consumo_Actual - 50) * $factores->GE_100), self::DECIMALES);
            }

            $importe_fijo = round(($importe_fijo - ($importe_diginidad_1)), self::DECIMALES);
            $importe_intermedio = round(($importe_intermedio - ($importe_diginidad_2)), self::DECIMALES);
            $importe_adicional = round(($importe_adicional - ($importe_diginidad_3)), self::DECIMALES);
        }

        $importes_energia['dignidad_base'] = $importe_diginidad_1;
        $importes_energia['dignidad_compl'] = $importe_diginidad_2 + $importe_diginidad_3;
        $importes_energia['fijo'] = $importe_fijo;
        $importes_energia['intermedio'] = $importe_intermedio;
        $importes_energia['adicional'] = $importe_adicional;
        $importes_energia['demanda'] = $importe_demanda;
        $importes_energia['total'] = $importe_fijo + $importe_intermedio + $importe_adicional + $importe_demanda;

        return $importes_energia;
    }

    public function getImportesLiberados($lectura, $conf_energia, $importe_total)
    {
        $importe_aseo = round(($importe_total * 0.87 * $conf_energia->Aseo), self::DECIMALES);
        $importe_alumbrado = round(($importe_total * 0.87 * $conf_energia->Alumbrado), self::DECIMALES);

        if ($lectura->abonado->Liberacion_Servicio == self::SIN_ASEO) {
            $importe_aseo = 0;
        }

        if ($lectura->abonado->Liberacion_Servicio == self::SIN_ALUMBRADO) {
            $importe_alumbrado = 0;
        }

        if ($lectura->abonado->Liberacion_Servicio == self::SIN_ASEO_NI_ALUMBRADO) {
            $importe_aseo = 0;
            $importe_alumbrado = 0;
        }

        return array($importe_aseo, $importe_alumbrado);
    }


}

?>
