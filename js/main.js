/*****HTACCES URL WITHOUT .PHP**************/

$("#contactForm").on("submit", function (event) {
	 var email = $("#email").val();
    
 	console.log(email)
    $.ajax({
        type: "POST",
        url: "send_email_form",
        data: "email=" + email,
        success : function(text){
            if (text == "success"){
                alert("You have successfully been signed for news letter")
            } else{
            	alert("You must fill out the whole form")
            }
        }
    });
});

$("#contactForm").on("submit", function (event) {
	 var email = $("#email").val();
 	console.log(email)
    $.ajax({
        type: "POST",
        url: "create_user_list",
        data: "email=" + email,
        success : function(text){
            if (text == "success"){
                
            } 
        }
    });
});

//this is where we apply opacity to the arrow
$(window).scroll( function(){

  //get scroll position
  var topWindow = $(window).scrollTop();
  //multipl by 1.5 so the arrow will become transparent half-way up the page
  var topWindow = topWindow * 1.5;
  
  //get height of window
  var windowHeight = $(window).height();
      
  //set position as percentage of how far the user has scrolled 
  var position = topWindow / windowHeight;
  //invert the percentage
  position = 1 - position;

  //define arrow opacity as based on how far up the page the user has scrolled
  //no scrolling = 1, half-way up the page = 0
  $('.arrow-wrap').css('opacity', position);

});
