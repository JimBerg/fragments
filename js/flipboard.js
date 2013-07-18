
	(function($) {
	  jQuery.fn.backgroundPosition = function() {
	    var p = $(this).css('background-position');
	    if(typeof(p) === 'undefined') return $(this).css('background-position-x') + ' ' + $(this).css('background-position-y');
	    else return p;
	  };
	})(jQuery);
	(function(){
	  if(!Array.indexOf){
	    Array.prototype.indexOf = function(obj){
	        for(var i=0; i<this.length; i++){
	            if(this[i]==obj){
	                return i;
	            }
	        }
	        return -1;
	    }
	}
	})();
	//THIS CODE IS ON A "DON'T ASK DON'T TELL POLICY"

	var number_width = 11;
	var letter_width = 12;
	var numbers_font_file_width = number_width * 3 * 11;
	var letters_font_file_width = letter_width * 3 * 29;
	intervals = [];

	function decreaseCountdownTimer( element, hours, minutes, seconds) {
    		var start = new Date().getTime();

//		seconds = parseInt(seconds);
//		minutes = parseInt(minutes);
//		hours = parseInt(hours);

		seconds--;
		if (seconds<0) {
			seconds=59;
			minutes--;

			if ( minutes<0 ) {
				minutes = 59;
				hours--;
				if ( hours < 0 )
					hours = 0;
					minutes = 0;
					seconds = 0;
			}
		}
		var textSeconds = seconds;
		var textMinutes = minutes;
		var textHours =  hours;

		if ( textHours<10 ) textHours = '0' + '' + textHours;
		if ( textMinutes<10 ) textMinutes = '0' + '' + textMinutes;
		if ( textSeconds<10 ) textSeconds = '0' + '' + textSeconds;
		
		var textToWrite = textHours + ':' + textMinutes + ':' + textSeconds;
		
		if (window.stopFlipboardTimer) {
			textToWrite = '00:00:00';
		}
		
		if ( intervals.length <= 0 )
			change_to(textToWrite, false, element, 5 );

		var elapsed = new Date().getTime() - start;
		
		setTimeout(function(){
			decreaseCountdownTimer( element, hours, minutes, seconds);
		}, 1000 );
	}

	var flipboardsCreated = false;
	function createFlipboards(){
		if (flipboardsCreated) return;
		flipboardsCreated = true;

		var letter_flipboards = $('.flipDisplay .letters');
		var number_flipboards = $('.flipDisplay .numbers');


		$(letter_flipboards).each(function(){

			var textToWrite = $(this).html();

			textToWrite = textToWrite.substring(0, 11);
			$(this).html('');
			$(this).css("visibility", "visible");

			var initial_text = randomString(10, true);
			write_letters(initial_text, $(this));

			var parent = this;
			setTimeout(function(){
				change_to( textToWrite.toUpperCase(), true, $(parent), 50 );
			}, 1000);

		});

		$(number_flipboards).each(function(){
			var textToWrite = $(this).html();
			var countdown = '';
			if ( $(this).parent().parent().hasClass('countdown_timer') ) {
				var seconds = 0;
				var minutes = 0;
				var hours = 0;


				countdown = textToWrite;
				countdown = countdown.split(':');
				if (countdown.length == 3) {
					hours = parseInt( countdown[0], 10 );
					minutes = parseInt( countdown[1], 10 );
					seconds = parseInt( countdown[2], 10 );
				}
				else if (countdown.length == 2){
					minutes = parseInt( countdown[0], 10 );
					seconds = parseInt( countdown[1], 10 );
				}
				else {
					seconds = parseInt( countdown[0], 10 );
				}

			}
			
			
			textToWrite = textToWrite.substring(0, 11);

			$(this).html('');
			$(this).css("visibility", "visible");

			var initial_text = randomString(5, false);
			write_numbers(initial_text, $(this));

			var parent = this;
			var speed;
			if (countdown)
				speed = 5;
			else
				speed = 50;
			setTimeout(function(){
				change_to(textToWrite, false, $(parent), speed );
			}, 1000);

			if (countdown)
				setTimeout( function(){decreaseCountdownTimer( $(parent), hours, minutes, seconds)}, 3000);
		});
	}
	//var parent = $('.flipDisplay ._marked');


	
	//write_letters(initial_text);
	//write_numbers(initial_text, parent);

	function randomString(string_length, letters) {
		var chars;
		if (letters)
			chars = "ABCDEFGHIJKLMNOPQRSTUVWXTZ";
		else
			chars = '0123456789';
		//var string_length = 8;
		var randomstring = '';
		for (var i=0; i<string_length; i++) {
			var rnum = Math.floor(Math.random() * chars.length);
			randomstring += chars.substring(rnum,rnum+1);
		}
		return randomstring;
	}
	function get_div_background_x_offset(element) {
		var background_pos = $( element ).backgroundPosition();

		//separate the x and y background positions
		var pos = background_pos.split(' ');
		//remove px from background-position-y
		 pos[0] = parseInt(pos[0]);
		 if ( isNaN( pos[0] ) ) pos[0] = 0;
		 return pos[0];
	}
	function increase_background_offset(element, offset) {

		var background_pos = $( element ).backgroundPosition();

		//separate the x and y background positions
		var pos = background_pos.split(' ');
		//remove px from background-position-y
		pos[0] = parseInt(pos[0]);
		if ( isNaN( pos[0] ) ) pos[0] = 0;
		pos[0] = pos[0] + offset;

		var new_pos = pos[0]+'px'+' '+pos[1];
		$( element ).css('background-position', new_pos);
		
	}

