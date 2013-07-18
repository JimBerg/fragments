<div id="panelBoarding">
	<div class="panelContent">
		<div id="panelImage">
		</div>

		<div id="panelText">
			<div class="boardingMessages" id="notifyResponse">
			
			<h3><?php echo __('Collect Bonus Points');?></h3>
				<p>
				<strong>Hi <span class="firstNameArial"></span>, I'm coming to meet you!<br /><br /></strong>
				Tell <span class="firstNameArial"></span> that you're coming. <br />If your friend is thrilled about the idea, your points will be doubled!
				</p>
				<a href="#" id="notifyFriend" class="button_left grey"><span class="button_right grey"><span class="buttonLabel grey"><?php echo __('say hi')?></span></span></a>	
			</div>
		</div>
		
		<div id="panelSelectedFriend"  class="boarding">
			<hr/>
			<div id="selectedFriendPic"></div>
			<div class="airportInfo">
				<h4><span class="small" id="lastName"></span><span class="marked big firstName"></span></h4>
				<hr />
				<h4><span id="friendHome"></span><span class="marked small" id="friendAirportName"></span></h4>
			</div>
			<div class="distanceInfo">
				<h4><?php echo __('Distance in miles: '); ?><span class="marked big" id="friendDistance"></span></h4>
				<hr />
				<h4><?php echo __('Flight Duration: '); ?><span class="marked small" id="friendDuration"></span></h4>
			</div>
			<div class="flightButtons"></div>
		</div>	
	</div>
</div>