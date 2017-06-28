$( document ).ready(function() {
    
    $("select").change(function(){
		$(".search input").val($("select").val());
		$(".offset input").val("0");
    
    });
    $(".action .reset-params a").click(function(){
        
		$(".offset input").val("0");
    });
    
    $(".action .reset-all a").click(function(){
        console.log("works");
		$(".offset input").val("0");
		$(".count input").val("100");
		$(".search input").val("");
		$("select").val("Search Examples (Tweak For Different Results)");
    });
    
    $(".search input").keypress(function(){
    	$(".offset input").val("0");
    
    });
    
    
//Begin scrape function    
    
   $( "div.button input" ).click(function() {
      $("div.filler").html("");
      var query = $("div.search input").val();
      var count = $("div.count input").val();
      var offset = $("div.offset input").val();
      var url = "../pr.php?https://www.4shared.com/web/rest/v1_2/files?category=3&sort=time%2Cdesc&view=web";

     if (query == null || query == ""){
     } else {
      url +=  "&query=" + encodeURI(query);

     }

     if (offset == null || offset == ""){
     } else {
      url +=  "&offset=" + offset;
      var increment = parseInt($("div.offset input").val()) + 100;
      $("div.offset input").val(increment);
     }

     if (count == null || count == ""){
     url += "&limit=50"
     } else {
     url += "&limit=" + count;
      
     }
    
     // var url = "../pr.php?http://feed.photobucket.com/images/" + encodeURI(query) + "/feed.rss ";
     

var temp = "../pr.php?https://www.4shared.com/folder/aW1my7ss/003/Camera_SM-J700F.html?detailView=false&sortAsc=true&sortsMode=NAME";

$.get(url, function(data){
  // console.log(data);
  //data = xml2json(data);

 // data = data.replace("undefined", '');
  //data = data.replace(/dc:creator/, 'creator');
  //data = jQuery.parseJSON(data);
 console.log(data);
 
  var items = data.items;
  var html = "<div class='wrapper'>";
  var image = "";
  var user = "";
  var library = "";
  var profile = "";
  var album = "";
  if (data.items.length == 0){
  	html += "<div class='sorry'>Sorry, no results. Try tweaking your Search Query and try again.</div>";
  } else {
  	console.log("Yay Results!");
  	$.each( items, function( key, value ) {

   user = value.user.userName;
   image = value.thumbnailUrl + ".jpg";
   library = "https://4shared.com" + value.dirUrl;
   profile = value.user.profileUrl;
   date = value.uploadTime;
   html += "<div class='row'>";

   html += "<div class='cell0'><div class='username'>Username: " + user + "</div>";
     html += "</div>";
    html += "<div class='cell1'><div class='date'>Date: " + date + "</div>";
     html += "</div>";
   html += "<div class='cell2'><div class='profile'><a href='" + profile + "' target='_blank'>Go To Profile</a></div>";
     html += "</div>";

   if (value.dirUrl == null){
html += "<div class='cell3'><div class='library'>No Library :(</div>";
     html += "</div>";
   } else {
   html += "<div class='cell3'><div class='library'><a href='" + library + "'  target='_blank'>View Album On 4Share</a></div>";
     html += "</div>";
    album = value.dirUrl;
    album = album.replace("/folder/","");
    html += "<div class='cell3a'><div class='library'><a href='./scrapealbum.html?q=" + album + "'  target='_blank'>View Full Album Here (Usually Faster)</a></div>";
     html += "</div>";
   }
   html += "<div class='cell5'><div class='image'><a href='" + value.d1PageUrl + "' target='_blank'><img src='" + image + "'></a></div>";
     html += "</div></div>";
  });
  
  }
   html += "</div>";

 

$("div.filler").html(html);
//console.log($("div.filler div.cell3 div.library a:visited"));



   });


   });

 
});