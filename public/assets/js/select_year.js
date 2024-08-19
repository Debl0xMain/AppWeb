
$("#select_year").on('change',function(e){
    e.preventDefault();
    var set_year = $("#select_year").val();

    $.ajax({
        url: "/ajax_stats_year",
        type: "POST",
        data: {set_year: set_year},
        success: function(data) {
  
            var m1_ajax = data[1];
            var m2_ajax = data[2];
            var m3_ajax = data[3];
            var m4_ajax = data[4];
            var m5_ajax = data[5];
            var m6_ajax = data[6];
            var m7_ajax = data[7];
            var m8_ajax = data[8];
            var m9_ajax = data[9];
            var m10_ajax = data[10];
            var m11_ajax = data[11];
            var m12_ajax = data[12];
            
            draw_graph_year(m1_ajax,m2_ajax,m3_ajax,m4_ajax,m5_ajax,m6_ajax,m7_ajax,m8_ajax,m9_ajax,m10_ajax,m11_ajax,m12_ajax);
        },
        error: function(xhr, status, error) {
            console.log('Refresh Page | Ajax Erreur')
        }
    });
})

var m1 = parseInt($("#0").val());
var m2 = parseInt($("#1").val());
var m3 = parseInt($("#2").val());
var m4 = parseInt($("#3").val());
var m5 = parseInt($("#4").val());
var m6 = parseInt($("#5").val());
var m7 = parseInt($("#6").val());
var m8 = parseInt($("#7").val());
var m9 = parseInt($("#8").val());
var m10 = parseInt($("#9").val());
var m11 = parseInt($("#10").val());
var m12 = parseInt($("#11").val());

const draw_graph_year = (m1,m2,m3,m4,m5,m6,m7,m8,m9,m10,m11,m12) => {

    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
            ['Mois', 'CA|€',{ role: "style" }],
            ['Janvier',  m1, "#ff0000"],
            ['Fevrier',  m2, "#ff69f5"],
            ['Mars',  m3, "#69feff"],
            ['Avril',  m4, "#bfbfbf"],
            ['Mai',  m5, "#69ff82"],
            ['Juin',  m6, "#e0e0e0"],
            ['Juillet',  m7, "#ff6e00"],
            ['Aout',  m8, "#00ff94"],
            ['Septembre',  m9, "#00c6ff"],
            ['Octobre',  m10, "#de91d1"],
            ['Novembre',  m11, "#f5f615"],
            ['Decembre',  m12, "#15f6ec"],
        ]);

        var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Chiffre d'Affaire HT/Mois",
        width: 600,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(view, options);
      }
    }
draw_graph_year(m1,m2,m3,m4,m5,m6,m7,m8,m9,m10,m11,m12);