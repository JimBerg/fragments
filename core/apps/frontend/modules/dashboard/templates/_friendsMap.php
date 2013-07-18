<div id="panel" class="closed">
	<div class="panelContent">
		<div id="panelFriendList">
			<div id="friendlist"></div>
		</div>
		<div id="friendlistPager"></div>	
		<div id="panelSelectedFriend">
			<hr />
			<div id="selectedFriendPic"></div>
			<div class="airportInfo">
				<div class="fixLeftCol"><h4><span class="small" id="lastName"></span></h4></div>
				<div class="fixRightCol"><h4><span class="marked big" id="firstName"></span></h4></div>
				<div class="clear"></div>
				<hr />
				<div class="fixLeftCol"><h4><span id="friendHome"></span></h4></div>
				<div class="fixRightCol"><h4><span class="marked small" id="friendAirportName"></span></h4></div>
				<div class="clear"></div>
			</div>
			<div class="distanceInfo">
				<div class="fixLeftCol"><h4><?php echo __('Distance in miles: '); ?></h4></div>
				<div class="fixRightCol"><h4><span class="marked big" id="friendDistance"></span></h4></div>
				<div class="clear"></div>
				<hr />
				<div class="fixLeftCol"><h4><?php echo __('Flying time: '); ?></h4></div>
				<div class="fixRightCol"><h4><span class="marked small" id="friendDuration"></span></h4></div>
				<div class="clear"></div>
			</div>			
			<div class="flightButtons"></div>
		</div>
		
		<div id="panelDestination">
			<h3 class="abstand_top"><?php echo __('No friends there? No Problem, SWISS flies you to over 70 destinations worldwide.');?></h3>
			<h3 class="abstand_btm"><?php echo __('So, to'); ?><span class="airportName"></span>.</h3>
			<hr />
			<div id="airportPic"></div>
			<div class="airportInfo">
				<div class="fixLeftCol"><h4><?php echo __('Your friendly Staff: '); ?></h4></div>
				<div class="fixRightCol"><h4><span class="marked big" id="destType"></span></h4></div>
				<div class="clear"></div>
				<hr />
				<div class="fixLeftCol"><h4><?php echo __('Airport: '); ?></h4></div>
				<div class="fixRightCol"><h4><span class="marked small airportName"></span></h4></div>
				<div class="clear"></div>
			</div>
			<div class="distanceInfo">
				<div class="fixLeftCol"><h4><?php echo __('Distance in miles: '); ?></h4></div>
				<div class="fixRightCol"><h4><span class="marked big" id="distance"></span></h4></div>
				<div class="clear"></div>
				<hr />
				<div class="fixLeftCol"><h4><?php echo __('Flight duration: '); ?></h4></div>
				<div class="fixRightCol"><h4><span class="marked small" id="duration"></span></h4></div>
				<div class="clear"></div>
			</div>			
			<div class="flightButtons"></div>
		</div>	
		
		<div id="panelHomebase">
			<h3 class="abstand_top"><?php echo __('Are you sure you want to fly back home?');?></h3>
			<h3 class="abstand_btm"><?php echo __('Your score will be reset to 2000 miles.'); ?></h3>
			<hr />
			<div id="homebasePic"></div>
			<div class="airportInfo">
				<div class="fixLeftCol"><h4><?php echo __('Homebase: '); ?></h4></div>
				<div class="fixRightCol"><h4><span class="marked big" id="homebaseName"></span></h4></div>
				<div class="clear"></div>
				<hr />
				<div class="fixLeftCol"><h4><?php echo __('Hometown: '); ?></h4></div>
				<div class="fixRightCol"><h4><span class="marked small airportName" id="hometownName"></span></h4></div>
				<div class="clear"></div>
			</div>
			<div class="distanceInfo">
				<div class="fixLeftCol"><h4><?php echo __('Distance in miles: '); ?></h4></div>
				<div class="fixRightCol"><h4><span class="marked big" id="distanceHb"></span></h4></div>
				<div class="clear"></div>
				<hr />
				<div class="fixLeftCol"><h4><?php echo __('Flight time: '); ?></h4></div>
				<div class="fixRightCol"><h4><span class="marked small" id="durationHb"></span></h4></div>
				<div class="clear"></div>
			</div>	
			<div class="flightButtons"></div>
		</div>	
	</div>
	<div class="panelButton">
		<a href="#" id="openFolder"></a>
	</div>
</div>
<div id="mapLegend2" class="closed">
	<span class="label"></span>
	<ul class="legend">
		<li id="legendHome"><?php echo __('Homebase'); ?></li>
		<li id="legendCurrent"><?php echo __('Current Position'); ?></li>
		<li id="legendSwiss"><?php echo __('Swiss Destination'); ?></li>
		<li id="legendSwissUnav"><?php echo __('Swiss Unavailable'); ?></li>
		<li id="legendOther"><?php echo __('Other Destination'); ?></li>
		<li id="legendOtherUnav"><?php echo __('Other Unavailable'); ?></li>
	</ul>
</div>
<div id="panToHomebase"></div>
<div id="mapCanvas"></div>

