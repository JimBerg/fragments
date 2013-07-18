<div id="footer">
	<div id="socialMediaBar">
	 	<div id="likeButton">
	 		<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
			<!-- <fb:like href="http://apps.facebook.com/jimsspielplatz" show_faces="true" width="450" height="120" send="true"></fb:like> -->
			<fb:like href="http://www.facebook.com/flyswiss" show_faces="true" width="450" height="120" send="true"></fb:like>

	 	</div>
		<?php if(isset($user) && $user && $user->getIsFan() == false) {?><div id="becomeFriend"></div><?php }?>
		
		<div class="twitterButtons">
			<div id="followUs">
				<span><?php echo __('Follow us')?></span>
				<a href="http://www.twitter.com/SwissAirLines" data-url="http://apps.facebook.com/fly-to-your-friends/" target="_blank"><img src="<?php echo sfConfig::get('sf_server_url'); ?>images/layout/twitter_follow.png"  alt="Follow" border="0"/></a>
				<!-- <a href="http://twitter.com/SwissAirLines" class="twitter-follow-button" data-show-count="false" style="width:61px; float:right"></a>-->
				
				</div>
			<div id="tweet">
				<span><?php echo __('Tweet a message')?></span>
				<a href="http://twitter.com/share" class="twitter-share-button" data-url="http://apps.facebook.com/fly-to-your-friends/" data-text="Seatbelt fastened, ready to take off. I’m flying around the world. @SwissAirLines #FTYF" data-count="none">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
				</div>
			<div class="starAlliance"><a href="http://staralliance.com" target="_blank" style="display:block; width:140px; height:14px;"></a></div>
		</div>
	</div>
	<div id="disclaimer">
		<p><?php echo nl2br('This promotion is in no way sponsored, endorsed or administered by, or associated with, Facebook. 
		You are providing your information to Swiss International Air Lines Ltd. and not to Facebook. 
		The information you provide will only be used for the notification of the winners.')?></p>
		<hr />
		<a href="#top_pos" onclick="showTerms()"><?php echo __('TERMS AND CONDITIONS')?></a> |
		<a href="#top_pos" onclick="showRules()"><?php echo __('GAME INSTRUCTIONS')?></a> |
		<a href="http://www.facebook.com/topic.php?uid=16565655722&topic=17631" target="_blank"><?php echo __('DISCUSSION FORUM')?></a>
	</div>
</div>

<div id="termsBox">
	<div id="termsHead"><h3></h3><a href="#" onclick="termsClose()" id="termsClose"></a></div>
	<div id="terms">
	<div class="termsBox">
	<div id="termsContent">
	<h2>Conditions of participation:</h2>
	<p>
	Participation in the SWISS contest is free of charge and free of obligation to acquire or use any products or services through payment. The participant does not engage in any contractual or otherwise legal obligations toward Swiss International Air Lines Ltd. (hereafter referred to as SWISS) or any third parties. Data provided by the participant is not transferred to third parties or shared with them for their use. Only persons who have reached the age of majority and are legally competent may take part in the contest. The contest is not open to employees of SWISS, members of their family, or agencies of SWISS and their employees. Only one player profile per person is permitted. Player profiles may not be transferred. By taking part in the contests participants declare themselves in agreement with the rules of the contest:
	</p>
	<h3>1. Privacy protection</h3>
	<p>SWISS declares that personal data (including e-mail addresses, etc.) relating to the participant will not be transferred to 
	third parties or shared with them for their usage. The only exception in this regard applies to the contest winner, 
	who expressly grants Swiss International Air Lines Ltd. permission to publish his/her name and town of residence. By taking part in the contest, participants expressly permit their e-mail address to be filed and used for statistical purposes by Swiss International Air Lines Ltd. For subscriptions to the SWISS Newsletter, the data provided will be filed for distribution purposes. Subscriptions to the Newsletter may be cancelled at any time via the link provided in the Newsletter.
	</p>

	<h3>2. Participation</h3>
	<p>Persons wishing to be eligible for the draw must have taken part in the contest and must have completed the relevant registration form. This information will be directly transferred to SWISS. No obligation to purchase applies. 
	<br />
	The contest begins on 07.06.11 at 00:00 and ends automatically at midnight (24:00) on 01.08.11
	<br />
	<ul>
	<li>The weekly draw prizes will take place for the period starting Tuesday at 00:00 and ending Monday at 24:00. The prizes will be drawn amongst the 10 best performing players.</li>
	<li>The draw for the grand prize («Round the world» ticket) as well as the draw for the other prizes will take place at the end of the contest period and drawn among every participant.</li>
	</ul>
	</p>

	<h3>3. Determining and informing the winners</h3>
	<p>Once the winners have been determined, they shall be informed in writing via the e-mail address provided. Winners are required to respond within 30 days. Otherwise, their prize shall be forfeited.
	</p>

	<h3>4. Distribution of prizes</h3>
	<p>Prizes shall be distributed only to prize-winners. Prizes shall be in the form of merchandise. They may not be exchanged or redeemed for equivalent cash value. Upon receipt of the winner’s response to the e-mail informing of their win, SWISS will automatically send the prize to the address on file, whereupon any risk relating to the merchandise prize lies with the winner. The prize-winner is responsible for any taxation that may apply to the prize. Flight vouchers cannot be passed on or sold to third parties. Flight vouchers are redeemable only on flights operated by SWISS, with the exception of charter flights. A firm booking in the allocated booking class is possible, subject to seat availability.  Earning miles is not possible. Voucher validity cannot be extended.
	</p>

	<h3>5. Disqualification from contest</h3>
	<p>SWISS is entitled to exclude participants from the contest if there is justifiable evidence for doing so, e.g. infringement against the rules, influencing the contest or manipulation etc.  
	</p>

	<h3>6. Legal recourse</h3>
	<p>No correspondence shall be entered into with regard to the contest. No legal recourse is possible. No grounds exist for an actionable claim for delivery, payment of the prize in cash or exchange of the prize. 
	</p>

	<h3>7. Changes to rules and closure of the contest</h3>
	<p>SWISS reserves the right to change the conditions relating to the draw. Swiss International Air Lines further reserves the right to close or suspend the contest at any time. This applies in particular if reasons exist that would disrupt or prevent the contest from taking place as planned.
	</p>

	<h3>8. Liability limitations</h3>
	<p>Within the confines of the law, SWISS shall be exempt from any liability.</p>

	<h3>9. Safeguard clause</h3>
	<p>If certain terms of the conditions of participation prove to be ineffective or impracticable, this shall have no impact on the effectiveness of the contract in general.  Such terms shall be replaced by more effective and more practicable terms, whose effectiveness most closely meets the objectives.
	SWISS may alter these conditions of participation at any time. </p>
	
	<h3>10. Questions</h3>
	<p>If you have any questions about Fly to your Friends, you can either submit it to the <a href="http://www.facebook.com/topic.php?uid=16565655722&topic=17631" target="_blank">discussion forum on Facebook</a>
	<br />or contact SWISS directly via <a href="mailto:socialmedia@swiss.com">socialmedia@swiss.com</a></p>
	<p class="subtext">© 2011 Swiss International Air Lines</p>
	</div>
	
</div>
</div>
<div id="termsFoot"></div>
</div>


<div id="rulesBox">
	<div id="rulesHead"><h3></h3><a href="#" onclick="rulesClose()" id="rulesClose"></a></div>
	<div id="rules">
	<div class="rulesBox">
	<div id="rulesContent">
	<p>Fly around the world, collect points and miles and win great prizes.</p>
	<h3>This is how it works:</h3>
	<p>You have all your friends on Facebook. You know what they’re up to, 24/7. So, in a way, you can say you’re really close to them. But the truth is, no matter how close you and your friends are, you’re not geographically close to all of them.
	<br/>
	<br />
	So how cool would it be if you could go and visit them? For real and for free? Very cool, right? That’s what Swiss International Air Lines thought. And that’s how our  “Fly to your Friends”’ competition came to be.
	</p>

	<h3>Fasten your seatbelt:</h3>
	<p>To enter the competition you have to start the “Fly to your Friends” Facebook App. You will then see a map which shows all your friends.<br />
	
	<h3>Select a friend</h3>
	<p>Just select the friend you’d like to visit and board the plane. You have no friends abroad? No problem. Just Select any of the SWISS destinations. You start with 2000 miles.</p>

	<h3>Meet your friend at the airport</h3>
	<p>Before you board the plane, invite your friend to meet you at the airport you’re flying to. If your friend accepts your request, you will get bonus points.</p>

	<h3>Collect points and raise your level</h3>
	<p>The “Round the World Tickets” will be casted among all participants. There are also weekly Europe business tickets among the 10 best scores.
	<br />
	There are 10 different levels. You can reach a higher level with increasing points.
	<ol>
		<li>Tourist</li> 
		<li>Traveler</li>
		<li>Passenger</li> 
		<li>Economist</li> 
		<li>Business</li>
		<li>First Class</li>
		<li>Premium Member</li> 
		<li>VIP Guest</li>
		<li>Copilot</li>
		<li>Flightmaster</li>
	</ol>
	</p>

	<h3>Collecting points and miles</h3>
	<p>
	Win points for every flight!
	</p>
	<strong>You play and you are not a Fan of SWISS:</strong>
	<ul>
		<li>Short flight <500 miles = 3000 points</li>
		<li>Medium flight <1500 miles = 7000 points</li>
		<li>Long flight >1500 miles = 11000 points</li>
	</ul>
	
	<br />
	<strong>You are a Fan of SWISS:</strong>
	<ul>
		<li>Short flight <500 miles = 6000 points</li>
		<li>Medium flight <1500 miles = 12000 points</li>
		<li>Long flight >1500 miles = 18000 points</li>
	</ul>
	<p>
	Your friend will pick you up at the airport: 
	<br />
	If your friend welcomes you at the airport, it will double your points and bonus miles. 
	</p>

	<h3>Flying to different destinations and friends</h3>
	<p>
		<ul>
			<li>You can only fly five times to the same destination</li>
			<li>You can only fly once a week to the same friend</li>
		</ul>
	</p>

	<h3>Where can I fly to</h3>
	<p>You will be informed, if you don‘t have enough miles to reach a destination. Choose an other destination. You can always just choose a regular SWISS destination, if you don‘t have so many friends abroad. 
	</p>

	<h3>Further Questions</h3>
	<p>Don‘t hesitate to ask any question about the game in the Swiss International Air Lines Forum. Within a short notice you will get an answer form the SWISS Team.
	<a href="http://www.facebook.com/topic.php?uid=16565655722&topic=17631" target="_blank">discussion forum</a>
	<p class="subtext">© 2011 Swiss International Air Lines</p>
	</div>
	
</div>
</div>
<div id="rulesFoot"></div>
</div>


<script type="text/javascript">
function showTerms(){

	window.fbAsyncInit = function() {
		FB.Canvas.scrollTo(0,0);
	}

	//console.log(FB.Canvas.scrollTo(0,0));
	$('<div class="termsOverlay" />').css({opacity:0}).animate({opacity: 0.5}, 'normal', function(){
		$('#termsBox').fadeIn();
	}).appendTo('body');

	$('.termsOverlay').bind('click',function(){
		$('#termsBox').fadeOut();
		$(this).animate({opacity: 0}, 'slow', function(){
			$(this).remove();
		});
	});
}

function termsClose(){

	$('#termsBox').fadeOut();
	$('.termsOverlay').animate({opacity: 0}, 'normal', function(){
		$(this).remove();
	});
}

function showRules(){

	$('<div class="termsOverlay" />').css({opacity:0}).animate({opacity: 0.5}, 'normal', function(){
		$('#rulesBox').fadeIn();
	}).appendTo('body');

	$('.termsOverlay').bind('click',function(){
		$('#rukesBox').fadeOut();
		$(this).animate({opacity: 0}, 'slow', function(){
			$(this).remove();
		});
	});
}

function rulesClose(){

	$('#rulesBox').fadeOut();
	$('.termsOverlay').animate({opacity: 0}, 'normal', function(){
		$(this).remove();
	});
}
</script>