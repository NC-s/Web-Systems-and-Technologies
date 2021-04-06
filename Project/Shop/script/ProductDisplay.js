$(document).ready(function() {			

	$("#dropdownSearch").on('show.bs.collapse', function() {
		$(".sticky-top").css({
			"top": "113px",
			"transition": "0.5s"
		});
	});
	
	$("#dropdownSearch").on('hide.bs.collapse', function() {
		$(".sticky-top").css({
			"top": "75px",
			"transition": "0.5s"
		});
	});			
	
	$('.productName').hover(
		function() {
			var element = $(this)
							.clone()
							.css({display: 'inline', width: 'auto', visibility: 'hidden'})
							.appendTo('body');
			if (element.width() > $(this).width()) {            
				$(this).wrap("<div class='productNameWrapper'></div>");
				$(this).css("margin-left", $(this).width()-element.width() - 1 + "px");			
			}
			element.remove();
		},
		function() {
			$(this).css("margin-left", "0px");
		}
	);
	
	var resizeDelay = 200;
	var doResize = true;
	var resizer = function () {
	   if (doResize) {
		$('textarea').not("[data-itemid='0']").each(function () {
			this.style.height = 'auto';
			this.style.height = (this.scrollHeight) + 'px';
		});
		doResize = false;
	   }
	};
	var resizerInterval = setInterval(resizer, resizeDelay);
	resizer();

	$(window).resize(function() {
	  doResize = true;
	});
	
	$('textarea').each(function () {
		$(this).not("[data-itemid='0']").css({				
			'height': $(this).prop('scrollHeight'),
			'overflow-y': 'hidden'
		})
	}).on('input', function () {
		this.style.height = 'auto';
		this.style.height = (this.scrollHeight) + 'px';
	});
	
	$('.nav-tabs a').on('shown.bs.tab', function(){
		$('textarea').each(function () {
			$(this).not("[data-itemid='0']").css({				
				'height': $(this).prop('scrollHeight'),
				'overflow-y': 'hidden'
			});
		});
	});
	
	
	$(".cart").click(function () {			
			if ($(this).data('stock') != 0) {
				$.post( "addCart.php", {
					itemid: $(this).data('itemid'),
					qty: ($('#quantity').length) ? $('#quantity').val() : "1"
				},
				function(data) {
					if (data.indexOf("Success") != -1) {
						$(".cart-alert").removeClass("alert-danger");
						$(".cart-alert").addClass("alert-success");
						$(".cart-alert").html(data);
					}
					else {
						$(".cart-alert").removeClass("alert-success");
						$(".cart-alert").addClass("alert-danger");
						$(".cart-alert").html(data);
					}
					$(".cart-alert").fadeIn();
					setTimeout(function() {
						$(".cart-alert").fadeOut();
					}, 5000);
				});
			}
			else {
				$(".cart-alert").removeClass("alert-success");
				$(".cart-alert").addClass("alert-danger");
				$(".cart-alert").text("This item is out of stock!");
				$(".cart-alert").fadeIn();
				setTimeout(function() {
					$(".cart-alert").fadeOut();
				}, 3500);
			}
	});
	
	$(".fav").click(function() {
		if ($("#UserMenu").length) {
			$this = $(this);
			$.post( "toggleFavourite.php", {
				userid: $("#UserMenu").contents().filter(function() {
					return this.nodeType == 3;
				}).text(),
				itemid: $this.data('itemid')
			},
			function(data) {
				$this.text(data);
			});
		}
		else window.location.href = "Login.php";
	});
});	