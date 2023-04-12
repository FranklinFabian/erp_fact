function time_alert(type, title, message_html, timer = 3000) {
  return new Promise((resolve, reject) => {
    Swal.fire({
      position: "center",
      icon: type,
      title: title,
      html: message_html,
      showConfirmButton: false,
      timer: timer,
      timerProgressBar: true,
    }).then(() => resolve(true));
  });
}
function ok_alert(type, title, message_html) {
  return new Promise((resolve, reject) => {
    Swal.fire({
      position: "center",
      icon: type,
      title: title,
      html: message_html,
      confirmButtonText:
        '<i class="fa fa-check" aria-hidden="true"></i> Aceptar',
    }).then(() => resolve(true));
  });
}
function msg_confirmation(type, title, message_html) {
  return new Promise((resolve, reject) => {
    Swal.fire({
      title: title,
      html: message_html,
      icon: type,
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText:
        '<i class="fa fa-check" aria-hidden="true"></i> Aceptar',
      cancelButtonText:
        '<i class="fa fa-close" aria-hidden="true"></i> Cancelar',
    }).then((result) => {
      if (result.value) resolve(true);
      resolve(false);
    });
  });
}
function ok_alert_error(error = {}) {
  ok_alert("error", "Error!", "Ocurrio un error, intente nuevamente.").then(
    () => console.log({ error })
  );
}
const swloading = {
  start: (message) => {
    Swal.fire({
      title: message ? message : 'Procesando.',
      allowOutsideClick: false,
    });
    Swal.showLoading();
  },
  stop: () => {
    Swal.close();
  },
  html: (data) =>{
    const container = Swal.getHtmlContainer();
    Swal.update({
      html: container.innerHTML + '<br>' + data,
    });
    Swal.showLoading();
  }
};

function convertYmdTodmY(date) {
  return date.split('-').reverse().join('/');
}
$(".flotantes2decimales").on("keyup", function () {
  var regex = /^\d+(\.\d{0,2})?$/g;
  if (!regex.test(this.value))
    this.value = this.value.substring(0, this.value.length - 1);
});
$(".flotantes4decimales").on("keyup", function () {
  var regex = /^\d+(\.\d{0,4})?$/g;
  if (!regex.test(this.value))
    this.value = this.value.substring(0, this.value.length - 1);
});
$(".flotantes6decimales").on("keyup", function () {
  var regex = /^\d+(\.\d{0,6})?$/g;
  if (!regex.test(this.value))
    this.value = this.value.substring(0, this.value.length - 1);
});

function getMonthName(number) {
  const month = (number + 1).toString().padStart(2, '0')
  return MONTH_NAMES[month];
}

const DATA_TABLE = {
  ordering: false,
  language: {
    decimal: "",
    emptyTable: "No hay información",
    info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
    infoEmpty: "Mostrando 0 to 0 of 0 Entradas",
    infoFiltered: "(Filtrado de _MAX_ total entradas)",
    infoPostFix: "",
    thousands: ",",
    lengthMenu: "Mostrar _MENU_ Entradas",
    loadingRecords: "Cargando...",
    processing: "Procesando...",
    search: "Buscar:&nbsp;&nbsp; ",
    zeroRecords: "No se encontraron resultados.",
    paginate: {
      first: "Primero",
      last: "Ultimo",
      next: "Siguiente",
      previous: "Anterior",
    },
  },
  lengthMenu: [
    [10, 25, 50, -1],
    [10, 25, 50, "All"],
  ],
  // order: [0, 'arc'],
};
const DATA_TABLE_BUTTONS = (name, columns) => ({
  ...DATA_TABLE,
  dom: "<'row'<'col-sm-4'l><'col-sm-4 d-flex-center'B><'col-sm-4'f>>tp",
  buttons: [
    {
      extend: "copy",
      className: "btn-sm prints",
    },
    /* {
          extend: "csv",
          title: name,
          className: "btn-sm prints",
          exportOptions: {
              columns: columns,
              modifier: {
                  page: "all",
              },
          },
      }, */
    {
      extend: "excel",
      title: name,
      className: "btn-sm mb-1 prints",
      exportOptions: {
        columns: columns,
        modifier: {
          page: "all",
        },
      },
    },
    {
      extend: "pdf",
      title: name,
      className: "btn-sm prints",
      exportOptions: {
        columns: columns,
        modifier: {
          page: "all",
        },
      },
    },
    {
      extend: "print",
      title: name,
      className: "btn-sm prints",
      exportOptions: {
        columns: columns,
        modifier: {
          page: "all",
        },
      },
    },
  ],
});
