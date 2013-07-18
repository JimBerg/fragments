<div class="gameInfo">
	<div id="container">
		<div id="slider">
			
			<span id="slide1" class="slide">
			<h2></h2>
				<span class="image"></span>
				<p><?php echo nl2br("You have all your friends on Facebook. You know what they’re up to, 24/7. So, in a way, you can say you’re really close to them. But the truth is, no matter how close you and your friends are, you’re not geographically close to all of them.

				So how cool would it be if you could go and visit them? For real and for free? Very cool, right? That’s what Swiss International Air Lines thought.
				
				<span class='red'>And that’s how our «Fly To Your Friends» competition came to be.</span>");?>
				</p>
			</span>
			
			<span id="slide2" class="slide">
			<p>
			<ul class="left">
				<li id="first">
				To enter the competition you have to start the «Fly To Your Friend» Facebook App. After you‘ve started the application you‘ll see a map which shows all your friends. 
				</li>
				<li id="second">
				Just select the friend you'd like to visit. You will then be informed of the closest airport that SWISS serves.
				</li>
			</ul>
			<span class="image"></span>
			<ul class="right">
				<li id="third">
				Before you board the plane, invite your friend to meet you at the airport you’re flying to.
				</li>
				<li id="fourth">
				The «Round-the-world ticket» goes to the participant who collects and earns the most points. But there are also weekly prizes for best scores.
				</li>
			</ul>
			<span class='red'>The more support you get from your friends, the more points and bonus miles you can win.</span>
			</p>
			</span>
			
			<span id="slide3" class="slide">
			<p>
			<h3 class="mainPrices"><?php echo __('')?></h3>
			<ul class="pricelist">
				<li><span class="num item1">1.</span><?php echo __('1x "Round the world" ticket')?></li>
				<li><span class="num item2">2.-10.</span><?php echo __('Surprise award')?></li>
			</ul>
			<h3 class="weeklyPrices"><?php echo __('')?></h3>
			<ul class="pricelist week">
				<li><span class="num item1">1.</span><?php echo __('1x2 long-haul flights')?></li>
				<li><span class="num item2">2. & 3.</span><?php echo __('1 European flight')?></li>
				<li><span class="num item2">&nbsp;</span><span class="textBlock"><?php echo __('(outside of Switzerland: flight to Switzerland)')?></span><li>
			</ul>
			<span class="text">
			So get ready to say goodbye to cyberhugs and hello to some real human contact. 
			Get in touch with your friends, plan your trip and  fly around the world, collect miles and win cool prizes. Happy landing!</span>
			<span class="image"></span>
			</p>
			</span>
		</div>
	</div>
	<div id="infoPager">
		<a href="#" id="page1" onclick="toPage(1)" class="active">1</a>
		<a href="#" id="page2" onclick="toPage(2)">2</a>
		<a href="#" id="page3" onclick="toPage(3)">3</a>
	</div>
</div>	
<?php include_partial('dashboard/playerStatusBar', array('user' => $user, 'getStatus' => $getStatus, 'homebase' => $homebase, 'currentLocation' => $currentLocation)); ?>
<?php include_partial('global/footer', array('user' => $user)); ?>		

<script type="text/javascript">
	function toPage(page){
		
		var move = (-1)*(page-1)*702; 
		var slider = document.getElementById('slider');

		$(slider).animate({
			marginLeft: move+'px'
			}, 500, function(){
				$('#page'+page).addClass('active');
				$('a:not(#page'+page+')').removeClass('active');
		});
	}
</script>