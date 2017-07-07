$(document).ready(function() {

function getURLParameter(name) {
  return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search) || [null, ''])[1].replace(/\+/g, '%20')) || null;
}

  //  var query = getURLParameter('q');


    var count = 1;
    var url = "./pr3.php?suggestions.4shared.com/network/listAllSearchFiles.jsp";
 
        
        
   $(".action .reset-params a").click(function(){
        
		$(".offset input").val("0");
    });
    
    $(".action .reset-all a").click(function(){
        console.log("works");
		$(".offset input").val("0");
		$(".count input").val("100"); 
    });
        
        
        
        
        
        
       $( "div.button input" ).click(function(){
       		console.log("Click heard!");
       		$("div.filler").html("");
       		loadMore(0, url, parseInt(  $(".offset input").val()));
       		$(".offset input").val(parseInt($(".offset input").val()) + parseInt($(".count input").val()));
       		});
   

    function loadMore(urlCount, urlBase, urlOffset) {
    	console.log(urlCount);
    	console.log(urlBase);
        $.get(urlBase + "?start=" + (urlCount + urlOffset), function(data) {
           // console.log(jQuery.parseJSON(data));

            data = jQuery.parseJSON(data)
			console.log(data);


            var imageObject = {};
            
            var nextLink = "";
            
            console.log(imageObject);


            var html = "";
            var image = "";
            var user = "";
            var library = "";
            var profile = "";
            var tempImg = "";
            var album = "";
            var label = "";
            
            $.each(data.children, function(key, value) {
            //console.log(value.children );
               try{
                tempImg = value.children[0].href;
              
                image = value.children[0].href;
				library = value.children[2].href;
				
				album = value.children[2].href;
				album = album.replace("https://www.4shared.com/folder/","");
				label = value.children[1].html;
				
				 
              
            	tempImg = tempImg.replace("/photo/","/img/");
				tempImg = tempImg.replace("/mobile/","/img/");
				tempImg = tempImg.replace("/office/","/img/");
				tempImg = tempImg.replace("/video/","/img/");
				tempImg = tempImg.replace(".htm","");
				tempImg = tempImg.replace("?showComments=true#firstC","");
              
                html += "<div class='row'>";
					
					
					html += "<div class='cell5'><div class='image'><a href='" + library + "' target='_blank'>Go To Library</a></div>";
						html += "</div>";
						
					if(album.includes("https")){	
					      html += "<div class='cell3a'><div class='library'>Can't scrape. Try View Library.</div>";
						 	html += "</div>";
					} else {	 
						
						  html += "<div class='cell3a'><div class='library'><a href='./scrapealbum.html?q=" + album + "&user=" + user + "'  target='_blank'>View Full Album</a></div>";
						    html += "</div>";
					}
					
					 html += "<div class='cell5'><div class='image'>" + label + "</div>";
						html += "</div>";
					html += "<div class='cell5'><div class='image'><a href='" + image + "' target='_blank'><img src='" + tempImg + "' ></a></div>";
						html += "</div>";
					
                html += "</div>";
                } catch(e){
                console.log(e);
                }
            });

            $("div.filler").append(html);
          
       
            if (urlCount <= parseInt($(".count input").val())){
                loadMore(urlCount + 20, url, urlOffset);
            }
            
          
		
        });


    }


});