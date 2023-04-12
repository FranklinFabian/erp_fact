<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class AtencionCliente extends RestController
{
    const CUENTA_NORMAL = 'CUENTA NORMAL';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Atcl_Abonado_model');
        $this->load->model('Atcl_Cliente_model');
        $this->load->model('Atcl_Orden_model');
        $this->load->model('Atcl_Conexion_model');
        $this->load->model('Atcl_Lectura_model');
        $this->load->model('Sis_Servicio_model');
        $this->load->model('Fact_Categoria_model');
        $this->load->model('Fact_Emision_model');
        $this->load->model('Users');
    }

    public function orden_get($id = null)
    {
        $orden = Atcl_Orden_model::find($id);

        $this->response($orden, RestController::HTTP_OK);
    }

    public function ordenes_get($id = null)
    {
        $clientes = Atcl_Orden_model::with('abonado')->get();

        $this->response($clientes, RestController::HTTP_OK);
    }

    public function ordenes_por_abonado_get($id_abonado = null)
    {
        $ordenes = Atcl_Orden_model::with('servicio')
            ->where('Abonado', $id_abonado)
            ->orderBy('Id_Orden', 'asc')
            ->get();

        $this->response($ordenes, RestController::HTTP_OK);
    }

    public function orden_post()
    {
//        $this->output->enable_profier(TRUE);
        $id_orden = $this->post('id_orden');
        if ($id_orden) {
            $orden = Atcl_Orden_model::find($id_orden);
            $orden->_Actualizado_Por = $this->session->user_id;
            $msg = 'Registro actualizado correctamente.';
        } else {
            $orden = new Atcl_Orden_model();
            $orden->_Creado_Por = $this->session->user_id;
            $msg = 'Registro agregado correctamente.';
        }

        ($this->post('abonado') != null) ? $orden->Abonado = $this->post('abonado') : '';
        ($this->post('servicio') != null) ? $orden->Servicio = $this->post('servicio') : '';
        ($this->post('empleado') != null) ? $orden->Empleado = $this->post('empleado') : '';
        ($this->post('fecha_inicio') != null) ? $orden->Fecha_Inicio = $this->post('fecha_inicio') : '';
        ($this->post('fecha_fin') != null) ? $orden->Fecha_Fin = $this->post('fecha_fin') : '';
        ($this->post('tiempo_trabajo') != null) ? $orden->Tiempo_Trabajo = $this->post('tiempo_trabajo') : '';
        ($this->post('costo') != null) ? $orden->Costo = $this->post('costo') : '';
        ($this->post('observacion') != null) ? $orden->Observacion = $this->post('observacion') : '';
        ($this->post('cobrado') != null) ? $orden->Cobrado = $this->post('cobrado') : '';
        ($this->post('estado') != null) ? $orden->Estado = $this->post('estado') : '';


        $chk = $orden->save();

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

    public function procesar_orden_post()
    {
        $id_orden = $this->post('id_orden');
        $orden = Atcl_Orden_model::find($id_orden);
        $orden->_Actualizado_Por = $this->session->user_id;
        $msg = 'Registro actualizado correctamente.';

        $orden->Empleado = $this->post('empleado');
        $orden->Fecha_Fin = $this->post('fecha_fin');
        $orden->Tiempo_Trabajo = $this->post('tiempo_trabajo');
        $orden->Estado = $this->post('estado');

        $chk = $orden->save();

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

    public function conexion_post()
    {
        $id_conexion = $this->post('id_conexion');
        if ($id_conexion) {
            $orden = Atcl_Conexion_model::find($id_conexion);
            $orden->_Actualizado_Por = $this->session->user_id;
            $msg = 'Registro actualizado correctamente.';
        } else {
            $orden = new Atcl_Conexion_model();
            $orden->_Creado_Por = $this->session->user_id;
            $msg = 'Registro agregado correctamente.';
        }

        ($this->post('abonado') != null) ? $orden->Abonado = $this->post('abonado') : '';
        ($this->post('orden') != null) ? $orden->Orden = $this->post('orden') : '';
        ($this->post('empleado') != null) ? $orden->Empleado = $this->post('empleado') : '';
        ($this->post('fecha_inicio') != null) ? $orden->Fecha_Inicio = $this->post('fecha_inicio') : '';
        ($this->post('fecha_fin') != null) ? $orden->Fecha_Fin = $this->post('fecha_fin') : '';
        ($this->post('tiempo_trabajo') != null) ? $orden->Tiempo_Trabajo = $this->post('tiempo_trabajo') : '';
        ($this->post('costo') != null) ? $orden->Costo = $this->post('costo') : '';
        ($this->post('observacion') != null) ? $orden->Observacion = $this->post('observacion') : '';
        ($this->post('cobrado') != null) ? $orden->Cobrado = $this->post('cobrado') : '';
        ($this->post('estado') != null) ? $orden->Estado = $this->post('estado') : '';

        $chk = $orden->save();

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

    public function conexiones_por_abonado_get($id_abonado = null)
    {
        $conexiones = Atcl_Conexion_model::where('Abonado', $id_abonado)->get();

        $this->response($conexiones, RestController::HTTP_OK);
    }

    public function conexion_por_orden_get($id_orden = null)
    {
        $conexion = Atcl_Conexion_model::with('orden')
            ->where('Orden', $id_orden)
            ->get()
            ->first();

        $this->response($conexion, RestController::HTTP_OK);
    }

    public function clientes_get($search = null)
    {
//        $this->response($this->Users->getUsers($search), RestController::HTTP_OK);
        $clientes = Atcl_Cliente_model::where('Codigo', $search);
        if ($search != null) {
            $clientes = $clientes->orWhere('Nombres', 'like', '%' . $search . '%');
        }
        $clientes = $clientes->get();

        $this->response($clientes, RestController::HTTP_OK);
    }

    public function cliente_post()
    {
        $id_cliente = $this->post('Id_Cliente');
        if ($id_cliente) {
            $cliente = Atcl_Cliente_model::find($id_cliente);
            $cliente->_Actualizado_Por = $this->session->user_id;
            $msg = 'Registro actualizado correctamente.';
        } else {
            $cliente = new Atcl_Cliente_model();
            $cliente->_Creado_Por = $this->session->user_id;
            $msg = 'Registro agregado correctamente.';
        }

        $cliente->Codigo = $this->post('codigo');
        $cliente->Nombres = $this->post('nombres');
        $cliente->Nit = $this->post('nit');
        $cliente->Fecha_Nacimiento = $this->post('fecha_nacimiento');
        $cliente->Telefono = $this->post('telefono');

        $chk = $cliente->save();

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

    public function abonado_get($id = null)
    {
        $this->response(Atcl_Abonado_model::with('categoria')->find($id), RestController::HTTP_OK);
    }

    public function abonado_full_get($id = null)
    {
        $this->response(Atcl_Abonado_model::with('categoria', 'cliente', 'lecturas.emision')->find($id),
            RestController::HTTP_OK);
    }

    public function abonados_por_zona_get($id_zona)
    {
        $abonados = Atcl_Abonado_model::where('Zona', $id_zona)
            ->where('Estado_Abonado', self::CUENTA_NORMAL)
            ->get();
        $this->response($abonados, RestController::HTTP_OK);
    }

    public function abonados_por_cliente_get($id_cliente)
    {
        $abonados = Atcl_Abonado_model::where('Cliente', $id_cliente)->get();
        $this->response($abonados, RestController::HTTP_OK);
    }

    public function abonado_post()
    {
        $id_abonado = $this->post('Id_Abonado');
        if ($id_abonado) {
            $abonado = Atcl_Abonado_model::find($id_abonado);
            $abonado->_Actualizado_Por = $this->session->user_id;
            $msg = 'Registro actualizado correctamente.';
        } else {
            $abonado = new Atcl_Abonado_model();
            $abonado->_Creado_Por = $this->session->user_id;
            $msg = 'Registro agregado correctamente.';
        }

        ($this->post('cliente') != null) ? $abonado->Cliente = $this->post('cliente') : '';
        ($this->post('categoria') != null) ? $abonado->Categoria = $this->post('categoria') : '';
        ($this->post('localidad') != null) ? $abonado->Localidad = $this->post('localidad') : '';
        ($this->post('zona') != null) ? $abonado->Zona = $this->post('zona') : '';
        ($this->post('calle') != null) ? $abonado->Calle = $this->post('calle') : '';
        ($this->post('numero') != null) ? $abonado->Numero = $this->post('numero') : '';
        ($this->post('centro') != null) ? $abonado->Centro = $this->post('centro') : '';
        ($this->post('poste') != null) ? $abonado->Poste = $this->post('poste') : '';
        ($this->post('distancia') != null) ? $abonado->Distancia = $this->post('distancia') : '';
        ($this->post('serie_medidor') != null) ? $abonado->Serie_Medidor = $this->post('serie_medidor') : '';
        ($this->post('lectura') != null) ? $abonado->Lectura = $this->post('lectura') : '';
        ($this->post('multiplicador') != null) ? $abonado->Multiplicador = $this->post('multiplicador') : '';
        ($this->post('tipo_suministro') != null) ? $abonado->Tipo_Suministro = $this->post('tipo_suministro') : '';
        ($this->post('tipo_consumidor') != null) ? $abonado->Tipo_Consumidor = $this->post('tipo_consumidor') : '';
        ($this->post('tipo_medicion') != null) ? $abonado->Tipo_Medicion = $this->post('tipo_medicion') : '';
        ($this->post('tipo_liberacion') != null) ? $abonado->Tipo_Liberacion = $this->post('tipo_liberacion') : '';

        $chk = $abonado->save();

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

    public function lectura_post()
    {
        $id_lectura = $this->post('id_lectura');
        if ($id_lectura) {
            $lectura = Atcl_Lectura_model::find($id_lectura);
            $lectura->_Actualizado_Por = $this->session->user_id;
            $msg = 'Registro actualizado correctamente.';
        } else {
            $lectura = new Atcl_Lectura_model();
            $lectura->_Creado_Por = $this->session->user_id;
            $msg = 'Registro agregado correctamente.';
        }

        ($this->post('abonado') != null) ? $lectura->Abonado = $this->post('abonado') : '';
        ($this->post('emision') != null) ? $lectura->Emision = $this->post('emision') : '';
        ($this->post('categoria') != null) ? $lectura->Categoria = $this->post('categoria') : '';
        ($this->post('contador') != null) ? $lectura->Contador = $this->post('contador') : '';
        ($this->post('lectura_anterior') != null) ? $lectura->Lectura_Anterior = $this->post('lectura_anterior') : '';
        ($this->post('lectura_actual') != null) ? $lectura->Lectura_Actual = $this->post('lectura_actual') : '';
        ($this->post('estimado') != null) ? $lectura->Estimado = $this->post('estimado') : '';
        ($this->post('multiplicador') != null) ? $lectura->Multiplicador = $this->post('multiplicador') : '';
        ($this->post('consumo_actual') != null) ? $lectura->Consumo_Actual = $this->post('consumo_actual') : '';
        ($this->post('potencia') != null) ? $lectura->Potencia = $this->post('potencia') : '';
        ($this->post('importe_fijo') != null) ? $lectura->Importe_Fijo = $this->post('importe_fijo') : '';
        ($this->post('importe_adicional') != null) ? $lectura->Importe_Adicional = $this->post('importe_adicional') : '';
        ($this->post('importe_potencia') != null) ? $lectura->Importe_Potencia = $this->post('importe_potencia') : '';
        ($this->post('importe_total') != null) ? $lectura->Importe_Total = $this->post('importe_total') : '';
        ($this->post('importe_conexion') != null) ? $lectura->Importe_Conexion = $this->post('importe_conexion') : '';
        ($this->post('importe_reposicion') != null) ? $lectura->Importe_Reposicion = $this->post('importe_reposicion') : '';
        ($this->post('importe_recargo') != null) ? $lectura->Importe_Recargo = $this->post('importe_recargo') : '';
        ($this->post('importe_formulario') != null) ? $lectura->Importe_Formulario = $this->post('importe_formulario') : '';
        ($this->post('importe_aseo') != null) ? $lectura->Importe_Aseo = $this->post('importe_aseo') : '';
        ($this->post('importe_alumbrado') != null) ? $lectura->Importe_Alumbrado = $this->post('importe_alumbrado') : '';
        ($this->post('importe_adm_1') != null) ? $lectura->Importe_ADM_1 = $this->post('importe_adm_1') : '';
        ($this->post('importe_adm_2') != null) ? $lectura->Importe_ADM_2 = $this->post('importe_adm_2') : '';
        ($this->post('importe_dignidad_1') != null) ? $lectura->Importe_Dignidad_1 = $this->post('importe_dignidad_1') : '';
        ($this->post('importe_dignidad_2') != null) ? $lectura->Importe_Dignidad_2 = $this->post('importe_dignidad_2') : '';
        ($this->post('devolucion') != null) ? $lectura->Devolucion = $this->post('devolucion') : '';
        ($this->post('usuario_lecturador') != null) ? $lectura->Usuario_Lecturador = $this->post('usuario_lecturador') : '';
        ($this->post('estado_pago') != null) ? $lectura->Estado_Pago = $this->post('estado_pago') : '';
        ($this->post('fecha_pago') != null) ? $lectura->Fecha_Pago = $this->post('fecha_pago') : '';
        ($this->post('comprobante') != null) ? $lectura->Comprobante = $this->post('comprobante') : '';
        ($this->post('devengado') != null) ? $lectura->Devengado = $this->post('devengado') : '';
        ($this->post('usuario_cobrador') != null) ? $lectura->Usuario_Cobrador = $this->post('usuario_cobrador') : '';
        ($this->post('observacion') != null) ? $lectura->Observacion = $this->post('observacion') : '';
        ($this->post('estado') != null) ? $lectura->Estado = $this->post('estado') : '';

        $chk = $lectura->save();

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

}
