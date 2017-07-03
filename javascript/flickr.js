$( document ).ready(function() {
    
  /*  $("select.example").change(function(){
		$(".search input").val($("select.example").val());
		$(".offset input").val("1");
    
    });
    */
    $(".action .reset-params a").click(function(){
        
		$(".offset input").val("1");
    });
    
    $(".action .reset-all a").click(function(){
        console.log("works");
		$(".offset input").val("1");
		$(".count input").val("100");
		$(".search input").val("");
		$("select.example").val("Search Examples (Tweak For Different Results)");
		$("select.sort").val("&sort=time%2Cdesc");
    });
    
   /* $(".search input").keypress(function(){
    	$(".offset input").val("0");
    
    });
    
    $("select.sort").change(function(){
    	$(".offset input").val("0");
    
    });
    */
//Begin scrape function    
    
   $( "div.button input" ).click(function() {
      $("div.filler").html("");
      var query = $("div.search input").val();
      var count = $("div.count input").val();
      var offset = $("div.offset input").val();
      var url = "../pr.php?https://api.flickr.com/services/rest/?method=flickr.photos.getRecent&api_key=6bf52f197b492b2b6bfe860161eeafde&format=json&nojsoncallback=1";
	 
	 
      
 
   

     if (query == null || query == ""){
     } else {
     // url +=  "&query=" + encodeURI(query);

     }

     if (offset == null || offset == ""){
     } else {
      url +=  "&page=" + offset;
      var increment = parseInt($("div.offset input").val()) + 1;
      $("div.offset input").val(increment);
     }

     if (count == null || count == ""){
     url += "&per_page=500"
     } else {
     url += "&per_page=" + count;
      
     }
    


$.get(url, function(data){
  // console.log(data);
  //data = xml2json(data);

 // data = data.replace("undefined", '');
  //data = data.replace(/dc:creator/, 'creator');
  //data = jQuery.parseJSON(data);
 console.log(data);
 
  var items = data.photos.photo;
  var html = "<div class='wrapper'>";
  var image = "";
  var user = "";
  var library = "";
  var profile = "";
  var album = "";
  var date = "";
  if (data.photos.photo.length == 0){
  	html += "<div class='sorry'>Sorry, no results. Try tweaking your Search Query and try again.</div>";
  } else {
  	console.log("Yay Results!");
  	$.each( items, function( key, value ) {

   user = value.owner;
   image = "https://farm" + value.farm + ".staticflickr.com/" + value.server + "/" + value.id + "_" + value.secret + "_m.jpg";
   library = "https://www.flickr.com/photos/" + value.owner;
   profile = "https://www.flickr.com/people/" + value.owner;
  // date = value.uploadTime;
   html += "<div class='row'>";

   html += "<div class='cell0'><div class='username'>Username: " + user + "</div>";
     html += "</div>";
    html += "<div class='cell1'><div class='date'>Date: " + date + "</div>";
     html += "</div>";
   html += "<div class='cell2'><div class='profile'><a href='" + profile + "' target='_blank'>Go To Profile</a></div>";
     html += "</div>";

   html += "<div class='cell3'><div class='library'><a href='" + library + "'  target='_blank'>Go To Library</a></div>";
     html += "</div>";
 //   album = value.dirUrl;
  //  album = album.replace("/folder/","");
     html += "<div class='cell3a'><div class='library'><a href='./flickralbumscraper.html?q=" + value.owner + "&user=" + value.owner + "'  target='_blank'>View Full Album</a></div>";
     html += "</div>";
   
   html += "<div class='cell2a'><div class='filename'>" + value.title + "</div>";
     html += "</div>";
   html += "<div class='cell5'><div class='image'><a href='https://www.flickr.com/photos/" + value.owner + "/" + value.id + "' target='_blank'><img src='" + image + "'></a></div>";
     html += "</div></div>";
  });
  
  }
   html += "</div>";

 

$("div.filler").html(html);
//console.log($("div.filler div.cell3 div.library a:visited"));



   });


   });

 
});