//		$('#start').click(function() {
//			var change_text;
//			if ($('#change_to_text').val())
//				change_text = $('#change_to_text').val();
//			else
//				change_text= randomString( 10 );
//			change_to(change_text.toUpperCase(), false, parent);
//
//		});
//		$('#stop').click(function() {
//			for (var i=0; i < intervals.length; i++){
//				clearInterval(intervals[i]);
//			}
//		});

	function get_char_offset(ch) {
		var char_code = ch.charCodeAt(0);
		
		if (char_code == 32) //space
			return false;//special offset we will decode later
		//figure out the correct offset
		if (char_code >= 48 && char_code <= 58) { //numbers and colon :
			//0 (ascii 48) is at 0px, 1 (ascii 49) is at 33px, 2 is at 66px etc
			return -1 * (char_code - 48) * 3 * number_width;
		}
		if (char_code >= 65 && char_code <= 90) { //letters without umlauts
			return -1 * (char_code - 65) * 3 * letter_width;
		}
		if (char_code == 196) //Ä 196
			return -1 * 26 * 3 * letter_width;
		if (char_code == 214) //Ö - 214
			return -1 * 27 * 3 * letter_width;
		if (char_code == 220) //Ü - 220
			return -1 * 28 * 3 * letter_width;

		return false;//return offset for space character in all other cases

	}
	function get_offsets(text) {
		var offsets = [];
		if (text)
		for (var i=0; i < text.length; i++) {
			offsets[i] = get_char_offset( text.charAt(i) );
			
		}
		return offsets;
	}
	function write_numbers(text, parent) {

		var div_class = 'flipboard_number';
		var offsets =  get_offsets(text);
	
		for (var i=offsets.length-1; i >= 0 ; i-- ) {
			var div = $("<div class='" + div_class + "'></div>").appendTo( parent );
			increase_background_offset(div, offsets[i]);
		}
	}
	function write_letters(text, parent) {

		var div_class = 'flipboard_letter';
		var offsets =  get_offsets(text);
		for (var i=offsets.length-1; i >= 0 ; i-- ) {
			var div = $("<div class='" + div_class + "'></div>").appendTo( parent );
			increase_background_offset(div, offsets[i]);
		}
	}
	function change_to(text, letters, parent, speed)
	{
		var div_class, width, font_file_width;
		if (letters) {
			div_class = 'flipboard_letter';
			width = letter_width;
			font_file_width = letters_font_file_width;
		}
		else {
			div_class = 'flipboard_number';
			width = number_width;
			font_file_width = numbers_font_file_width;
		}
		
		var divs =  parent.children() ;
		var current_text_length = divs.length;
		var new_text_length = text.length;

		//if new text is shorter than current text, add spaces in the beginning
		var step = -1* width;//or number


		//remove extra elements
		if (new_text_length < current_text_length) {
			for (var j=new_text_length; j < current_text_length ;j ++) {
				if ($( divs[j] ).hasClass(div_class)) {
					current_char_offset = get_div_background_x_offset(divs[j]);
					var offset_difference = -1 * ( font_file_width +  current_char_offset ) ;//or numbers

					create_remove_animation(speed, divs[j], offset_difference, step, div_class);
				}
			}
		}

		for (var i = new_text_length - 1; i >= 0; i--)
		{

			var current_div_number = (new_text_length - i - 1);
			var current_div = divs[ current_div_number ];

			if (current_div === undefined) { //we have to create the div
				current_div = $("<div class='" + div_class + "'></div>").appendTo(parent);
				
			}
			$(current_div).addClass(div_class);

			var current_char_offset = get_div_background_x_offset(current_div);
			var new_char_offset = get_char_offset ( text.charAt(i) );
			var offset_difference = 0;
			if (new_char_offset === false) { //we have space
				if ( $( current_div ).hasClass( div_class ) ) {
					offset_difference = -1 * ( font_file_width +  current_char_offset ) ;//or numbers

					create_remove_animation(speed, current_div, offset_difference, step, div_class);
				}

			}
			else {
				while (new_char_offset > current_char_offset)
					new_char_offset -= font_file_width; //or numbers
				offset_difference = new_char_offset - current_char_offset;

				create_timed_animation(speed, current_div, offset_difference, step);
			}
			//increase_background_offset(divs[i], offset_difference );
		}

	}
	function create_remove_animation(speed, element, offset_difference, step, div_class) {


		var interval = setInterval(function(){
		if (offset_difference <= step) {
			offset_difference -= step;
			increase_background_offset( element, step);
		}
		else {
			$(element).removeClass(div_class);
			$( element ).css('background-position', '0px top');
			clearInterval( interval );
			//remove from the intervals array
			var interval_index = intervals.indexOf( interval );
			if ( interval_index !=-1 ) {
				intervals.splice(interval_index, 1);
			}
		}
		}, speed );
		intervals.push( interval );
	}
	function create_timed_animation(speed, element, offset_difference, step) {
		var interval = setInterval(function(){
		if (offset_difference <= step) {
			offset_difference -= step;
			increase_background_offset( element, step);
		}
		else
			{
			clearInterval( interval );
			//remove from the intervals array
			var interval_index = intervals.indexOf( interval );
			if ( interval_index !=-1 ) {
				intervals.splice(interval_index, 1);
			}
			}
		}, speed );
		intervals.push( interval );

	}


		