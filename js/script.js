$ = jQuery;
 
var mafs = $("#my-ajax-filter-search"); 
var mafsForm = mafs.find("form"); 
 
mafsForm.submit(function(e){
    e.preventDefault(); 
 
    if(mafsForm.find("#search").val().length !== 0) {
        var search = mafsForm.find("#search").val();
    }
    if(mafsForm.find("#year").val().length !== 0) {
        var year = mafsForm.find("#year").val();
    }
    if(mafsForm.find("#status").val().length !== 0) {
        var status = mafsForm.find("#status").val();
    }

    var data = {
        action : "my_ajax_filter_search",
        search : search,
        status : status,
        year : year, 
    }

//jQuery Ajax Function
$.ajax({
        url : ajax_url,
        data : data,
        success : function(response) {
            mafs.find("#ajax_fitler_search_results").empty();
            if(response) {
                for(var i = 0 ;  i < response.length ; i++) {
                    var home = response[i].home_institution;
                    var host = response[i].host_institution;
                    var position = response[i].position;
                    var media = response[i].position;
                    var field = response[i].field;
                    var html  = "<div class='card " + "id-" + response[i].id + "'>";

                         html += "      <header><h3>" + response[i].title + "</h3></header>";
                         if (position !== null) { 
                            html += "          <p class='position'>" + position + "</p>";
                         }
                         html += "<ul class='card-content'>";
                         html += "    <li><strong>Year:</strong> " + response[i].year + "</li>";
                         html += "    <li><strong>Grant Category:</strong> " + response[i].status + "</li>";
                         if (field !== null) { 
                            html += "          <li><strong>Field:</strong> " + field + "</li>";
                         }
                         if (media !== null) { 
                            html += "          <li><strong>Media:</strong> " + media + "</li>";
                         }
                         if (home !== null) { 
                            html += "          <li><strong>Home institution:</strong> " + home + "</li>";
                         }
                         if (host !== null) { 
                            html += "          <li><strong>Host institution:</strong> " + host + "</li>";
                         }
                         html += "</ul>";
                         html += "</div>";
                     mafs.find("#ajax_fitler_search_results").append(html);
                }
            } else {
                var html  = "<li class='no-result'>No matching grantees found. Try a different filter or search keyword</li>";
                mafs.find("#ajax_fitler_search_results").append(html);
            }
        } 
    });
});