Vue.component('formulario', {
    template: `
    <div class="card detail-post">
        <h1>mi componente formulario</h1>
    </div>`,
    data: function () {
        return {
        }
    },
    created() {
    },
    methods: {
    }
});

var invoice = new Vue({
    el: "#app-invoice",
    // router,
    data: {
        message: 'Hola Vue!'
    }
});
