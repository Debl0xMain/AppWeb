var cli_pro = parseInt($("#cli_pro").val());
var cli_par = parseInt($("#cli_par").val());
// cli_pro cli_par

$("#select_year_ca_type").on('change',function(e){
  e.preventDefault();
  var select_year_ca_type = $("#select_year_ca_type").val();

  $.ajax({
    url: "/ajax_ca_year",
    type: "POST",
    data: {select_year_ca_type: select_year_ca_type},
    success: function(data) {
        client_ajax_reponse = JSON.parse(data);
        cli_pro = client_ajax_reponse.cli_pro[0][1];
        cli_par =  client_ajax_reponse.cli_par[0][1];
        if (cli_pro == undefined){ cli_pro = 0};
        if (cli_par == undefined){ cli_par = 0};
        graph_del_test(cli_pro,cli_par);
    },
    error: function(xhr, status, error) {
        console.log('Erreur AJAX : ' + error);
    }
});
})


const graph_del_test = (cli_pro,cli_par) => {
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = google.visualization.arrayToDataTable([
        ['Type', 'Hours per Day'],
        ['Pro', cli_pro],
        ['Particulier', cli_par],
      ]);

      var options = {
        title: 'Ca/Client'
      };

      var chart = new google.visualization.PieChart(document.getElementById('piechart'));

      chart.draw(data, options);
    }
}

graph_del_test(cli_pro,cli_par);