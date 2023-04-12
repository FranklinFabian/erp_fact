export default {
    getLocalidades(succes, error) {
        console.log('hola');
        fetch(BASE_URL_REST + 'Facturacion/categorias')
            .then(response => response.json())
            .then(res => {
                succes = res;
            })
    },
}
