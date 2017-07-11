$(document).ready(function() {

function getURLParameter(name) {
  return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search) || [null, ''])[1].replace(/\+/g, '%20')) || null;
}

    var query = getURLParameter('q');
    var userLib = getURLParameter('user');

    var count = 1;
    var url = "./pr2.php?https://www.4shared.com/all-images/" + query;
 
        getUserName(userLib);
        loadMore(1, url);
   

    function loadMore(urlCount, urlBase) {
        $.get(urlBase + "?page=" + urlCount, function(data) {
          //  console.log(jQuery.parseJSON(data));

            data = JSON.parse(data);

           // console.log(data.children);
            var imageObject = {};
            var nextLink = "";
            $.each(data.children, function(key, value) {
              //  console.log(key);
                if (typeof value.children == "undefined") {
                    if (value.tag == "a") {
                      //  console.log(value.href);
                        nextLink = value.href;
                    } else {
                     //   console.log("skip");
                    }
                } else {
                  //  console.log(value.children[0].children[2]);
                    imageObject[key] = value.children[0].children[2];
                   
                }
            });
         //   console.log(imageObject);


            var html = "";
            var image = "";
            var user = "";
            var library = "";
            var profile = "";
            var tempImg = "";
            
            $.each(imageObject, function(key, value) {
                tempImg = value.src;
                image = value.src;
                tempImg = tempImg.replace(/\/[s][0-9][0-9]\//, "/");
               
                html += "<div class='row'>";
                html += "<div class='cell5'><div class='image'><a href='" + image + "' target='_blank'><img src='" + tempImg + "'></a></div>";
                html += "</div></div>";
            });

            $("div.filler").append(html);
            if(nextLink != ""){
              loadMore(urlCount + 1, url);
            }

        });


    }

    function getUserName(libURL){
    	$.get("../pr4.php?" + libURL, function(data){
    		try{
				 data = JSON.parse(data);
				console.log(data.children[0].children[0].html);
				var name = data.children[0].children[0].html;
				
				$('.top').append('<div>User Name: ' + name + '</div><div><a href="' + userLib + '" target="_blank">View Library on 4Shared</a></div>');
    		} catch (e){console.log(e);}
    	});
    
    }
});