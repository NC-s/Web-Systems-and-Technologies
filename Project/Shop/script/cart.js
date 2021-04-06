$(document).ready(function() {
    
    var grandTotal = 0;
    
    $("#checkAll").click(function() {
        $('input:checkbox').not(":disabled").prop('checked', this.checked);
        grandTotal = 0;
        if ($(this).is(':checked')) {            
            $("#Buy").prop('disabled', false);
            $('input:checkbox[data-itemid]').each(function() {
                var qty = $("input:text[data-itemid=" +  $(this).data('itemid') + "]").val();
                var price = $("small[data-itemid=" + $(this).data('itemid') + "]").data('price');
                grandTotal += qty * price;
            });
            $("#grandTotal").text("$" + grandTotal.toFixed(2));
        }
        else {
            $("#grandTotal").text("$0.00");
            grandTotal = 0;
            $("#Buy").prop('disabled', true);
        }
    });
    
    if ($(window).innerWidth() < 768) {
        $('img[data-itemid]').click(function() {
            var itemid = $(this).data('itemid');
            $('input:checkbox[data-itemid=' + itemid + ']').trigger('click');
        });
    }
    
    $('input:checkbox[data-itemid]').change(function() {
        var itemid = $(this).data('itemid');
        var qty = $("input:text[data-itemid=" + itemid + "]").val();
        var price = $("small[data-itemid=" + itemid + "]").data('price');

        var check = 0;

        if ($(this).is(':checked')) {
            check = 1;
            grandTotal += qty * price;
            $("#grandTotal").text("$" + grandTotal.toFixed(2));
            var checkedAll = true;
            $('input:checkbox[data-itemid]').not(":disabled").each(function() {
                if (!$(this).is(':checked')) 
                    checkedAll = false;					
            });
            if (checkedAll)
                $("#checkAll").prop("checked", true);
        }
        else {
            grandTotal -= qty * price;
            $("#checkAll").prop("checked", false);
            $("#grandTotal").text("$" + grandTotal.toFixed(2));
        }
        
        if (check == 1) 
            $("#Buy").prop('disabled', false);
        else $("#Buy").prop('disabled', true);
    });
    
    $("input:text").keyup(function() {
        var itemid = $(this).data('itemid');
        var price = parseFloat($("small[data-itemid=" + itemid + "]").data('price'));
        if (parseInt($(this).val()) > parseInt($(this).attr('max'))) {
            $(this).val($(this).attr('max'));
        }
        if (parseInt($(this).val()) <= 0) {
            $(this).val(1);
        }
        $.post( "updateCart.php", {
            itemid: itemid,
            qty: $(this).val()
        });	
        $("span[data-itemid=" + itemid + "]").text("$" + (price * $(this).val()).toFixed(2));
    });
        
    
    $(".addQuantity").click(function() {
        var itemid = $(this).data('itemid');
        var qty = parseInt($("input:text[data-itemid=" + itemid + "]").val());
        var price = parseFloat($("small[data-itemid=" + itemid + "]").data('price'));
        
        $("input:text[data-itemid=" + itemid + "]").val(qty + 1);
        $("input:text[data-itemid=" + itemid + "]").keyup();
        if ($("input:checkbox[data-itemid=" + itemid + "]").is(":checked")) {
            grandTotal += price;
            $("#grandTotal").text("$" + grandTotal.toFixed(2));
        }		
    });
    
    $(".subQuantity").click(function() {
        var itemid = $(this).data('itemid');
        var qty = parseInt($("input:text[data-itemid=" + itemid + "]").val());
        var price = parseFloat($("small[data-itemid=" + itemid + "]").data('price'));

        
        $("input:text[data-itemid=" + itemid + "]").val(qty - 1);
        $("input:text[data-itemid=" + itemid + "]").keyup();
        if ($("input:checkbox[data-itemid=" + itemid + "]").is(":checked")) {
            grandTotal -= price;
            $("#grandTotal").text("$" + grandTotal.toFixed(2));
        }			
    });
    

    $('[data-toggle=confirmation]').confirmation({
          rootSelector: '[data-toggle=confirmation]',
          singleton: true,
          popout: true,
          copyAttributes: 'data-itemid',
          btnOkClass: 'btn-lg btn-danger',
          btnOkIconClass: 'material-icons',
          btnCancelClass: 'btn-lg btn-secondary',
          btnCancelIconClass: 'material-icons',
          btnOkIconContent: 'check',
          btnCancelIconContent: 'close',
          onConfirm: function() {
            $.post( "deleteCart.php", {
                userid: $("#UserMenu").contents().filter(function() {
                    return this.nodeType == 3;
                }).text(),
                itemid: $(this).data('itemid')
            },
            function() {
                location.reload();
            });
          }
    });

    var itemid = [];
    var qty = [];

    $("#Buy").click(function() {
        if ($("#UserMenu").length) {
            itemid = [];
            qty = [];
            $('input:checkbox[data-itemid]').each(function() {
                if ($(this).is(':checked')) {
                    itemid.push($(this).data('itemid'));
                    qty.push($('input:text[data-itemid=' + $(this).data('itemid') + ']').val());
                }
            });
            $("#cart-item").empty();
            for (var i = 0; i < itemid.length; i++) {
                var item = "<div class='row align-items-center'><div class='col-md-3'><img src='" + $("img[data-itemid=" + itemid[i] +"]").attr('src') + "' class='img-fluid'></div><div class='col'>" + $(".productInfo[data-itemid=" + itemid[i] + "]").html() +"</div><div class='col-md-3'>QTY: " + $("input:text[data-itemid=" + itemid[i] + "]").val() +"</div></div><hr>";
                $("#cart-item").append(item);
            }
            $("#cart-item").append("<div class='row justify-content-center justify-content-md-start align-items-center'><div class='col-md-6'></div><div class='col-3 text-md-right'>Total: </div><div class='col-2'>" + $("#grandTotal").text() + "</div></div>");
            $("#confirmModal").modal('show');
        }
        else window.location.href = "Login.php";             
    });

    $("#ConfirmOrder").click(function() {
        $.post( "submitOrder.php", {
            userid: $("#UserMenu").contents().filter(function() {
                return this.nodeType == 3;
            }).text(),
            itemid: itemid,
            qty: qty
        },
        function(data) {
            grandTotal = 0;            
            $("#grandTotal").text("$" + grandTotal.toFixed(2));
            if ($("#checkAll").is(':checked')) {
                $(".container").empty();
                $(".container").html("<p class='text-center'>There is no item in cart yet!</p>");               
            }
            else {
                var i;
                for (i = 0; i < itemid.length; i++) {                    
                    $("div[data-itemid='" + itemid[i] + "']").remove();
                    $("hr[data-itemid='" + itemid[i] + "']").remove();
                }
            }
            $("#confirmModal").modal('hide');
            $(".buy-alert").fadeIn();
            setTimeout(function() {
                $(".buy-alert").fadeOut();
            }, 5000);          
        });
    });    
});	