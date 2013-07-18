<div class="shadowTop"></div>
<div id="mapContainer">
	<div id="flightOverlay"></div>
	<div id="historyMap"></div>
	<div id="flightHistoryControls">
		<span id="controlsPrevFlight"><img src="../images/flighthistory/flight_back.png"></span>
		<span id="currentFlight">Flight No. <span id="currentFlightNumber">1</span></span>
		<span id="controlsNextFlight"><img src="../images/flighthistory/flight_next.png"></span>
	</div>

</div>
<?php 
if (!$onFlight)
	include_partial('dashboard/playerStatusBar', array('user' => $user, 'getStatus' => $getStatus, 'homebase' => $homebase, 'currentLocation' => $currentLocation)); 
else
	include_partial('dashboard/onFlightStatusBar', array('user' => $user, 'getStatus' => $getStatus, 'startLocation' => $startLocation, 'targetLocation' => $targetLocation, 'arrival' => $arrival, 'duration' => $duration, 'distance' => $distance));
?><?php include_partial('global/footer', array('user' => $user)); ?>
<script id="noHistoryTemplate" type="text/x-jquery-tmpl">
	<div class='noHistoryMessage'>
		You have no data for this week.
	</div>
</script>

<script id="tooltipTemplate" type="text/x-jquery-tmpl">
	<div class="flightTooltip flightTooltip${flightNum}">
		<div class="flightTooltipLeftBorder"></div>
		<div class="flightTooltipRightBorder"></div>
		<div class="flightTooltipContent">
			<div class="airportName"><span>${airportName}</span></div>
			<div class="airportCity"><span>${destinationName}</span></div>
			<div class="verticalDivider"></div>
			<div class="flightNumbers"><span class="tooltipLabel">Flight:</span>
				<div class="flightNumberContainer">
					{{each flightNumbers}}
						<span class="flightNumber">${$value}</span>
						<span class="horizontalDivider"></span>
					{{/each}}
					{{if flightNumbers.length < 1}}
						<span class="flightNumber">1</span>
						<span class="horizontalDivider"></span>
					{{/if}}
				</div>
			</div>
			<div class="verticalDivider"></div>
			{{if !homebase}}
			<div class="friends">
					<span class="tooltipLabel">Friends:</span>
					{{each friends}}
					<span class="friendContainer">
						{{if $value.fb_id!=0 }}
						<img class="friendPic" src="https://graph.facebook.com/${$value.fb_id}/picture" alt="${$value.friend_name}" />
						{{else}}
						<img class="friendPic" src="${PAGE_URL}images/flighthistory/swissIcon.png" alt="Swiss Staff" />
						{{/if}}
						{{if $value.friend_status == 'accepted'}}
							<img class="friend_flight_status_image" src="${PAGE_URL}images/flighthistory/status_confirmed.png" alt="Friend met you at the airport!" />
						{{else}}
							{{if $value.friend_status == 'denied'}}
							<img class="friend_flight_status_image" src="${PAGE_URL}images/flighthistory/status_denied.png" alt="Friend didn't meet you at the airport!" />
							{{else}}
								{{if $value.fb_id!=0 }}
									<img class="friend_flight_status_image" src="${PAGE_URL}images/flighthistory/status_unknown.png" alt="Friend status unknown." />
								{{/if}}
							{{/if}}
						{{/if}}
					</span>
					<span class="horizontalDivider"></span>
					{{/each}}
			</div>
			<div class="verticalDivider"></div>
			{{/if}}
			<div class="destinationInfo">
				{{if swissDestination}}
					<img class="swissDestinationImage"
						src="../images/flighthistory/swiss_destination.png" alt="Swiss Destination"/>
				{{/if}}
				{{if homebase}}
					<div class="homebaseDestinationLabel">This is your homebase.</div>
				{{/if}}
				{{if swissDestination}}
					<div class="swissDestinationLabel">This is a Swiss Destination.</div>
				{{/if}}
				
			</div>
		</div>
	</div>
</script>