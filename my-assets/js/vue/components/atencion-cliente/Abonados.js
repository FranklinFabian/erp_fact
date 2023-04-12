var v = new Vue({
    el: '#abonados',
    data: {
        showListAbonado: false,
        showBtnAddAbonado: false,
        clienteSel: [],
        abonados: [],

        numero: '',
        distancia: '',
        serie_medidor: '',
        lectura: '',
        multiplicador: '',
        cliente: '',
        categoria: 4,
        localidad: 1, //1: ATOCHA
        zona: 1,
        calle: 1,
        centro: 1,
        poste: 1,
        tipo_suministro: 1,
        tipo_consumidor: 1,
        tipo_medicion: 1,
        tipo_liberacion: 1,

        clientes:  [],
        categorias: [],
        localidades: [],
        zonas: [],
        calles: [],
        centros: [],
        postes: [],
        tipo_suministros: [],
        tipo_consumidores: [],
        tipo_mediciones: [],
        tipo_liberaciones: [],

        formValidate: [],
        successMSG: '',
    },
    created() {
        this.getCategorias();
        this.getLocalidades();
        this.getZonas();
        this.getCalles();
        this.getCentros();
        this.getPostes();
        this.getTipoSuministros();
        this.getTipoConsumidores();
        this.getTipoMediciones();
        this.getTipoLiberacionesServicios();
    },
    methods: {
        checkCliente(group) {
            this.group = group;
            this.clienteSel = group.selectedObject;
            this.getAbonados();
        },
        getAbonados() {
            let abs = [];
            v.showBtnAddAbonado = true;
            axios.get(BASE_URL_REST + 'AtencionCliente/abonados_por_cliente/' + this.clienteSel.Id_Cliente)
                .then(function (response) {
                    abs = response.data;
                    if (!_.isEmpty(abs)) {
                        v.abonados = abs;
                        v.showListAbonado = true;
                    } else {
                        v.showListAbonado = false;
                    }
                })
        },
        getCategorias() {
            fetch(BASE_URL_REST + 'Facturacion/categorias')
                .then(response => response.json())
                .then(res => {
                    this.categorias = res;
                })
        },
        getLocalidades() {
            fetch(BASE_URL_REST + 'Admin/localidades')
                .then(response => response.json())
                .then(res => {
                    this.localidades = res;
                })
        },
        getZonas() {
            fetch(BASE_URL_REST + 'Admin/zonas_by_localidad/' + this.localidad)
                .then(response => response.json())
                .then(res => {
                    this.zonas = res;
                })
        },
        getCalles() {
            fetch(BASE_URL_REST + 'Admin/calles_by_zona/' + this.zona)
                .then(response => response.json())
                .then(res => {
                    this.calles = res;
                })
        },
        getCentros() {
            fetch(BASE_URL_REST + 'Admin/centros_by_localidad/' + this.localidad)
                .then(response => response.json())
                .then(res => {
                    this.centros = res;
                })
        },
        getPostes() {
            fetch(BASE_URL_REST + 'Admin/postes_by_centro/' + this.centro)
                .then(response => response.json())
                .then(res => {
                    this.postes = res;
                })
        },
        getTipoSuministros() {
            fetch(BASE_URL_REST + 'Admin/tipo_suministros/')
                .then(response => response.json())
                .then(res => {
                    this.tipo_suministros = res;
                })
        },
        getTipoConsumidores() {
            fetch(BASE_URL_REST + 'Admin/tipo_consumidores/')
                .then(response => response.json())
                .then(res => {
                    this.tipo_consumidores = res;
                })
        },
        getTipoMediciones() {
            fetch(BASE_URL_REST + 'Admin/tipo_mediciones/')
                .then(response => response.json())
                .then(res => {
                    this.tipo_mediciones = res;
                })
        },
        getTipoLiberacionesServicios() {
            fetch(BASE_URL_REST + 'Admin/tipo_liberaciones_servicios/')
                .then(response => response.json())
                .then(res => {
                    this.tipo_liberaciones = res;
                })
        },
        addAbonado(){
            var formData = new FormData();
            formData.append('cliente', v.clienteSel.Id_Cliente);
            formData.append('categoria', v.categoria);
            formData.append('localidad', v.localidad);
            formData.append('zona', v.zona);
            formData.append('calle', v.calle);
            formData.append('numero', v.numero);
            formData.append('centro', v.centro);
            formData.append('poste', v.poste);
            formData.append('distancia', v.distancia);
            formData.append('serie_medidor', v.serie_medidor);
            formData.append('lectura', v.lectura);
            formData.append('multiplicador', v.multiplicador);
            formData.append('tipo_suministro', v.tipo_suministro);
            formData.append('tipo_consumidor', v.tipo_consumidor);
            formData.append('tipo_medicion', v.tipo_medicion);
            formData.append('tipo_liberacion', v.tipo_liberacion);

            axios.post(BASE_URL_REST + "AtencionCliente/abonado", formData)
                .then(function () {
                    v.getAbonados();
                    $('#modalAgregarAbonado').modal('hide');
                });
        },
        formData(obj) {
            var formData = new FormData();
            for (var key in obj) {
                formData.append(key, obj[key]);
            }
            return formData;
        },
        clearMSG() {
            setTimeout(function () {
                v.successMSG = ''
            }, 3000); // disappearing message success in 2 sec
        },
    },
});
