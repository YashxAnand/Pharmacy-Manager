var window_width = $(window).width();
var resize = 0;

$(window).resize(function(){
	window_width = $(window).width();
	if(resize==1){
		sidebarResize();
	}
})

function sidebarResize(){
	$('.off').css("width",0.2*window_width);
	sidebarResize();
}

$("#menu-toggler").on('click',function(){
	$('.off').css("width",0.2*window_width);
	resize = 1;
});

$(".closebtn").on('click',function(){
	$('.off').css('width',0);
	resize=0;
})

$(".delete").on('click',function(){

		$("#dialog").css({"zIndex":1});
		$('#dialog').animate({opacity:1},500);
		$('#main-container-pages').css("opacity","0.4");

	if($(this).attr('class')=="delete stocks"){
		var med_id = $(this).attr('name');
		var row_id = "#"+med_id;
		$("#yes").on('click',function(){
				$('#dialog').animate({opacity:0},500);
				$("#main-container-pages").css("opacity","1");
				
				$.ajax({
				  method: "POST",
				  url: "delete_med.php",
				  data: { delete:med_id}
				})
				  .done(function( msg ) {
				  	$(row_id).remove();
				    alert( msg );
				  });
				  $("#dialog").css({"zIndex":0});

		})

		$("#no").on('click',function(){
			$("#dialog").css({"zIndex":0});
			$('#dialog').animate({opacity:0},500);
			$("#main-container-pages").css("opacity","1");
		})
	}else{

		var username = $(this).attr('name');
		var row_id = "#"+$(this).attr('name');

		$("#yes").on('click',function(){
			$("#dialog").css({"zIndex":0});
			$('#dialog').animate({opacity:0},500);
			$("#main-container-pages").css("opacity","1");
			
			$.ajax({
			  method: "POST",
			  url: "delete_user.php",
			  data: { delete:username}
			})
			  .done(function( msg ) {
			    alert( msg );
			  });
			  $(row_id).remove();
			  $("#dialog").css({"zIndex":0});

	})

	$("#no").on('click',function(){
		$("#dialog").css({"zIndex":0});
		$('#dialog').animate({opacity:0},500);
		$("#main-container-pages").css("opacity","1");
	})
	}
})

$("#add-med-btn").click(function(){
	$("#add-medicine").css({"zIndex":1});
	$("#add-medicine").animate({opacity:1},500);
	$('#main-container-pages').css("opacity","0.4");

	$("#cancel-medicine").on('click',function(){
		$("#add-medicine").css({"zIndex":0});
		$("#add-medicine").animate({opacity:0},500);
		$('#main-container-pages').css("opacity","1");
	})
})

$('#add-user-btn').on('click',function(){
	$("#add-user").css({"zIndex":1});
	$("#add-user").animate({opacity:1},500);
	$('#main-container-pages').css("opacity","0.4");

	$("#cancel-user").on('click',function(){
		$("#add-user").css({"zIndex":0});
		$("#add-user").animate({opacity:0},500);
		$('#main-container-pages').css("opacity","1");
	})
		
})

$('.editable').bind("input propertychange", function(){
	var name = $(this).attr('class').replace('editable ','');
	var med_id = $(this).attr('name');
	$.ajax({
			  method: "POST",
			  url: "update_stocks.php",
			  data: { update:$(this).val(),column:name,med_id:med_id}
			})
			.done(function(msg){
			})
});

$(".bill-btn").on('click',function(){
	var id = $(this).attr('name').replace("add","");
	var name = $("#med"+id).html();
	var available = $("#available"+id).html();

	available = parseInt(available);

	var price = $("#price"+id).html();

	price = price.replace("Rs. ","");
	price = parseInt(price);

	var quantity = $("#quantity"+id).val();
	quantity = parseInt(quantity);

	if(quantity>0 && quantity<=available){
		var new_avl = available-quantity;
		$("#available"+id).html(new_avl);

		$.ajax({
			method: "POST",
			url: "bill.php",
			data: {
				name: name,
				available: available,
				price: price,
				quantity: quantity
			}
		})
			.done(function(msg){
				alert(msg)
			})
		}else{
			if(quantity==0){
				alert("Quantity cannot be zero");
			}else{
				alert("Quantity is not available in stock.")
			}
		}
	
})

