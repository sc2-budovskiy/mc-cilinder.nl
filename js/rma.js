function show_rma_cilinders(num) {
	if(num <= 0 || num > 50)
	{
		num = 1;
	}
	var row = jQuery(".rc-row:first");
	var item = jQuery(".ro-item-row:first");
	var oldNum = parseInt(jQuery(".rc-row").length);
	if(oldNum !== num) {
		if (oldNum < num) {
			for (var i = oldNum; i < num; i++) {
				var newRow = row.clone();
				var ind = i - (-1);
				newRow.find(".rc-num").text(ind);
				newRow.removeAttr("data-size-val");
				newRow.removeAttr("data-extra-val");
				newRow.find("select option").removeAttr("disabled");
				newRow.appendTo(".rma-cilinders");
				var newItem = item.clone();
				newItem.find("strong.num").text(ind + ":");
				var outside = jQuery(".rc-row:eq(" + i + ")").find(".rc-from-order .outside").val();
				var inside = jQuery(".rc-row:eq(" + i + ")").find(".rc-from-order .inside").val();
				var extra = jQuery(".rc-row:eq(" + i + ")").find(".rc-from-order .extra").val();
				newItem.find(".item-from-order").text(outside + "/" + inside + "/" + extra);
				var outsideNew = jQuery(".rc-row:eq(" + i + ")").find(".rc-new-item .outside").val();
				var insideNew = jQuery(".rc-row:eq(" + i + ")").find(".rc-new-item .inside").val();
				var extraNew = jQuery(".rc-row:eq(" + i + ")").find(".rc-new-item .extra").val();
				newItem.find(".item-new").text(outsideNew + "/" + insideNew + "/" + extraNew);
				newItem.find(".rma-item-price").text("0.00");
				newItem.appendTo(".ro-items");
			}
		} else {
			for (var i = num; i < oldNum; i++) {
				jQuery(".rc-row:eq(" + i + ")").addClass("deleted");
				jQuery(".ro-item-row:eq(" + i + ")").addClass("deleted");
			}
			jQuery(".rc-row.deleted").remove();
			jQuery(".ro-item-row.deleted").remove();
		}
		calc_prices();
	}
}
function update_order_line(obj) {
	var index = obj.index();
	var newItem = jQuery(".ro-item-row:eq(" + index + ")");
	var outside = obj.find(".rc-from-order .outside").val();
	var inside = obj.find(".rc-from-order .inside").val();
	var extra = obj.find(".rc-from-order .extra").val();
	newItem.find(".item-from-order").text(outside + "/" + inside + "/" + extra);
	var outsideNew = obj.find(".rc-new-item .outside").val();
	var insideNew = obj.find(".rc-new-item .inside").val();
	var extraNew = obj.find(".rc-new-item .extra").val();
	newItem.find(".item-new").text(outsideNew + "/" + insideNew + "/" + extraNew);
}
function calc_prices() {
	if(orderData && orderData.sizes) {
		var total = 0;
		var conversionPrice = orderData.conversion_price > 0 ? Number(orderData.conversion_price) : 0;
		jQuery(".rc-row").each(function(index){
			var itemPrice = orderData.base_price > 0 ? Number(orderData.base_price) : 0;
			var obj = jQuery(this);
			var outside = obj.find(".rc-new-item .outside").val();
			var inside = obj.find(".rc-new-item .inside").val();
			var extra = obj.find(".rc-new-item .extra").val();
			var sizeData = orderData.sizes.options;
			var extraData = orderData.extra.options;
			if(!outside || !inside || !extra) {
				//unset price
				itemPrice = 0;
			} else {
				//find full size value and price
				for(var i = 0; i < sizeData.length; i++) {
					var label = sizeData[i].label.substr(0, sizeData[i].label.indexOf(' '));
					if(label === outside + "/" + inside || label === inside + "/" + outside) {
						//set size val
						var sizeVal = sizeData[i]["data-val"];
						obj.find(".rc-new-item").attr("data-size-val", sizeVal);
						//set price
						itemPrice += Number(sizeData[i].price);
					}
				}
				//find extra price
				for(var i = 0; i < extraData.length; i++) {
					if(extraData[i].label.toLowerCase().indexOf(extra) === 0) {
						//set extra val
						var extraVal = extraData[i]["data-val"];
						obj.find(".rc-new-item").attr("data-extra-val", extraVal);
						//set price
						itemPrice += Number(extraData[i].price);
					}
				}
			}

			//old item price
			var oldItemPrice = 0;
			var outsideOld = obj.find(".rc-from-order .outside").val();
			var insideOld = obj.find(".rc-from-order .inside").val();
			var extraOld = obj.find(".rc-from-order .extra").val();
			if(!outsideOld || !insideOld || !extraOld) {
				//unset price
				oldItemPrice = 0;
				itemPrice = 0;
			} else {
				//find full size value and price
				for(var i = 0; i < sizeData.length; i++) {
					var label = sizeData[i].label.substr(0, sizeData[i].label.indexOf(' '));
					if(label === outsideOld + "/" + insideOld || label === insideOld + "/" + outsideOld) {
						//set size val
						var sizeValOld = sizeData[i]["data-val"];
						obj.find(".rc-from-order").attr("data-size-val", sizeValOld);
						//set price
						oldItemPrice += Number(sizeData[i].price);
					}
				}
				//find extra price
				for(var i = 0; i < extraData.length; i++) {
					if(extraData[i].label.toLowerCase().indexOf(extraOld) === 0) {
						//set extra val
						var extraValOld = extraData[i]["data-val"];
						obj.find(".rc-from-order").attr("data-extra-val", extraValOld);
						//set price
						oldItemPrice += Number(extraData[i].price);
					}
				}
			}

			itemPrice -= oldItemPrice;
			if(itemPrice < 0) {
				itemPrice = 0;
			}

			total += itemPrice;
			//show item price
			jQuery(".ro-item-row:eq(" + index + ")").find(".rma-item-price").text(itemPrice.toFixed(2));
		});
		total += conversionPrice;
		//show total price
		jQuery("#rma-total").text(total.toFixed(2));
	}
}
function validate_form() {
	var error = false;
	if(!jQuery("#rma-order").val()) {
		//show error
		return false;
	}
	if(!jQuery("#rma-name").val()) {
		//show error
		return false;
	}
	if(!jQuery("#rma-phone").val()) {
		//show error
		return false;
	}
	if(!jQuery("#rma-email").val()) {
		//show error
		return false;
	}
	if(!jQuery("#cilinders-num").val()) {
		//show error
		return false;
	}
	jQuery(".rc-row").each(function(){
		var obj = jQuery(this);
		var outside = obj.find(".rc-from-order .outside").val();
		var inside = obj.find(".rc-from-order .inside").val();
		var extra = obj.find(".rc-from-order .extra").val();
		var outsideNew = obj.find(".rc-new-item .outside").val();
		var insideNew = obj.find(".rc-new-item .inside").val();
		var extraNew = obj.find(".rc-new-item .extra").val();
		if(!outside) {
			//show error
			error = true;
		}
		if(!inside) {
			//show error
			error = true;
		}
		if(!extra) {
			//show error
			error = true;
		}
		if(!outsideNew) {
			//show error
			error = true;
		}
		if(!insideNew) {
			//show error
			error = true;
		}
		if(!extraNew) {
			//show error
			error = true;
		}
	});
	if(error) {
		return false;
	}
	return true;
}
function submit_form() {
	var form = jQuery("#rma-form");
	var buttonSubmit = jQuery("#rma-submit");
	buttonSubmit.attr("disabled","disabled");
	buttonSubmit.html("Loading... <div class='loader'></div>");
	var fd = new FormData();
	//add user fields
	fd.append("order_number", jQuery("#rma-order").val());
	fd.append("order_name", jQuery("#rma-name").val());
	fd.append("phone", jQuery("#rma-phone").val());
	fd.append("email", jQuery("#rma-email").val());
	var productId = form.find("input[name='product_id']").val();
	var options = jQuery(".rc-row");
	options.each(function (index) {
		fd.append("items[" + index + "][quantity]", 1);
		fd.append("items[" + index + "][add-to-cart]", productId);
		//save new size options
		var outsideNew = jQuery(this).find(".rc-new-item .rcp-option .outside option:selected").attr("data-value");
		var insideNew = jQuery(this).find(".rc-new-item .rcp-option .inside option:selected").attr("data-value");
		fd.append("items[" + index + "][addon-" + productId + jQuery(this).find(".rc-new-item .rcp-option .outside").attr("name") + "]", outsideNew);
		fd.append("items[" + index + "][addon-" + productId + jQuery(this).find(".rc-new-item .rcp-option .inside").attr("name") + "]", insideNew);
		//save size
		var sizeNew = jQuery(this).find(".rc-new-item").attr("data-size-val");
		fd.append("items[" + index + "][addon-" + productId + jQuery(this).find(".rc-new-item").attr("data-size-field") + "]", sizeNew);
		//save extra
		var extraNew = jQuery(this).find(".rc-new-item").attr("data-extra-val");
		fd.append("items[" + index + "][addon-" + productId + jQuery(this).find(".rc-new-item").attr("data-extra-field") + "]", extraNew);

		//save original options
		/*var outside = jQuery(this).find(".rc-from-order .rcp-option .outside").val();
        var inside = jQuery(this).find(".rc-from-order .rcp-option .inside").val();
        fd.append("old_items[" + index + "][size_outside]", outside);
        fd.append("old_items[" + index + "][size_inside]", inside);
        var extra = jQuery(this).find(".rc-from-order .extra").val();
        fd.append("old_items[" + index + "][extra]", extra);*/

		//submit original addons
		var outside = jQuery(this).find(".rc-from-order .rcp-option .outside option:selected").attr("data-value");
		var inside = jQuery(this).find(".rc-from-order .rcp-option .inside option:selected").attr("data-value");
		fd.append("old_items[" + index + "][addon-" + productId + jQuery(this).find(".rc-from-order .rcp-option .outside").attr("name") + "]", outside);
		fd.append("old_items[" + index + "][addon-" + productId + jQuery(this).find(".rc-from-order .rcp-option .inside").attr("name") + "]", inside);
		var size = jQuery(this).find(".rc-from-order").attr("data-size-val");
		fd.append("old_items[" + index + "][addon-" + productId + jQuery(this).find(".rc-from-order").attr("data-size-field") + "]", size);
		var extra = jQuery(this).find(".rc-from-order").attr("data-extra-val");
		fd.append("old_items[" + index + "][addon-" + productId + jQuery(this).find(".rc-from-order").attr("data-extra-field") + "]", extra);
	});

	jQuery.ajax({
		url: location.pathname + "?submit_rma=1",
		type: 'POST',
		dataType: 'text',
		processData: false,
		contentType: false,
		cache: false,
		data: fd,
	}).success(function(res) {
		var data = JSON.parse(res);
		//show success message
		location.href = location.pathname + "?order_completed" + (data && data.payment_url ? "&payment_url=" + encodeURIComponent(data.payment_url) : "");
	}).error(function(res, exception) {
		buttonSubmit.removeAttr("disabled");
		buttonSubmit.html("NU BESTELLEN");
		//show error message
		alert("Error! Try again later.");
	});
}
var orderData = {};
jQuery(document).ready(function ($) {
	jQuery("#more-cilinders").click(function () {
		jQuery(this).hide();
		var cilindersNum = jQuery("#cilinders-num");
		cilindersNum.show();
		jQuery(".rma-cilinder-num .rcn-col").removeClass("active");
	});
	jQuery("#cilinders-num").change(function () {
		jQuery(".rma-cilinder-num .rcn-col").removeClass("active");
		var cnt = parseInt(jQuery(this).val());
		show_rma_cilinders(cnt);
	});
	jQuery(document).on("click", ".rma-cilinder-num .rcn-col", function(){
		var cnt = parseInt(jQuery(this).text());
		jQuery("#cilinders-num").val(cnt).trigger("change");
		jQuery(this).addClass("active");
	});
	jQuery(document).on("change", ".rc-row select", function(){
		if(jQuery(this).hasClass("inside") || jQuery(this).hasClass("outside")) {
			var outside = jQuery(this).closest('.rc-params').find(".outside").val();
			var inside = jQuery(this).closest('.rc-params').find(".inside").val();
			if(outside === "10") {
				jQuery(this).closest('.rc-params').find(".inside").find("option[value=10]").attr("disabled", "disabled");
			} else if (inside === "10") {
				jQuery(this).closest('.rc-params').find(".outside").find("option[value=10]").attr("disabled", "disabled");
			} else {
				jQuery(this).closest('.rc-params').find(".outside").find("option").removeAttr("disabled");
				jQuery(this).closest('.rc-params').find(".inside").find("option").removeAttr("disabled");
			}
		}
		update_order_line(jQuery(this).closest(".rc-row"));
		calc_prices();
	});
	jQuery(document).on("change", "#rma-order", function(){
		jQuery.get("?order_number=" + jQuery(this).val(), function(res){
			var error = false;
			try {
				if(res) {
					orderData = JSON.parse(res);
					var productId = orderData.product_id;
					jQuery("input[name='product_id']").val(productId);
				} else {
					error = true;
				}
			} catch(Exception) {
				error = true;
			}
			if(error) {
				orderData = {};
				jQuery("#rma-order").val("");
				alert("Order not found!");
			}
			calc_prices();
		});
	});
	jQuery("#rma-submit").click(function(e) {
		//e.preventDefault();
		if(validate_form()) {
			e.preventDefault();
			submit_form();
		}
		else {
			alert("Please fill in all required fields.");
		}
	});
	jQuery("#rma-form").submit(function(e) {
		e.preventDefault();
	});
});
