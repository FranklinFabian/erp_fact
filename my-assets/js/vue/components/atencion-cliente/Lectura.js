Vue.component('v-pagination', window['vue-plain-pagination']);

const DEFAULT_LOCALIDAD = 1;
const DEFAULT_ZONA = 1;

var v = new Vue({
    el: '#lectura',
    data: {
        frmAbonado: true,

        localidades: [],
        zonas: [],
        localidad: DEFAULT_LOCALIDAD, //default
        zona: DEFAULT_ZONA,
        emision: '',
        id_emision: '',

        abonados: [],
        abonado: '',
        id_abonado : '',

        lanterior: '',
        lmultiplicador: '',
        lactual: '',
        lpotencia: '',
        lconsumo: '',

        currentPage: 1,
        pageCount: 0,
        bootstrapPaginationClasses: {
            ul: 'pagination',
            li: 'page-item',
            liActive: 'active',
            liDisable: 'disabled',
            button: 'page-link'
        },
    },
    created() {
        this.getLocalidades();
        this.getZonas();
        this.getEmisionActual();
    },
    watch: {
        currentPage: function (val) {
            this.getAbonado(v.abonados[val - 1].Id_Abonado);
        }
    },
    methods: {
        updateConsumo(e) {
            this.lconsumo = this.lactual - this.lanterior;
        },
        loadAbonados() {
            this.frmAbonado = true;
            this.getAbonados();
        },
        loadLectura() {
            this.lmultiplicador = this.abonado.Multiplicador;

            if (this.abonado.lecturas.length == 0) {
                this.lanterior = this.abonado.Lectura;
            } else {
                this.lanterior = this.abonado.lecturas[0].Lectura_Actual; //el primero ya que el modelo retorna ordenado descendemente
            }
        },
        getAbonado(id) {
            fetch(BASE_URL_REST + 'AtencionCliente/abonado_full/' + id)
                .then(response => response.json())
                .then(res => {
                    this.abonado = res;
                    this.id_abonado = this.abonado.Id_Abonado;
                    this.loadLectura();
                })
        },
        getAbonados() {
            // console.log('hola');
            fetch(BASE_URL_REST + 'AtencionCliente/abonados_por_zona/' + this.zona)
                .then(response => response.json())
                .then(res => {
                    this.abonados = res;
                    this.pageCount = v.abonados.length;

                    if (this.pageCount !== 0) {
                        this.getAbonado(this.abonados[0].Id_Abonado);
                    } else {
                        this.abonado = '';
                    }
                })
        },
        countAbonados() {
            fetch(BASE_URL_REST + 'AtencionCliente/abonados_por_zona/' + this.zona)
                .then(response => response.json())
                .then(res => {
                    this.abonados = res;
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
        getEmisionActual() {
            fetch(BASE_URL_REST + 'Facturacion/emision_actual')
                .then(response => response.json())
                .then(res => {
                    this.emision = res.Emision;
                    this.id_emision = res.Id_Emision;
                })
        },
        crearNuevaLectura() {
            var formData = new FormData();
            formData.append('abonado', this.id_abonado);
            formData.append('emision', this.id_emision);
            formData.append('categoria', this.abonado.Categoria);
            formData.append('contador', this.lactual);
            formData.append('lectura_actual', this.lactual);
            formData.append('lectura_anterior', this.lanterior);
            formData.append('multiplicador', this.lmultiplicador);//TODO preguntar si es por lectura el multiplicador
            // formData.append('estimado', this.lestimado); //TODO crear esta funcionalidad
            formData.append('consumo_actual', this.lconsumo);
            // formData.append('potencia', this.lpotencia);//TODO preguntar si es por lectura la potencia.
            axios.post(BASE_URL_REST + "AtencionCliente/lectura", formData)
                .then(function (response) {
                    v.clearLectura();
                    v.getAbonado(v.id_abonado);
                })
                .catch(function (err) {
                    console.log(err);
                })
        },
        clearLectura(){
            this.lanterior = '';
            this.lactual = '';
            this.lconsumo = '';
            this.lmultiplicador = '';
            this.lpotencia = '';
        },
        formData(obj) {
            var formData = new FormData();
            for (var key in obj) {
                formData.append(key, obj[key]);
            }
            return formData;
        },
    },
});
