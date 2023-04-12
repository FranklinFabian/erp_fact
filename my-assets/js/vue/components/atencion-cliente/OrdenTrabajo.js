var v = new Vue({
    el: '#ordenTrabajo',
    data: {
        costoServicioError: '',
        formAbonado: false,
        cliente: [],
        clienteSel: [],
        abonado: '',
        abonados: [],
        abonadoSel: {
            categoria: '',
        },
        servicios: [],
        ordenes: [],
        nuevaOrden: {
            costo: '',
            servicio: 1, //por default el Id=1 servicio Para conexion
            observacion: '',
        },
        ordenSel: {
            fecha_ini: '',
            fecha_fin: '',
            tiempo: '',
        },
        fecha_conexion: '',
        orden: [],
        conexionSel: {
            fecha_ini: '',
            fecha_fin: '',
            tiempo: '',
        },
        conexiones: [],
    },
    created() {
        this.getServicios();
    },
    methods: {
        calculateTime(fecha_ini, fecha_fin) {
            days = moment(moment(fecha_fin).diff(moment(fecha_ini), 'days'));
            hours = moment(moment(fecha_fin).diff(moment(fecha_ini))).format("HH");
            minutes = moment(moment(fecha_fin).diff(moment(fecha_ini))).format("mm");
            return days + 'd ' + hours + 'h ' + minutes + 'm';
        },
        getTime(val) {
            v.ordenSel.fecha_fin = val;
            v.ordenSel.tiempo = this.calculateTime(v.ordenSel.fecha_ini, v.ordenSel.fecha_fin);
        },
        getTimeConexion(val) {
            v.conexionSel.fecha_fin = val;
            v.conexionSel.tiempo = this.calculateTime(v.conexionSel.fecha_ini, v.conexionSel.fecha_fin);
        },
        checkCliente(group) {
            this.group = group;
            this.formAbonado = true;
            this.clienteSel = group.selectedObject;
            this.getAbonados();
        },
        getOrdenes() {
            axios.get(BASE_URL_REST + 'AtencionCliente/ordenes_por_abonado/' + this.abonado)
                .then(function (response) {
                    v.ordenes = response.data;
                })
        },
        getConexiones() {
            axios.get(BASE_URL_REST + 'AtencionCliente/conexiones_por_abonado/' + this.abonado)
                .then(function (response) {
                    v.conexiones = response.data;
                })
        },
        getAbonado() {
            axios.get(BASE_URL_REST + 'AtencionCliente/abonado/' + this.abonado)
                .then(function (response) {
                    v.abonadoSel = response.data;
                    v.getOrdenes();
                })
        },
        getAbonados() {
            let abs = [];
            axios.get(BASE_URL_REST + 'AtencionCliente/abonados_por_cliente/' + this.clienteSel.Id_Cliente)
                .then(function (response) {
                    abs = response.data;
                    if (!_.isEmpty(abs)) {
                        v.abonados = abs;
                        v.abonado = abs[0].Id_Abonado;
                        v.getAbonado();
                        v.getOrdenes();
                    } else {
                        v.formAbonado = false;
                        v.clearAll();
                    }
                })
        },
        getServicios() {
            axios.get(BASE_URL_REST + 'Admin/servicios').then(function (response) {
                v.servicios = response.data;
            })
        },
        getCosto() {
            axios.get(BASE_URL_REST + 'Admin/costo_servicio/' + this.nuevaOrden.servicio)
                .then(function (response) {
                    if (response.data.error){
                        v.costoServicioError = response.data.error;
                    }else {
                        if(response.data.Costo) {
                            v.nuevaOrden.costo = response.data.Costo;
                        }else{
                            v.nuevaOrden.costo = 0;
                        }
                    }
                })
        },
        modalOrden(id) {
            axios.get(BASE_URL_REST + 'AtencionCliente/orden/' + id)
                .then(function (response) {
                    v.orden = response.data;
                    v.ordenSel.fecha_ini = v.orden.Fecha_Inicio;
                    v.ordenSel.fecha_fin = moment().format("YYYY-MM-DD HH:mm:ss"); // default the same date
                });
            $('#modalProcesarOrden').modal('show')
        },
        saveOrden(data) {
            return axios.post(BASE_URL_REST + "AtencionCliente/orden", data)
                .then(function (response) {
                    return response.data.data;
                })
                .catch(function (error) {
                    return 'An error occured..' + error;
                })
        },
        updateOrdenProcesada(data) {
            return axios.post(BASE_URL_REST + "AtencionCliente/procesar_orden", data)
                .then(function (response) {
                    return response.data.data;
                })
                .catch(function (error) {
                    return 'An error occured..' + error;
                })
        },
        agregarOrden() {
            var formData = this.formData(this.nuevaOrden);
            formData.append('abonado', v.abonado);
            formData.append('fecha_inicio', moment.utc().format("YYYY-MM-DD HH:mm:ss"));
            formData.append('cobrado', 'NO');
            formData.append('estado', 'SOLICITADO');

            v.saveOrden(formData).then(function (response) {
                $('#modalOrden').modal('hide');
                v.clearNuevaOrden();
                v.getOrdenes();
            });
        },
        procesarOrden() {
            var formData = new FormData();
            formData.append('id_orden', v.orden.Id_Orden);
            formData.append('fecha_fin', v.ordenSel.fecha_fin);
            formData.append('tiempo_trabajo', v.ordenSel.tiempo);
            formData.append('empleado', 1); //TODO completar con el correcto empleado
            formData.append('estado', 'EFECTUADO');

            v.updateOrdenProcesada(formData).then(function (response) {
                $('#modalProcesarOrden').modal('hide');
                v.getOrdenes();
            });
        },
        modalCrearConexion(id) {
            axios.get(BASE_URL_REST + 'AtencionCliente/orden/' + id)
                .then(function (response) {
                    v.orden = response.data;
                    v.ordenSel.fecha_ini = v.orden.Fecha_Inicio;
                    v.ordenSel.fecha_fin = v.orden.Fecha_Fin;
                    v.ordenSel.tiempo = v.orden.Tiempo_Trabajo;
                });
            $('#modalCrearConexion').modal('show')
        },
        crearConexion() {
            var formData = new FormData();
            formData.append('id_orden', v.orden.Id_Orden);
            formData.append('estado', 'FINALIZADO');
            axios.post(BASE_URL_REST + "AtencionCliente/orden", formData)
                .then(function (response) {
                    var formData = new FormData();
                    formData.append('orden', v.orden.Id_Orden);
                    formData.append('abonado', v.abonado);
                    formData.append('empleado', 1); //TODO completar con el correcto empleado
                    formData.append('fecha_inicio', v.ordenSel.fecha_ini);
                    formData.append('tiempo_trabajo', v.ordenSel.tiempo);
                    formData.append('costo', v.orden.Costo);
                    formData.append('estado', 'SOLICITADO');
                    axios.post(BASE_URL_REST + "AtencionCliente/conexion", formData)
                        .then(function (response) {
                            $('#modalCrearConexion').modal('hide');
                            v.getOrdenes();
                        })
                })
        },
        modalProcesarConexion(id) {
            axios.get(BASE_URL_REST + 'AtencionCliente/conexion_por_orden/' + id)
                .then(function (response) {
                    v.conexion = response.data;
                    v.ordenSel.fecha_ini = v.conexion.orden.Fecha_Inicio;
                    v.ordenSel.fecha_fin = v.conexion.orden.Fecha_Fin;
                    v.ordenSel.tiempo = v.conexion.orden.Tiempo_Trabajo;
                    v.conexionSel.fecha_ini = v.conexion.Fecha_Inicio;
                    v.conexionSel.fecha_fin = v.conexion.Fecha_Fin;
                    v.conexionSel.tiempo = v.conexion.Tiempo_Trabajo;
                });
            $('#modalProcesarConexion').modal('show')
        },
        procesarConexion() {
            var formData = new FormData();
            formData.append('id_conexion', v.conexion.Id_Conexion);
            formData.append('fecha_fin', v.ordenSel.fecha_fin);
            formData.append('tiempo_trabajo', v.ordenSel.tiempo);
            formData.append('empleado', 1); //TODO completar con el correcto empleado
            formData.append('estado', 'EFECTUADO');

            axios.post(BASE_URL_REST + "AtencionCliente/conexion", formData)
                .then(function () {
                    $('#modalProcesarConexion').modal('hide');
                    v.getConexiones();
                    v.getAbonados();
                });
        },
        formData(obj) {
            var formData = new FormData();
            for (var key in obj) {
                formData.append(key, obj[key]);
            }
            return formData;
        },
        clearNuevaOrden() {
            v.nuevaOrden = {
                servicio: 1,
                observacion: '',
                costo: '',
            };
            // v.getCosto();
        },
        clearAll() {
            // v.abonados = [];
            // v.abonadoSel = [];
            // v.abonado = '';
            // v.ordenes = [];
            v.clearNuevaOrden();
        },
    },
});
