var count = 2;
var limits = 500;
var list = "<?php  echo json_encode($articulos) ?>";
//Add purchase input field
function additem(e) {
    var t =$("tbody#item tr").html();
    count++;
    count == limits ? alert("You have reached the limit of adding " + count + " inputs") : $("tbody#item").append("<tr>" + t + "</tr>")
}


function deleteRow(e) {
    var t = $("#table > tbody > tr").length;
    if (1 == t) alert("There only one row you can't delete.");
    else {
        var a = e.parentNode.parentNode;
        a.parentNode.removeChild(a)
    }
}

function deleteRowEdit(e) {
    var a = e.parentNode.parentNode;
    a.parentNode.removeChild(a)
}


const selects = document.querySelectorAll(".dont-select-me");
for (const select of selects) {
    select.addEventListener("change", function (event) {
        if (event.target === select) {
            const selectedOption = this.options[this.selectedIndex];
            const value2 = selectedOption.getAttribute("value2");
            console.log(value2);
        }
    });
}


function precio(event) {
    const select = event.target;
    const selectedOption = select.options[select.selectedIndex];
    const value2 = selectedOption.getAttribute("value2");
    const input = select.closest('tr').querySelector('input[name="costo[]"]');
    input.value = value2;
    calcular(input);

}

function calcular(val){
    const inputCantidad = val.closest('tr').querySelector('input[name="cantidad[]"]');
    if(val.value  != '' && inputCantidad.value != '' ){
        console.log(inputCantidad.value * val.value );
        let inputTotal = val.closest('tr').querySelector('input[name="total[]"]');
        inputTotal.value = inputCantidad.value * val.value;
    }
}

function calcular2(val){
    const inputCantidad = val.closest('tr').querySelector('input[name="costo[]"]');
    if(val.value  != '' && inputCantidad.value != '' ){
        console.log(inputCantidad.value * val.value );
        let inputTotal = val.closest('tr').querySelector('input[name="total[]"]');
        inputTotal.value = inputCantidad.value * val.value;
    }
}
