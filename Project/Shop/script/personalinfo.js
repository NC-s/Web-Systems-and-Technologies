$(document).ready(function() {
		
    $('textarea').each(function () {
        $(this).css({				
            'height': 'auto',
            'overflow-y': 'hidden'
        })
    }).on('input', function () {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
    
    $("#changePasswordRequest").click(function() {
        if ($("#changePasswordRequest").val() != "Save") {	
            $("#password").slideDown();
            $("#changePassword").slideDown();
            $("#changePasswordRequest").val("Save");	
        }
        else {
            updateInfo();
        }
    });
    
    $("input").blur(function() {
        if ($(this).val() == "") {
            $(this).addClass("invalid");
            $(this).next("small").removeClass("text-muted");
            $(this).next("small").text("This field should not be blank!");
        }
    });
    
    $("input").keyup(function(e) {
        if (e.keyCode == 8) {
            if ($(this).val() == "") {
                $(this).addClass("invalid");
                $(this).next("small").removeClass("text-muted");
                $(this).next("small").text("This field should not be blank!");
            };
            if ($(this).is("#inputNewPassword")) {					
                if ($(this).val() != "") {
                    if ($("#inputNewPassword").val().length < 8) {
                        $("#PasswordHint").removeClass("text-muted");
                        $("#PasswordHint").text("Your password must be 8-20 characters long.");
                        $("#inputNewPassword").addClass("invalid");
                    }
                }
            };
        }
        else {
            $(this).next("small").text("");
            
            if ($("#inputPassword").val() != "") {
                $("#inputPassword").next("small").addClass("text-muted");
                $("#inputPassword").removeClass("invalid");
                $("#inputPassword").next("small").text("Input password to perform any changes");
            };
            if ($("#inputNewPassword").val().length >= 8) {
                $('#inputConfirmPassword').prop('disabled', false);
                $('#inputNewPassword').removeClass("invalid");
                $("#PasswordHint").addClass("text-muted");
                $("#PasswordHint").text("");
            }
            else {
                $("#PasswordHint").text("Your password must be 8-20 characters long.");
            };
            if ($("#inputConfirmPassword").val() == $("#inputNewPassword").val()) {
                $("#inputConfirmPassword").removeClass("invalid");
                $("#ConfirmPasswordHint").addClass("text-muted");
                $("#ConfirmPasswordHint").text("");
            };
            if ($(this).is("#inputAddress"))
                $(this).removeClass("invalid");
        }
    });
    
    $("#inputConfirmPassword").change(function() {
        if ($(this).val() != $("#inputNewPassword").val()) {
            $("#ConfirmPasswordHint").removeClass("text-muted");
            $("#ConfirmPasswordHint").text("Those password didn't match. Try again.");
            $("#inputConfirmPassword").addClass("invalid");
        }
    });
    
    $("#inputEmail").change(function() {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if(!$(this).val().match(re)){				
            $(this).addClass("invalid");
            $(this).next("small").removeClass("text-muted");
            $(this).next("small").text("Please enter a valid email address");
        }else{
            $(this).removeClass("invalid");
            $(this).next("small").addClass("text-muted");
            $(this).next("small").text("");
        }
    });	
    
    $("#changeEmailRequest").click(function() {
        if ($("#changeEmailRequest").val() != "Save") {
            $("#inputEmail").prop('readonly', function(i,r) {
                $("#inputEmail").toggleClass("form-control-plaintext");
                $("#inputEmail").toggleClass("form-control");
                return !r;
            });		
            
            $("#password").slideDown();
            $("#changeEmailRequest").val("Save");
        }
        else {
            updateInfo();
        }
    });	

    $("#changeAddressRequest").click(function() {
        if ($("#changeAddressRequest").val() != "Save") {
            $("#inputAddress").prop('readonly', function(i,r) {
                $("#inputAddress").toggleClass("form-control-plaintext");
                $("#inputAddress").toggleClass("form-control");
                return !r;
            });
            
            $("#password").slideDown();
            $("#changeAddressRequest").val("Save");
        }
        else {
            updateInfo();
        }
        
    });	
    
    $("#createShopRequest").click(function() {
        if (!$("#createShop").is(":visible")) {
            $("#createShop").slideDown();
            $("#inputShopInfo").css("resize", "vertical");
        }
        else {
            $.post( "createShop.php", {
                userid: $("#userID").val(),
                shopname: $("#inputShopName").val(),
                shopinfo: $("#inputShopInfo").val()
            },
            function(data) {
                location.reload();
            });
        }
    });
    
    function updateInfo() {
        var valid = 1;
        
        if ($("#inputPassword").val() == "") 
            valid = 0;
        if ($("#inputNewPassword").val() != "") {
            if ($("#inputNewPassword").val().length < 8)
                valid = 0;
            if ($("#inputConfirmPassword").val() != $("#inputNewPassword").val())
                valid = 0;
        }
        if ($("#inputEmail").val() == "")
            valid = 0;
        if ($("#inputAddress").val() == "")
            valid = 0;
        
        if (valid == 1) {
            $.post( "updateInfo.php", {
                info: $("#personalInfo").serialize()
            },
            function(data) {
                if (data.indexOf("Success") != -1) {						
                    $("#password").hide();
                    $("#inputPassword").val("");
                    $("#changePassword").hide();
                    $("#inputNewPassword").val("");
                    $("#inputConfirmPassword").val("");
                    $("input:text:visible").prop("readonly", true);
                    $("input:text:visible").addClass("form-control-plaintext");
                    $("input:text:visible").removeClass("form-control");
                    $("input:button").val("Edit");
                    $("#changePasswordRequest").val("Change Password");
                    $(".alert").fadeIn();
                    setTimeout(function() {
                        $(".alert").fadeOut();
                    }, 3500);
                }
                else {
                    $("#inputPassword").addClass("invalid");
                    $("#inputPassword").next("small").removeClass("text-muted");
                    $("#inputPassword").next("small").text("Your password is incorrect.");
                }
            });	
        }				
    }
    
});