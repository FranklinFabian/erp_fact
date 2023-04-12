  var count = 2;
    var limits = 500;

    //Add purchase input field
    function additem(e) {
        var t = $("tbody#item tr").html();
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
