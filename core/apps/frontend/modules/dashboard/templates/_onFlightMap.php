<div class="shadowTop flight"></div>
<?php if($isSwiss) {?>
<div id="flightpanel" class="closed">
	<div class="panelContent">
		<div id="weatherPanel">
			<div class="weather start">
				<div class="left">
					<?php //$start = explode(',',str_replace(' ',',',$startLocation->getLocationName())); 
					$start = explode(',',$startLocation->getLocationName());
					?>
					<div class="fixLeftCol"><h4><?php echo __('Weather at departure: '); ?></h4></div>
					<div class="fixRightCol"><h4><span class="marked big" id="startLocationWeather"><?php echo $start[0];?></span></h4></div>
					<div class="clear"></div>
					<hr />
					<div class="fixLeftCol"><h4><?php echo __('Conditions: '); ?></h4></div>
					<div class="fixRightCol"><h4><span id="weatherConditions" class="marked big start"></span></h4></div>
					<div class="clear"></div>
					<hr />
				</div>
				<div class="right">
					<div class="fixLeftCol"><h4><?php echo __('Temperature: '); ?></h4></div>
					<div class="fixRightCol"><h4><span id="weatherTemperature" class="marked big start"></span></h4></div>
					<div class="clear"></div>
					<hr />
					<div class="fixLeftCol"><h4><?php echo __('Humidity: '); ?></h4></div>
					<div class="fixRightCol"><h4><span id="weatherHumidity" class="marked big start"></span></h4></div>
					<div class="clear"></div>
				</div>
				<div id="weatherIcon" class="start"></div>
			</div>
			<!-- <hr /> -->
			<div class="weather target">
			<?php //$target = explode(',',str_replace(' ',',',$targetLocation->getLocationName())); 
				$target = explode(',',$targetLocation->getLocationName());	
			?>	
				<div class="fixLeftCol"><h4><?php echo __('Weather at destination: '); ?></h4></div>
				<div class="fixRightCol"><h4><span class="marked big" id="targetLocationWeather"><?php echo $target[0]; ?></span></h4></div>
				<div class="clear"></div>
				<hr />
				<div class="fixLeftCol"><h4><?php echo __('Conditions: '); ?></h4></div>
				<div class="fixRightCol"><h4><span id="weatherConditions" class="marked big target"></span></h4></div>
				<div class="clear"></div>
				<hr />
				<div class="right">
					<div class="fixLeftCol"><h4><?php echo __('Temperature: '); ?></h4></div>
					<div class="fixRightCol"><h4><span id="weatherTemperature" class="marked big target"></span></h4></div>
					<div class="clear"></div>
					<hr />
					<div class="fixLeftCol"><h4><?php echo __('Humidity: '); ?></h4></div>
					<div class="fixRightCol"><h4><span id="weatherHumidity" class="marked big target"></span></h4></div>
					<div class="clear"></div>
				</div>
				<div id="weatherIcon" class="target"></div>
			</div>
		</div>
	</div>
	
	<div id="infoPanel">
		<div class="visibleArea">
			<div class="infoPanelContent left closed">
				<div class="touristInfo left">
					<div class="fixLeftCol"><h4><?php echo __('Your Destination: '); ?></h4></div>
					<div class="fixRightCol"><h4><span class="marked big" id="destName"><?php echo substr($destination->getLocationName(), 0, 20); ?></span></h4></div>
					<div class="clear"></div>
					<hr />
					<div class="fixLeftCol"><h4><?php echo __('Coordinates: '); ?></h4></div>
					<div class="fixRightCol"><h4><span id="destCoordinates" class="marked small"><?php echo $destination->getGeolocation() ?></span></h4></div>
					<div class="clear"></div>
					<hr />
					<div class="fixLeftCol"><h4><?php echo __('Altitude above sea level: '); ?></h4></div>
					<div class="fixRightCol"><h4><span id="destSeaLevel" class="marked small"><?php echo $destination->getElevation() ?></span></h4></div>
					<div class="clear"></div>
					<hr />
					<div class="fixLeftCol"><h4><?php echo __('Area: '); ?></h4></div>
					<div class="fixRightCol"><h4><span id="destArea" class="marked small"><?php echo $destination->getArea() ?></span></h4></div>
					<div class="clear"></div>
					<hr />
					<div class="fixLeftCol"><h4><?php echo __('Population: '); ?></h4></div>
					<div class="fixRightCol"><h4><span class="marked small" id="destPopulation"><?php echo $destination->getPopulation() ?></span></h4></div>
					<div class="clear"></div>
					<hr />
					<div class="fixLeftCol"><h4><?php echo __('People per sq/mi: '); ?></h4></div>
					<div class="fixRightCol"><h4><span id="destDensity"  class="marked small"><?php echo $destination->getPopulationDensity() ?></span></h4></div>
					<div class="clear"></div>
					<hr />
					<div class="fixLeftCol"><h4><?php echo __('Timezone: '); ?></h4></div>
					<div class="fixRightCol"><h4><span id="timeZone"  class="marked small"><?php echo $destination->getTimeZone() ?></span></h4></div>
					<div class="clear"></div>
					
				</div>
				
				<div class="touristInfo list right">
					<?php if($destination->getInfotext() != ''){?> <h4 id="moreInfo"><span class="hidden"><?php echo __('More info: '); ?></span></h4>
					<?php } else { ?><h4 id="noInfo"><span class="hidden"><?php echo __('No further info: '); ?></span></h4><?php }?>
					<hr />
					<h4 id="morePictures"><span class="hidden"><?php echo __('Pictures: '); ?></span></h4>
					<hr />
					<h4 id="bookFlight"><a href="http://booking.swiss.com/web/itinerary.html" target="_blank" style="height:14px; width:60px; display:block;"><span class="hidden"><?php echo __('Book flight: '); ?></span></a></h4>
					<hr />
					<h4 class="subtitle"><?php echo __('Find more pictures on <a class="redArrow" href="http://www.panoramio.com/map/?tag='.$destination->getLocationName().'" target="_blank">www.panoramio.com</a>'); ?></h4>
				</div>
				
			</div>
			<div>
				<div id="infoText" class="touristInfo">
				<h4><span class="marked big destHeadline" style="float:none"><?php echo $destination->getLocationName() ?></span></h4>
				<h4 class="destHeadline"><?php echo nl2br($destination->getInfotext()); ?></h4>
				</div>
				<div id="infoPics" class="touristInfo pictures">
				<div class="borderOverlay"></div>
				<div id="infoPicsContent" style="width:<?php echo (sizeof($getPics)*575); ?>px">
	
				    <ul>
				    	<?php foreach ($getPics as $key => $pic){ ?>
				        	<li style="width:564px; height:260px; z-index:500; margin:0; display:block;">
				        		<span class="locationImage" style="background:url('<?php echo sfConfig::get('sf_upload_directory').'/'.$pic->getPath(); ?>'); height:250px; width:564px; display:block">
				        			<a class="ferkel" href="<?php echo $pic->getLink();?>" target="_blank"><?php echo $pic->getAuthor();?></a>
				        		</span>
				        	</li>
						<?php }?>
				    </ul>
	
				</div>
				<div id="buttonsContainer"></div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="flightpanelButtons">
		<a href="#" id="routeButton" class="active"></a>
		<a href="#" id="weatherButton"></a>
		<a href="#" id="infoButton"></a>
	</div>
</div>
<?php } else { ?>
<div id="flightpanel" class="closed">
	<div class="panelContent">
		<div id="weatherPanel">
			<div class="weather start">
			<?php $start = explode(',',$startLocation->getLocationName()); ?>
				<div class="fixLeftCol"><h4><?php echo __('Weather at departure: '); ?></h4></div>
				<div class="fixRightCol"><h4><span class="marked big" id="startLocationWeather"><?php echo $start[0] ?></span></h4></div>
				<div class="clear"></div>
				<hr />
				<div class="fixLeftCol"><h4><?php echo __('Conditions: '); ?></h4></div>
				<div class="fixRightCol"><h4><span id="weatherConditions" class="marked big start"></span></h4></div>
				<div class="clear"></div>
				<hr />
				<div class="right">
					<div class="fixLeftCol"><h4><?php echo __('Temperature: '); ?></h4></div>
					<div class="fixRightCol"><h4><span id="weatherTemperature" class="marked big start"></span></h4></div>
					<div class="clear"></div>
					<hr />
					<div class="fixLeftCol"><h4><?php echo __('Humidity: '); ?></h4></div>
					<div class="fixRightCol"><h4><span id="weatherHumidity" class="marked big start"></span></h4></div>
					<div class="clear"></div>
				</div>
				<div id="weatherIcon" class="start"></div>
			</div>
			<div class="weather target">
			<?php $target = explode(',',$targetLocation->getLocationName()); ?>	
				<div class="fixLeftCol"><h4><?php echo __('Weather at destination: '); ?></h4></div>
				<div class="fixRightCol"><h4><span class="marked big" id="targetLocationWeather"><?php echo $target[0]  ?></span></h4></div>
				<div class="clear"></div>
				<hr />
				<div class="fixLeftCol"><h4><?php echo __('Conditions: '); ?></h4></div>
				<div class="fixRightCol"><h4><span id="weatherConditions" class="marked big target"></span></h4></div>
				<div class="clear"></div>
				<hr />
				<div class="right">
					<div class="fixLeftCol"><h4><?php echo __('Temperature: '); ?></h4></div>
					<div class="fixRightCol"><h4><span id="weatherTemperature" class="marked big target"></span></h4></div>
					<div class="clear"></div>
					<hr />
					<div class="fixLeftCol"><h4><?php echo __('Humidity: '); ?></h4></div>
					<div class="fixRightCol"><h4><span id="weatherHumidity" class="marked big target"></span></h4></div>
					<div class="clear"></div>
				</div>
				<div id="weatherIcon" class="target"></div>
			</div>
		</div>
	</div> 	
	<div class="flightpanelButtons notswiss">
		<a href="#" id="routeButton"  class="active"></a>
		<a href="#" id="weatherButton"></a>
	</div>
</div>
<?php }?>

<div id="pathOverlay"></div>
<div id="onFlightMap"></div>
