$("#select_year_client_top").on('change',function(e){
    e.preventDefault();
    var select_year_client_top = $("#select_year_client_top").val();

    $.ajax({
        url: "/ajax_year_user_ca",
        type: "POST",
        data: {select_year_client_top: select_year_client_top},
        success: function(data) {


            top_client_ajax_reponse = JSON.parse(data);
            //tableau top10
          console.log(top_client_ajax_reponse)

            // check table
                let for_cli = top_client_ajax_reponse.length - 1
           // Show result in twig
                $('#top10_client').html(' ');
                for(let x = 0;x<=for_cli;x++){
                    $('#top10_client').append(`<p class='border case_height'>${top_client_ajax_reponse[x]["userName"]} ${top_client_ajax_reponse[x]["userFristName"]} <br> Ref : ${top_client_ajax_reponse[x]["userRef"]}</p>`)
                };

        },
        error: function(xhr, status, error) {
            console.log('Refresh Page | Ajax Erreur')
        }
    });
})