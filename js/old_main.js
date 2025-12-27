/* Utility function to convert a canvas to a BLOB */
var dataURLToBlob = function(dataURL) {
    var BASE64_MARKER = ';base64,';
    if (dataURL.indexOf(BASE64_MARKER) == -1) {
        var parts = dataURL.split(',');
        var contentType = parts[0].split(':')[1];
        var raw = parts[1];

        return new Blob([raw], {type: contentType});
    }

    var parts = dataURL.split(BASE64_MARKER);
    var contentType = parts[0].split(':')[1];
    var raw = window.atob(parts[1]);
    var rawLength = raw.length;

    var uInt8Array = new Uint8Array(rawLength);

    for (var i = 0; i < rawLength; ++i) {
        uInt8Array[i] = raw.charCodeAt(i);
    }

    return new Blob([uInt8Array], {type: contentType});
}
/* End Utility function to convert a canvas to a BLOB      */
function resize_images()
{
    if (window.jQuery) {
        jQuery(".my-col-img").each(function () {
            var height = jQuery(this).closest(".row").find(".bg-grey").height();
            jQuery(this).height(height);
        });
    }
}
function set_cols_height()
{
    var obHeight = [];
    var ob = jQuery(".oi-block");
    ob.each(function(){
        var ind = jQuery(this).index();
        if(!obHeight[ind] || jQuery(this).height() > obHeight[ind])
        {
            obHeight[ind] = jQuery(this).height();
        }
    });
    ob.each(function(){
        var ind = jQuery(this).index();
        jQuery(this).height(obHeight[ind]);
    });
}
function resize_access_table()
{
    var wrapper = jQuery(".keys-outer-table .table-wrapper");
    if(wrapper.length != 0)
    {
        var newWidth = jQuery(".checkout-middle").width() - jQuery(".keys-outer-table td:first-child").width();
        wrapper.css({"width":newWidth});
    }
}
function get_sleutels_num(num)
{
    var sNum = 0;
    var additionalKeys = jQuery("#sleutels-num");
    if(additionalKeys.hasClass("no-add-keys"))
    {
        return 0;
    }
    if(additionalKeys.hasClass("keyplan"))
    {
        return num;
    }
    if(num == 1)
    {
        sNum = 3;
    }
    else if(num >= 2 && num <= 3)
    {
        sNum = 5;
    }
    else if(num >= 4 && num <= 5)
    {
        sNum = 7;
    }
    else if(num > 0)
    {
        sNum = 8;
    }
    return sNum;
}
function show_cilinders(num)
{
    if(num <= 0 || num > 50)
    {
        num = 1;
    }
    var row = jQuery(".cilinder-config-options:first");
    var oldNum = parseInt(jQuery(".cilinder-config-options").length);
    if(oldNum !== num) {
        if (oldNum < num) {
            for (var i = oldNum; i < num; i++) {
                var newRow = row.clone();
                var ind = i - (-1);
                newRow.find(".cilinder-count-title .num").text(ind);
                newRow.find(".materials-options").attr("id", "materials-select-" + ind);
                newRow.find(".param-4 .change-param-value").attr("data-src", "#materials-select-" + ind);
                newRow.find(".extra-options").attr("id", "extra-select-" + ind);
                newRow.find(".param-2 .change-param-value").attr("data-src", "#extra-select-" + ind);
                newRow.find(".extra2-options").attr("id", "extra2-select-" + ind);
                newRow.find(".param-3 .change-param-value").attr("data-src", "#extra2-select-" + ind);
                if(newRow.find(".param-5").length != 0) {
                    newRow.find(".param-5 input[type='checkbox']").attr("id", "dt-" + ind);
                    newRow.find(".param-5 label").attr("for", "dt-" + ind);
                    //newRow.find(".param-5 input[type='checkbox']").prop("checked", false);
                    //newRow.find(".param-5 .param-value").attr("data-value",  newRow.find(".param-5 input[type='checkbox']").data("uncheked-value")).text(newRow.find(".param-5 input[type='checkbox']").data("uncheked-label"));
                }
                newRow.appendTo(".cilinder-config-block");
                if(jQuery(".access-params").length != 0) {
                    jQuery(".access-params").append("<div class=\"access-block\">" + newRow.find(".cilinder-count-title").html() + "</div>");
                }
            }
        }
        else {
            for (var i = num; i < oldNum; i++) {
                jQuery(".cilinder-config-options:eq(" + i + ")").addClass("deleted");
                jQuery(".access-params").each(function(){
                    jQuery(this).find(".access-block:eq(" + i + ")").addClass("deleted");
                });
            }
            jQuery(".cilinder-config-block .deleted").remove();
            jQuery(".access-params .deleted").remove();
        }
        jQuery(".cilinder-num").text(num);
        var sNum = get_sleutels_num(num);
        jQuery(".sleutel-num-standard").text(sNum);
        jQuery(".user-keys-val").trigger("change");
        var extraNum = parseInt(jQuery("#sleutels-num").val());
        jQuery(".sleutel-num").text(sNum - (-extraNum));
        calc_products_prices();

        //check for color pro/plus
        var offerItem = jQuery(".offer-item");
        offerItem.removeClass("disabled");
        jQuery(".materials-options").each(function(){
            var val2 = jQuery(this).find(".options-list .active .cilinder-count-title").text();
            if(val2.trim().toLowerCase() === "zwart" || val2.trim().toLowerCase() === "messing")
            {
                offerItem.each(function(){
                    var name = jQuery(this).find("h2").text().toLowerCase();
                    if(name.indexOf("color pro") !== -1 || name.indexOf("color plus") !== -1 || name.indexOf("move") !== -1)
                    {
                        jQuery(this).addClass("disabled");
                    }
                });
            }
        });
        /*if(num > 5 && (jQuery("#cilinders-num").hasClass("product-page") || jQuery("#cilinders-num").hasClass("single-product"))) {
            offerItem.each(function(){
                var name = jQuery(this).find("h2").text().toLowerCase();
                if(name.indexOf("color pro") !== -1 || name.indexOf("color plus") !== -1)
                {
                    jQuery(this).addClass("disabled");
                }
            });
        }*/

        if(num > 7 && (jQuery("#cilinders-num").hasClass("product-page") || jQuery("#cilinders-num").hasClass("single-product")))
        {
            offerItem.each(function(){
                var name = jQuery(this).find("h2").text().toLowerCase();
                if(name.indexOf("move") !== -1)
                {
                    jQuery(this).addClass("disabled");
                }
            });
        }
    }
}
function calc_products_prices()
{
    jQuery(".offer-prices").each(function() {
        var id = jQuery(this).attr("id").substr(3);
        var obj = jQuery(this);
        var amount = 0;
        var keyplanCalculation = jQuery(".keyplan-calculation");
        if(keyplanCalculation.length != 0)
        {
            amount += Number(keyplanCalculation.data("price"));
        }
        jQuery(".cilinder-config-block .cilinder-params").each(function(){
            var itemPrice = Number(jQuery("#po-" + id).find(".product-price").text());
            var cilinderParam = jQuery(this);
            jQuery(this).find(".param-value").each(function(){
                var paramValue = jQuery(this).text();
                if(paramValue != "")
                {
                    var paramName = jQuery(this).attr("data-field");
                    var optPrices = obj.find("." + id + paramName);
                    var optPrice = Number(optPrices.find("[data-val='" + paramValue + "']").text());
                    itemPrice = itemPrice + optPrice;
                    if(obj.closest(".offer-item").hasClass("selected"))
                    {
                        cilinderParam.find(".product-item-price").text("€ " + itemPrice.toFixed(2));
                    }
                }
            });
            amount = amount + itemPrice;
        });
        var sleutelsNum = jQuery("#sleutels-num");
        var keyNum = parseInt(sleutelsNum.val());
        var keyPrice = obj.find(".key-price").text();
        if(sleutelsNum.hasClass("keyplan"))
        {
            keyPrice = obj.find(".extra-key-price").text();
        }
        if(obj.closest(".offer-item").hasClass("selected"))
        {
            jQuery(".key-item-price").text(Number(keyPrice).toFixed(2));
        }
        var keysPrice = keyNum * keyPrice;
        amount = amount + keysPrice;
        jQuery("#price-" + id).text(amount.toFixed(2));
    });
}
function send_params(params, qNum, pNum)
{
    jQuery.ajax({
        url: location.href,
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType: false,
        cache: false,
        data: params[qNum],
    }).always(function() {
        qNum++;
        if(qNum === pNum)
        {
            location.href = "/cart/";
        }
        else
        {
            send_params(params, qNum, pNum);
        }
    });
}
function change_image(rowNum) {
    var imgType;
    var row = jQuery(".cilinder-config-options:eq('" + rowNum + "')");
    var size = row.find(".param-1 .param-value").attr("data-value");
    var color = row.find(".param-4 .param-value").attr("data-value");
    var shortSide = row.find(".param-2 .param-value").attr("data-value").split("-")[0];
    var longSide = row.find(".param-3 .param-value").attr("data-value").split("-")[0];
    if(size.substr(0, 2) == "10")
    {
        imgType =  "half";
        if(shortSide == "knop" || shortSide == "pushknop")
        {
            imgType = "half-knop";
        }
        if(longSide == "knop" || longSide == "pushknop")
        {
            imgType = "half-knop";
        }
    }
    else
    {
        if (size.substr(0, 2) == size.substr(3, 2)) {
            imgType = "standard";
        }
        else if (parseInt(size.substr(0, 2)) < parseInt(size.substr(3, 2))) {
            imgType = "long";
        }
        else {
            imgType = "standard";
        }
        if (shortSide == "knop" || shortSide == "pushknop") {
            imgType = "standard-short";
        }
        if (longSide == "knop" || longSide == "pushknop") {
            imgType = "standard-long";
        }
    }
    imgType = imgType + "-" + color;
    var img = row.children(".cilinder-count-item").find(".cilinder-count-img");
    img.css({"background-image":"url(" + img.attr("data-folder") + imgType + ".png)"});
}
function change_image_upd()
{
    var cilinders = jQuery(".checkout-products-data");
    if(!cilinders.hasClass("upd")) {
        cilinders.each(function (index) {
            if (!jQuery(this).hasClass("extra-products-data")) {
                change_image(index);
            }
        });
        cilinders.addClass("upd");
    }
}
function change_image_keyplan()
{
    var cilinders = jQuery(".cilinder-config-options.change-img");
    if(!cilinders.hasClass("upd")) {
        cilinders.each(function (index) {
            change_image(index);
        });
        cilinders.addClass("upd");
    }
}
function sleutel_num_upd()
{
    var sleutelsInfo = jQuery("#checkout-sleutels-info");
    if(sleutelsInfo.length != 0 && !sleutelsInfo.hasClass("upd")) {
        sleutelsInfo.find(".sleutel-num-standard").text(get_sleutels_num(parseInt(sleutelsInfo.find(".cilinder-num").text())));
        sleutelsInfo.addClass("upd");
    }
}
var resizedFile;
var resizedFileName;
jQuery(document).ready(function() {
    resize_images();
    resize_access_table();
    jQuery(".cilinder-select").click(function (){
        jQuery('html, body').animate({
            scrollTop: jQuery("#select-cilinder").offset().top
        }, 2000);
    });
    jQuery(".params-select").click(function (){
        jQuery('html, body').animate({
            scrollTop: jQuery("#select-params").offset().top
        }, 2000);
    });
    jQuery(".keys-select").click(function (){
        jQuery('html, body').animate({
            scrollTop: jQuery("#select-keys").offset().top
        }, 2000);
    });
    jQuery(".offers-select").click(function (){
        jQuery('html, body').animate({
            scrollTop: jQuery("#select-offers").offset().top
        }, 2000);
    });
    jQuery(".access-select").click(function (){
        jQuery('html, body').animate({
            scrollTop: jQuery("#keys-access").offset().top
        }, 2000);
    });
    jQuery("[data-fancybox]").fancybox({
        fullScreen:false,
        closeBtn:false,
        smallBtn:false
    });
    jQuery(".popup-close").click(function () {
        jQuery.fancybox.close();
    });
    //product page
    jQuery(document).on("click", ".cilinder-count .cilinder-count-item", function(){
        var cnt = 0;
        var parent = jQuery(this).closest(".cilinder-count");
        if(parent.hasClass("cilinder-step-three") && jQuery(this).hasClass("active"))
        {
            jQuery(this).removeClass("active");
        }
        else
        {
            parent.find(".cilinder-count-item").removeClass("active");
            jQuery(this).addClass("active");
            if(jQuery(this).find(".cilinder-count-title .num").length > 0)
            {
                cnt = parseInt(jQuery(this).find(".cilinder-count-title .num").text());
            }
        }
        if(parent.hasClass("cilinder-step-one"))
        {
            jQuery("#cilinders-num").val(cnt);
            show_cilinders(cnt);
        }
        else if(parent.hasClass("cilinder-step-three"))
        {
            jQuery("#sleutels-num").val(cnt);
            jQuery(".sleutel-num").text(get_sleutels_num(parseInt(jQuery("#cilinders-num").val())) - (-cnt));
            calc_products_prices();
        }
    });
    jQuery("#more-cilinders").click(function () {
        jQuery(this).hide();
        var cilindersNum = jQuery("#cilinders-num");
        cilindersNum.show();
        jQuery("#select-cilinder").next(".cilinder-count").find(".cilinder-count-item").removeClass("active");
        var cnt = parseInt(cilindersNum.val());
        show_cilinders(cnt);
    });
    jQuery("#more-sleutels").click(function () {
        jQuery(this).hide();
        var sleutelsNum = jQuery("#sleutels-num");
        sleutelsNum.show();
        jQuery("#select-keys").next(".cilinder-count").find(".cilinder-count-item").removeClass("active");
    });
    jQuery("#cilinders-num").change(function () {
        jQuery("#select-cilinder").next(".cilinder-count").find(".cilinder-count-item").removeClass("active");
        var cnt = parseInt(jQuery(this).val());
        show_cilinders(cnt);
    });
    jQuery("#sleutels-num").change(function () {
        jQuery("#select-keys").next(".cilinder-count").find(".cilinder-count-item").removeClass("active");
        var cnt = parseInt(jQuery(this).val());
        jQuery(".sleutel-num").text(get_sleutels_num(parseInt(jQuery("#cilinders-num").val())) - (-cnt));
        calc_products_prices();
    });
    jQuery(document).on("change", ".param-item select", function () {
        var obj = jQuery(this).parent().find(".param-value");
        obj.text(jQuery(this).val());
        obj.attr("data-value", jQuery(this).find("option:selected").attr("data-value"));
        calc_products_prices();
        var numRow = jQuery(this).closest(".cilinder-config-options").index();
        if(jQuery(this).closest(".checkout-products-data").length != 0)
        {
            numRow = jQuery(this).closest(".checkout-products-data").index();
        }
        change_image(numRow);
    });
    jQuery(document).on("click", ".material-select,.extra-select,.extra2-select", function () {
        var numRow = jQuery(this).closest(".popup-container").attr("id").split("-")[2] - 1;
        var val = jQuery(this).parent().find(".options-list .active .cilinder-count-title").text();
        var paramNum;
        if(jQuery(this).hasClass("material-select"))
        {
            paramNum = 4;
            var cnt = parseInt(jQuery("#cilinders-num").val());
            var offerItem = jQuery(".offer-item");
            offerItem.removeClass("disabled");
            jQuery(".materials-options").each(function(){
                var val2 = jQuery(this).find(".options-list .active .cilinder-count-title").text();
                if(val2.trim().toLowerCase() === "zwart" || val2.trim().toLowerCase() === "messing"/* || (cnt > 5 && (jQuery("#cilinders-num").hasClass("product-page") || jQuery("#cilinders-num").hasClass("single-product")))*/)
                {
                    offerItem.each(function(){
                        var name = jQuery(this).find("h2").text().toLowerCase();
                        if(name.indexOf("color pro") !== -1 || name.indexOf("color plus") !== -1)
                        {
                            jQuery(this).addClass("disabled");
                        }
                    });
                }

                if(val2.trim().toLowerCase() !== "nikkel" || (cnt > 5 && (jQuery("#cilinders-num").hasClass("product-page") || jQuery("#cilinders-num").hasClass("single-product"))))
                {
                    offerItem.each(function(){
                        var name = jQuery(this).find("h2").text().toLowerCase();
                        if(name.indexOf("move") !== -1)
                        {
                            jQuery(this).addClass("disabled");
                        }
                    });
                }
            });
        }
        else if(jQuery(this).hasClass("extra-select"))
        {
            paramNum = 2;
        }
        else if(jQuery(this).hasClass("extra2-select"))
        {
            paramNum = 3;
        }
        var obj = jQuery(".cilinder-config-options:eq(" + numRow + ") .param-" + paramNum + " .param-value");
        obj.text(val);
        var option = jQuery(this).parent().find(".options-list .active .cilinder-count-title").attr("data-value");
        obj.attr("data-value", option);
        calc_products_prices();
        change_image(numRow);
        jQuery.fancybox.close();
    });
    jQuery(document).on("click", ".key-type-select", function () {
        var val = jQuery(this).parent().find(".options-list .active .cilinder-count-title").text();
        jQuery(".key-type").val(val);
        jQuery.fancybox.close();
    });
    jQuery(".make-order").click(function(){
        if(jQuery(this).closest(".offer-item").hasClass("disabled"))
        {
            return false;
        }
        var keyplanCalculation = jQuery(".keyplan-calculation");
        var addServicepen = jQuery(".add-servicepen");
        var obj = jQuery(this);
        obj.attr("disabled","disabled");
        obj.html("Loading... <div class='loader'></div>");
        if(keyplanCalculation.length != 0)
        {
            if (jQuery.fancybox) {
                jQuery.fancybox.open(
                    [
                        "<div class=\"main popup-container\"><div class='block-align-center'><div class='config-name'><div class='big-loader'></div><br/>Één moment geduld. Uw sluitplan wordt nu samengesteld.</div></div></div>"
                    ],
                    {
                        smallBtn: false,
                        modal: true,
                    }
                );
            }
        }
        jQuery.get(location.pathname + "?empty_cart", function() {
            var form = obj.parent().find(".forms-list form:first");
            var options = jQuery(".cilinder-config-block .cilinder-config-options");
            var pNum = parseInt(options.length);
            var qNum = 0;
            var params = [];
            var userImage = jQuery('#user-image');
            var keyType = obj.closest(".offer-item").find(".key-type");
            var startIndex = 0;
            if(keyplanCalculation.length != 0)
            {
                var kp = new FormData();
                kp.append("add-to-cart", keyplanCalculation.data("id"));
                kp.append("quantity", 1);
                params[0] = kp;
                pNum++;
                startIndex++;
            }
            if(addServicepen.length != 0)
            {
                var sp = new FormData();
                sp.append("add-to-cart", addServicepen.data("id"));
                sp.append("quantity", 1);
                params[startIndex] = sp;
                pNum++;
                startIndex++;
            }
            options.each(function (index) {
                var fd = new FormData();
                fd.append("quantity", form.find("input[name='quantity']").val());
                fd.append("add-to-cart", form.find("input[name='add-to-cart']").val());
                jQuery(this).find(".param-value").each(function () {
                    fd.append(form.find("." + jQuery(this).attr("data-field")).attr("name"), jQuery(this).attr("data-value"));
                });
                if (userImage.length != 0) {
                    jQuery.each(userImage[0].files, function (i, file) {
                        fd.append(userImage.attr("name"), resizedFile, resizedFileName);
                        //fd.append(userImage.attr("name"), file);
                    });
                }
                if (keyType.length != 0) {
                    if (keyType.val()) {
                        fd.append(keyType.attr("name"), keyType.val());
                    }
                }
                var cilinderNameField = obj.closest(".offer-item").find(".cilinder-name-field");
                var cilinderName = jQuery(this).find(".cilinder-name");
                if (cilinderNameField.length != 0 && cilinderName.length != 0) {
                    fd.append(cilinderNameField.data("name"), cilinderName.text());
                }
                params[index - ( -startIndex)] = fd;
            });
            var keysNum = parseInt(jQuery("#sleutels-num").val());
            var userKeys = jQuery(".user-keys-val");
            if (userKeys.length == 0) {
                if (keysNum > 0) {
                    var keyId = parseInt(obj.attr("data-key-id"));
                    var keyData = new FormData();
                    keyData.append("quantity", keysNum);
                    keyData.append("add-to-cart", keyId);
                    params[pNum] = keyData;
                    pNum++;
                }
            }
            else {
                var userKeysNum = 0;
                var ind = 0;
                var indExtra = 0;
                var accessParamsBlock = obj.closest(".offer-item").find(".access-params-names");
                userKeys.each(function(){
                    if(jQuery(this).val() != "") {
                        userKeysNum += parseInt(jQuery(this).val());
                    }
                });
                jQuery(".access-params-block .access-row").each(function(){
                    var accessKeysNum = jQuery(this).find(".access-keys-num");
                    if(accessKeysNum.text() != "") {
                        var keyId = parseInt(obj.attr("data-key-id"));
                        var keyData = new FormData();
                        var extraKeyQuantity = parseInt(accessKeysNum.text());
                        ind += extraKeyQuantity;
                        keyData.append("add-to-cart", keyId);
                        keyData.append(accessParamsBlock.data("name-user"), jQuery(this).find(".sleutel-name").text());
                        var accessParams = "";
                        jQuery(this).find(".access-block.active").each(function(index){
                            if(index != 0)
                            {
                                accessParams += ", ";
                            }
                            accessParams += jQuery(this).text();
                        });
                        if(accessParams == "")
                        {
                            accessParams = "*masterkey";
                        }
                        keyData.append(accessParamsBlock.data("name-access"), accessParams);
                        if (indExtra < keysNum) {
                            indExtra += extraKeyQuantity;
                            if(indExtra > keysNum)
                            {
                                var correction = indExtra - keysNum;
                                extraKeyQuantity -= correction;
                                var temp = new FormData();
                                temp.append("add-to-cart", keyId);
                                temp.append(accessParamsBlock.data("name-user"), jQuery(this).find(".sleutel-name").text());
                                temp.append(accessParamsBlock.data("name-access"), accessParams);
                                temp.append(accessParamsBlock.data("name-price"), jQuery(".key-price").data("value"));
                                temp.append("quantity", correction);
                                params[pNum] = temp;
                                pNum++;
                            }
                            keyData.append(accessParamsBlock.data("name-price"), jQuery(".extra-key-price").data("value"));
                        }
                        else {
                            keyData.append(accessParamsBlock.data("name-price"), jQuery(".key-price").data("value"));
                        }
                        keyData.append("quantity", extraKeyQuantity);
                        params[pNum] = keyData;
                        pNum++;
                    }
                });
                if(ind < get_sleutels_num(options.length))
                {
                    var masterkeyNum = get_sleutels_num(options.length) - ind;
                    var masterkeyId = parseInt(obj.attr("data-key-id"));
                    var masterkeyData = new FormData();
                    masterkeyData.append("quantity", masterkeyNum);
                    masterkeyData.append("add-to-cart", masterkeyId);
                    masterkeyData.append(accessParamsBlock.data("name-user"), "Masterkey");
                    masterkeyData.append(accessParamsBlock.data("name-access"), "*masterkey");
                    masterkeyData.append(accessParamsBlock.data("name-price"), jQuery(".key-price").data("value"));
                    params[pNum] = masterkeyData;
                    pNum++;
                }
            }
            send_params(params, qNum, pNum);
        });
    });
    var uploadText = jQuery(".offer-item .upload-text").text();
    jQuery("#user-image").change(function (e) {
        var files = e.target.files;
        var file = files[0];
        if(file)
        {
            jQuery(this).closest(".offer-item").find(".upload-text").text(file.name);
            //
            // Ensure it's an image
            if(file.type.match(/image.*/)) {
                console.log('An image has been loaded');

                // Load the image
                var reader = new FileReader();
                reader.onload = function (readerEvent) {
                    var image = new Image();
                    image.onload = function (imageEvent) {

                        // Resize the image
                        var canvas = document.createElement('canvas'),
                            max_size = 1200,
                            width = image.width,
                            height = image.height;
                        if (width > height) {
                            if (width > max_size) {
                                height *= max_size / width;
                                width = max_size;
                            }
                        } else {
                            if (height > max_size) {
                                width *= max_size / height;
                                height = max_size;
                            }
                        }
                        canvas.width = width;
                        canvas.height = height;
                        canvas.getContext('2d').drawImage(image, 0, 0, width, height);
                        var dataUrl = canvas.toDataURL('image/jpeg');
                        //this.src = dataUrl;
                        resizedFile = dataURLToBlob(dataUrl);
                        resizedFileName = file.name;
                    }
                    image.src = readerEvent.target.result;
                }
                reader.readAsDataURL(file);
            }
            else
            {
                resizedFile = file;
                resizedFileName = file.name;
            }
        }
        else
        {
            jQuery(this).closest(".offer-item").find(".upload-text").text(uploadText);
            resizedFile = null;
            resizedFileName = null;
        }
    });
    jQuery(".upload-image").click(function (e) {
        e.preventDefault();
        jQuery("#user-image").click();
    });
    jQuery(".offer-item-table .offer-item").click(function(){
        jQuery(".offer-item-table .offer-item").removeClass("selected");
        jQuery(this).addClass("selected");
        calc_products_prices();
    });
    calc_products_prices();
    change_image_keyplan();
    set_cols_height();
    //product page end
    //cart image upload
    jQuery(".user-image").change(function (e) {
        var files = e.target.files;
        var file = files[0];
        if(file)
        {
            jQuery(this).closest(".checkout-products-data").find(".upload-text").text(file.name);
        }
        else
        {
            jQuery(this).closest(".checkout-products-data").find(".upload-text").text(uploadText);
        }
    });
    jQuery(".upload-image-cart").click(function (e) {
        e.preventDefault();
        jQuery(this).closest(".checkout-products-data").find(".user-image").click();
    });
    //keyplan
    jQuery("#more-user-sleutels").click(function () {
        jQuery(this).hide();
        var sleutelsNum = jQuery("#user-sleutels-num");
        sleutelsNum.show();
        jQuery("#select-keys").next(".cilinder-count").find(".cilinder-count-item").removeClass("active");
    });
    jQuery(document).on("change", ".user-keys-val", function(){
        var ci = jQuery(this).closest(".cilinder-count-item");
        var index = jQuery("#select-user-departments").find(".cilinder-count-item").index(ci);
        var ar = jQuery(".access-params-block").find(".access-row").eq(index);
        ar.find(".access-keys-num").text(jQuery(this).val());
        if(jQuery(this).val() > 0)
        {
            ar.show();
        }
        else
        {
            ar.hide();
        }
        var keysCount = 0;
        var addKeys;
        var cilinderCount = parseInt(jQuery("#cilinders-num").val());
        jQuery(".user-keys-val").each(function(){
            if(jQuery(this).val() != "") {
                keysCount += parseInt(jQuery(this).val());
            }
        });
        addKeys = keysCount - cilinderCount;
        if(addKeys < 0)
        {
            addKeys = 0;
        }
        jQuery("#sleutels-num").val(addKeys).trigger("change");
    });
    if(jQuery(".user-keys-val").length > 0) {
        jQuery(".user-keys-val").trigger("change");
    }
    jQuery(document).on("input, keyup",".cilinder-config-block .cilinder-name",function(){
        var val = jQuery(this).text();
        var ci = jQuery(this).closest(".cilinder-config-options");
        var index = jQuery(".cilinder-config-block").find(".cilinder-config-options").index(ci);
        jQuery(".access-params").each(function(){
            var block = jQuery(this).find(".access-block").eq(index);
            block.find(".cilinder-name").text(val);
        });
    });
    jQuery(document).on("input, keyup","#select-user-departments .sleutel-name",function(){
        var ci = jQuery(this).closest(".cilinder-count-item");
        var index = jQuery("#select-user-departments").find(".cilinder-count-item").index(ci);
        var ar = jQuery(".access-params-block").find(".access-row").eq(index);
        ar.find(".sleutel-name").text(jQuery(this).text());
    });
    jQuery(document).on("input, keyup",".access-params-block .sleutel-name",function(){
        var ci = jQuery(this).closest(".access-row");
        var index = jQuery(".access-params-block").find(".access-row").index(ci);
        var ar = jQuery("#select-user-departments").find(".cilinder-count-item").eq(index);
        ar.find(".sleutel-name").text(jQuery(this).text());
    });
    jQuery(document).on("click", ".access-block", function(){
        if(jQuery(this).hasClass("active"))
        {
            jQuery(this).removeClass("active");
        }
        else
        {
            jQuery(this).addClass("active");
        }
    });
    jQuery("#user-sleutels-num").change(function () {
        var val = jQuery(this).val();
        var parent = jQuery("#select-user-departments");
        var oldUserCnt = parent.find(".cilinder-count-item").length;
        if(val > 0 && val != oldUserCnt)
        {
            if(val > oldUserCnt)
            {
                var lastItem = parent.find(".cilinder-count-item").last();
                var lastAccessItem = jQuery(".access-params-block").find(".access-row").last();
                for (var i = oldUserCnt; i < val; i++) {
                    var newItem = lastItem.clone();
                    var ind = i - (-1);
                    newItem.find(".cilinder-count-title .num").text(ind);
                    newItem.find(".user-keys-val").val(0);
                    parent.append(newItem);
                    var newAccessItem = lastAccessItem.clone();
                    newAccessItem.find(".cilinder-count-title .num").text(ind);
                    newAccessItem.find(".access-block").removeClass("active");
                    newAccessItem.find(".access-keys-num").text("0");
                    newAccessItem.hide();
                    jQuery(".access-params-block").append(newAccessItem);
                }
            }
            else
            {
                for (var i = val; i < oldUserCnt; i++) {
                    parent.find(".cilinder-count-item").eq(i).find(".user-keys-val").val(0).trigger("change");
                }
            }
        }
    });
    jQuery(document).on("change", ".param-5 input[type='checkbox'],.param-6 input[type='checkbox']", function() {
        var obj = jQuery(this).parent().find(".param-value");
        var label = jQuery(this).parent().find("label");
        var val = jQuery(this).data("uncheked-value");
        var text = jQuery(this).data("uncheked-label");
        var paramSize = jQuery(this).closest(".cilinder-params").find(".param-1");
        if(jQuery(this).prop("checked"))
        {
            val = jQuery(this).val();
            text = label.text();
            paramSize.find("select").attr("disabled", "disabled");
            paramSize.find(".param-value").attr("data-value", "");
            paramSize.find(".param-value").text("");
        }
        else
        {
            paramSize.find("select").removeAttr("disabled");
            paramSize.find(".param-value").attr("data-value", paramSize.find("select").find("option:eq(1)").data("value"));
            paramSize.find(".param-value").text(paramSize.find("select").find("option:eq(1)").val());
        }
        obj.attr("data-value", val);
        obj.text(text);
        var numRow = jQuery(this).closest(".cilinder-config-options").index();
        if(jQuery(this).closest(".checkout-products-data").length != 0)
        {
            numRow = jQuery(this).closest(".checkout-products-data").index();
        }
        change_image(numRow);
        calc_products_prices();
    });
    //keyplan end
    //checkout page
    jQuery(".billing-address-1,.billing-address-2").change(function(){
        jQuery("#billing_address_1").val(jQuery(".billing-address-1").val() + ", " + jQuery(".billing-address-2").val());
    });
    jQuery(".shipping-address-1,.shipping-address-2").change(function(){
        jQuery("#shipping_address_1").val(jQuery(".shipping-address-1").val() + ", " + jQuery(".shipping-address-2").val());
    });
    jQuery("#payment_address_shipping_address").click(function () {
        jQuery("#ship-to-different-address-checkbox").click();
    });
    var sleutelsInfo = jQuery("#checkout-sleutels-info");
    if(sleutelsInfo.length != 0)
    {
        sleutel_num_upd();
        setInterval(sleutel_num_upd, 1000);
    }
    jQuery(document).on("click", ".order-extra-key", function(){
        var keyId = parseInt(jQuery(this).data("key-id"));
        var quantity = parseInt(jQuery(this).closest(".extra-product").find(".ep-select").val());
        if(keyId > 0 && quantity > 0) {
            var data = new FormData();
            data.append("add-to-cart", keyId);
            data.append("quantity", quantity);
            jQuery.ajax({
                url: location.href,
                type: 'POST',
                dataType: 'json',
                processData: false,
                contentType: false,
                cache: false,
                data: data,
            }).always(function() {
                location.reload();
            });
        }
    });
    jQuery(document).on("click", ".order-extra-product", function(){
        var id = parseInt(jQuery(this).data("id"));
        var obj = jQuery(this);
        if(id > 0) {
            var data = new FormData();
            data.append("add-to-cart", id);
            data.append("quantity", 1);
            var option = jQuery(".sp-option");
            if(option.length !== 0)
            {
                option.each(function(){
                    var selectedOption = jQuery(this).find("input[type=radio]:checked");
                    if(selectedOption.length !== 0)
                    {
                        data.append(selectedOption.attr("name"), selectedOption.val());
                    }
                });
            }
            obj.html("Loading... <div class='loader'></div>");
            jQuery.ajax({
                url: location.href,
                type: 'POST',
                dataType: 'json',
                processData: false,
                contentType: false,
                cache: false,
                data: data,
            }).always(function () {
                if (location.pathname !== "/checkout/") {
                    location.href = "/cart/";
                } else {
                    location.reload();
                }
            });
        }
    });
    var cilinders = jQuery(".checkout-products-data");
    if(cilinders.length != 0)
    {
        change_image_upd();
        setInterval(change_image_upd, 500);
    }
    //checkout page end
    //cart
    jQuery("#empty-cart").click(function (e) {
        e.preventDefault();
        jQuery.get("/cart/?empty_cart",function(){
            location.reload();
        });
    });
    jQuery(".checkout-products-data .show-cilinder-params").click(function () {
        var productData = jQuery(this).closest(".checkout-products-data");
        productData.find(".cilinder-count-title").show();
        jQuery(".param-disabled").attr("data-fancybox", "");
        productData.find(".change-param-value").show().removeAttr("disabled").removeClass("param-disabled");
        productData.find(".image-upload-form").show();
        jQuery(this).hide();
        productData.find(".submit-cilinder-params").show();
        productData.find(".param-5").hide();
    });
    jQuery(".checkout-products-data .submit-cilinder-params").click(function () {
        var obj = jQuery(this);
        var pd = obj.closest(".checkout-products-data");
        obj.hide();
        jQuery.post(location.pathname, {cart_item_key:obj.data("cart-item-key"),new_qty:parseInt(obj.data("qty-value")) - 1}, function() {
            var options = pd.find(".cilinder-config-options");
            //var pNum = parseInt(options.length);
            var qNum = 0;
            var params = [];
            var userImage = pd.find('.user-image');
            var keyType = pd.find(".key-type");
            var startIndex = 0;
            options.each(function (index) {
                var fd = new FormData();
                fd.append("quantity", 1);
                fd.append("add-to-cart", obj.data("product-id"));
                jQuery(this).find(".param-value").each(function () {
                    if(jQuery(this).attr("data-field") && jQuery(this).attr("data-value")) {
                        fd.append(jQuery(this).attr("data-field"), jQuery(this).attr("data-value"));
                    }
                });
                if (userImage.length != 0) {
                    jQuery.each(userImage[0].files, function (i, file) {
                        fd.append(userImage.attr("name"), file);
                    });
                }
                if (keyType.length != 0) {
                    if (keyType.val()) {
                        fd.append(keyType.attr("name"), keyType.val());
                    }
                }
                var cilinderName = jQuery(this).find(".cilinder-name");
                if (cilinderName.length != 0) {
                    fd.append(cilinderName.attr("data-field"), cilinderName.text());
                }
                params[index - ( -startIndex)] = fd;
            });
            jQuery.ajax({
                url: location.href,
                type: 'POST',
                dataType: 'json',
                processData: false,
                contentType: false,
                cache: false,
                data: params[qNum],
            }).always(function() {
                location.reload();
            });
        });
    });
    jQuery(".param-6 input[type='checkbox']:checked").each(function () {
        jQuery(this).trigger("change");
    });
    //cart end
    if(location.hash == "#bestellen")
    {
        jQuery('html, body').animate({
            scrollTop: jQuery("#select-cilinder").offset().top
        }, 2000);
    }
    //save to excel
    jQuery(document).on("click", ".save-excel-btn", function (e) {
        e.preventDefault();
        jQuery.post(location.pathname + "?action=download_keyplan", {user_file: jQuery(".excel-filename").val()}, function (res) {
            jQuery(".save-excel-block").html("Naam sluitplan is:<br/>" + "<strong>" + res + "</strong>");
        });
        jQuery(".save-excel-block").html("Loading...");
        return false;
    });
    jQuery("#vat_number-description").tooltip({
        html:true,
        title: function() {
            return jQuery(this).html();
        }
    });
    //disable address 1 field for NL
    jQuery("#billing_country").change(function(){
        if(jQuery(this).val() == "NL")
        {
            jQuery("#billing_address_1_field").addClass("hidden-field");
        }
        else
        {
            jQuery("#billing_address_1_field").removeClass("hidden-field");
        }
    });
    jQuery("#shipping_country").change(function(){
        if(jQuery(this).val() == "NL")
        {
            jQuery("#shipping_address_1_field").addClass("hidden-field");
        }
        else
        {
            jQuery("#shipping_address_1_field").removeClass("hidden-field");
        }
    });
});
jQuery(window).on('resize', function() {
    resize_images();
    resize_access_table();
    set_cols_height();
});
jQuery(window).on("load",function(){
    jQuery(".table-wrapper").mCustomScrollbar({
        axis: "x",
        theme: "inset-3-dark",
        scrollButtons:{
            enable:true,
            scrollType:"stepped"
        },
    });
});
