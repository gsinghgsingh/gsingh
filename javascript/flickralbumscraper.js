$(document).ready(function() {

function getURLParameter(name) {
  return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search) || [null, ''])[1].replace(/\+/g, '%20')) || null;
}

    var query = getURLParameter('q');


    var count = 1;
    var api_key = "api_key=6bf52f197b492b2b6bfe860161eeaf";
    var user_id = query;
    var url = "./pr.php?https://api.flickr.com/services/rest/?method=flickr.people.getPublicPhotos&api_key=6bf52f197b492b2b6bfe860161eeafde&user_id=" + user_id + "&safe_search=3&per_page=500&format=json&nojsoncallback=1";
 
        
        loadMore(1, url, 0);
   

    function loadMore(urlCount, urlBase, warning) {
        $.get(urlBase + "&page=" + urlCount, function(data) {
         if(data.photos.pages > 2 && data.photos.page == 2){
              	$("div.warning").append("<div>Warning - This gallery is HUGE. Only returning 1000 results. If you want more, view the photostream on Flickr <a href='https://www.flickr.com/photos/" + data.photos.photo[0].owner + "' target='_blank'>here</a>.</div>");
              }
            console.log(data);

         //   data = JSON.parse(data);

          
            var imageObject = data.photos.photo;
            var nextLink = "";
          
            console.log(imageObject);


            var html = "";
            var image = "";
            var imageThumb = "";
            var user = "";
            var library = "";
            var profile = "";
            var tempImg = "";
            
            $.each(imageObject, function(key, value) {
               
                imageThumb = "https://farm" + value.farm + ".staticflickr.com/" + value.server + "/" + value.id + "_" + value.secret + "_m.jpg";
                image = "https://farm" + value.farm + ".staticflickr.com/" + value.server + "/" + value.id + "_" + value.secret + "_h.jpg";
               
                html += "<div class='row'>";
                html += "<div class='cell5'><div class='image'><a href='" + image + "' target='_blank'><img src='" + imageThumb + "'></a></div>";
                html += "</div></div>";
            });

            $("div.filler").append(html);
            console.log("data.photos.page=" + data.photos.page);
            console.log("data.photos.pages=" + data.photos.pages);
            if(data.photos.page != data.photos.pages && data.photos.page <= 1){
            
            	console.log("Next Page");
             
				  loadMore(data.photos.page + 1, url);
              
            } 
           

        });


    }


});