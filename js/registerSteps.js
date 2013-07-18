
$(document).ready(function() {
  
	jQuery.extend(jQuery.easing, {
		slowToFast: function (x, t, b, c, d) {
			return Math.pow(x, 6);
		},
		fastToSlow: function (x, t, b, c, d) {
			return Math.sqrt(x);
		}
	});
	
	/**
	 * Boxen mit Info zu Prices & Game
	 */
	$('#flyabout').bind('click', function(e){
		if($('#flyabout').hasClass('active')){
			$('#homeHeadline').css({'background-position': '0px 0px'});
			$('.boxLeft').removeClass('activeBox');
			$('#allofit').animate({
				marginTop: '0px'
			}, 450, 'fastToSlow', function(){
				$('#flyabout').removeClass('active');
			});
		} else {
			$('#homeHeadline').css({'background-position': '0px -15px'});
			$('.boxLeft').addClass('activeBox');
			$('.boxRight').removeClass('activeBox');
			$('#allofit').animate({
				marginTop: '-419px'
			}, 450, 'fastToSlow', function(){
				$('#flyabout').addClass('active');
				$('#win').removeClass('active');
			});
		}
		e.preventDefault();
	});
	
	$('#win').bind('click', function(e){
		$('.boxRight').removeClass('activeBox');
		if($('#win').hasClass('active')){
			$('#homeHeadline').css({'background-position': '0px 0px'});
			$('#allofit').animate({
				marginTop: '0px'
			}, 450, 'fastToSlow', function(){
				$('#win').removeClass('active');
			});
		} else {
			$('#homeHeadline').css({'background-position': '0px -30px'});
			$('.boxRight').addClass('activeBox');
			$('.boxLeft').removeClass('activeBox');
			$('#allofit').animate({
				marginTop: '-900px'
			}, 450, 'fastToSlow', function(){
				$('#win').addClass('active');
				$('#flyabout').removeClass('active');
			});
		}
		e.preventDefault();
	});
	
	/**
	 * Schritt 3: zur Karte weiterleiten -> in den Spielverlauf
	 */
	$('#loadMap').live('click', function(e){	
		document.location.href= PAGE_URL+"dashboard";
		e.preventDefault();
	});
	
	$('#toMap').live('click', function(e){	
		document.location.href= PAGE_URL+"dashboard";
		e.preventDefault();
	});

});
