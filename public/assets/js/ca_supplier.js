

$("#ca_supplier").on('change',function(e){
  e.preventDefault();
  var set_year_ca_supplier = $("#ca_supplier").val();

  $.ajax({
    url: "/set_year_ca_supplier",
    type: "POST",
    data: {set_year_ca_supplier: set_year_ca_supplier},
    success: function(data) {
        $('#piechart_3d').html(" ")
       var table_ca_sup = data;

       if (data.length != 0) {

        ca_supplier(table_ca_sup);
       }
    },
    error: function(xhr, status, error) {
        console.log('Erreur AJAX : ' + error);
    }
});
})

const ca_supplier = (table_ca_sup) => {

    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart(table_ca_sup));
    function drawChart(table_ca_sup) {

        var data = [
            ['Fournisseur', 'Ca']
          ];

        for(i = 0;i<=table_ca_sup.length - 1;i++){

            var insert_ca = parseFloat(table_ca_sup[0]["ca_supplier"])

            data.push([`${table_ca_sup[i]["supName"] + " - " + table_ca_sup[i]["supRef"] + " - " + insert_ca} €`,     insert_ca])
            
            };
            var data_table = google.visualization.arrayToDataTable(data);

      var options = {
        title: 'Ca/Supplier',
        is3D: true,
      };

      var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
      chart.draw(data_table, options);
    }

}

