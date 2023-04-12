var v = new Vue({
    el: '#factores',
    data: {
        emisiones: [],
        emision: null,
        factor: [],
        formValidate: [],
        successMSG: '',
    },
    created() {
        this.getEmisiones()
    },
    watch: {
        emision: function (value) {
            fetch(BASE_URL_REST + 'Facturacion/factor_by_emision/' + value)
                .then(response => response.json())
                .then(res => {
                    this.factor = res
                }, err => this.factor = [])
        }
    },
    methods: {
        getEmisiones() {
            fetch(BASE_URL_REST + 'Facturacion/emisiones')
                .then(response => response.json())
                .then(res => {
                    this.emisiones = res;
                    // console.log(res);
                })
        },
        addFactor() {
            var formData = v.formData(this.factor);
            formData.append('emision', this.emision);

            axios.post(BASE_URL_REST + "Facturacion/factores", formData)
                .then(response => {
                    if (response.data.error) {
                        console.log(response.data.msg);
                    } else {
                        // console.log(response.data.msg);
                        v.successMSG = response.data.msg;
                        this.factor = [];
                        this.emision = null;
                        v.formValidate = false;
                        v.clearMSG();
                    }
                })
                .catch(e => {
                    console.log(e);
                })
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
    }
});
