$(document).ready(function() {

function getURLParameter(name) {
  return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search) || [null, ''])[1].replace(/\+/g, '%20')) || null;
}

    var query = getURLParameter('q');


    var count = 1;
    var url = "./pr2.php?https://www.4shared.com/all-images/" + query;
 
        
        loadMore(1, url);
   

    function loadMore(urlCount, urlBase) {
        $.get(urlBase + "?page=" + urlCount, function(data) {
            console.log(jQuery.parseJSON(data));

            data = JSON.parse(data);

            console.log(data.children);
            var imageObject = {};
            var nextLink = "";
            $.each(data.children, function(key, value) {
                console.log(key);
                if (typeof value.children == "undefined") {
                    if (value.tag == "a") {
                        console.log(value.href);
                        nextLink = value.href;
                    } else {
                        console.log("skip");
                    }
                } else {
                    console.log(value.children[0].children[2]);
                    imageObject[key] = value.children[0].children[2];
                }
            });
            console.log(imageObject);


            var html = "";
            var image = "";
            var user = "";
            var library = "";
            var profile = "";
            $.each(imageObject, function(key, value) {
                image = value.src;
                html += "<div class='row'>";
                html += "<div class='cell5'><div class='image'><img src='" + image + "'></div>";
                html += "</div></div>";
            });

            $("div.filler").append(html);
            if(nextLink != ""){
              loadMore(urlCount + 1, url);
            }

        });


    }


});