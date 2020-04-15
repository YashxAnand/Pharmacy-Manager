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

$(".update").click(function(){
	var btn_id = $(this).attr('name');
	var row_id = "#row"+btn_id;
	var name = $("#name"+btn_id).html();
	var qty_id = "#quantity"+btn_id;
	var prev_val = parseInt($(qty_id).attr('name'));
	var curr_val = parseInt($("#quantity"+btn_id).val());
	var change = curr_val - prev_val;

	if(change!=0){
		if(curr_val == 0){
			$(row_id).remove();
			$.ajax({
				method: "POST",
				url: "bill.php",
				data: {
					nameUpdate:name,
					change:change,
					quantity: curr_val,
				}
			})
				.done(function(msg){
					alert(msg);
				})
		}else{
			$.ajax({
				method: "POST",
				url: "bill.php",
				data: {
					nameUpdate:name,
					change:change,
					quantity: curr_val,
				}
			})
				.done(function(msg){
					alert(msg);
				})
			}
		}else{
			alert("No change in quantity");
		}
})

$("#generate-bill").click(function(){
	var count = 1;
	var cust_name = $("#customer-name").val();
	var cust_mobile = $("#customer-mobile").val();
	if(cust_name!=""){
		var total=0;
		var total_qty=0;
		while($("."+count).html()){
			var class_name = "."+count;
			var id = $(class_name).attr('name');
			var row_id = "#row"+id;
			var qty = parseInt($("#quantity"+id).val());
			var price = $("#price"+id).html();
			price = price.replace("Rs. ","");
			price = parseInt(price);
			total+=(price*qty);
			total_qty+=qty;

			count+=1;
		}

		count = 1;

		$.ajax({
					method: "POST",
					url: "invoice.php",
					data: {
						customer_name:cust_name,
						customer_mobile: cust_mobile,
						total: total,
						total_qty: total_qty
					}
				})
					.done(function(msg){
						while($("."+count).html()){
							var class_name = "."+count;
							var id = $(class_name).attr('name');
							var row_id = "#row"+id;
							var name = $("#name"+id).html();
							var qty = parseInt($("#quantity"+id).val());
							var price = $("#price"+id).html();
							price = price.replace("Rs. ","");
							price = parseInt(price);
							total+=(price*qty);

							$.ajax({
									method: "POST",
									url: "invoice.php",
									data: {
										med_name: name,
										quantity: qty,
										price: price
									}
								})

							count+=1;
						}
					$("#bill-processing").hide();
					window.location.href="receipt.php?name="+cust_name+"&mobile="+cust_mobile;
					})
		}else{
			alert("Customer name cannot be empty!");
		}


})


$(".view").click(function(){
	var invoice_number = $(this).attr('name');
	var customer_name = $("#"+invoice_number).html();
	var phone = $("#phone"+invoice_number).html();
	var date = $("#date"+invoice_number).html();

	window.location.href = 'old_receipt.php?invoice='+invoice_number+'&customer='+customer_name+'&phone='+phone+'&date='+date;

})