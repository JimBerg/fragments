<div class="contentBox friendInvite">
	<div class="headHome"><h3 id="homeHeadline" ><?php echo __('')?></h3></div>
	<div class="infoTopShadow"></div>
	<div class="friendImage"></div>
</div>

<div id="box_00" style="z-index:19" class="friendInviteBox noInvite">
	<div class="friendInviteText">
		<h3>Hey, thanks....</h3>
		<div class="friendInvite imageCol">
			<img src="https://graph.facebook.com/<?php echo $request_data[0]['to']['id']; ?>/picture/" />
		</div>
		<p class="friendInvite text">
		You've read all your messages.
		</p>
		<h4 id="friendInvite friendName">Have you played yet?</h4>
		<p class="friendInvite text">
		Enter the competition, fly around the world, visit your friends, collect miles and win great prizes! Take your seat!</p>
	</div>
	<!--  Box 0: willst du auch mit spielen
	<a href="#">zum Spiel</a>-->
	
</div>

<?php $requestCount = sizeof($request_data); ?>
<?php for($i=0; $i<$requestCount; $i++){ ?>
	<div id="box_<?php echo $i ?>" style="z-index:<?php echo 20+$i ?>" class="friendInviteBox">
		<div class="friendInviteText">
		<?php 
			//print_r($request_data);
			$fbId = $request_data[$i]['from']['id'];
			$name = split(' ',$request_data[$i]['from']['name']);
			$time = split('T',$request_data[$i]['created_time']);
		?>
		
		<h3>Your friend <?php echo $name[0] ?>...</h3>
		<div class="friendInvite messages">Message: <span class="messageCount"><?php echo $i+1; ?>/<?php echo $requestCount; ?></span><?php echo $time[0]?></div>
		<div class="friendInvite imageCol">
			<img src="https://graph.facebook.com/<?php echo $fbId ?>/picture/" />
		</div>
		<p class="friendInvite text">
		..has entered the SWISS "Fly to your Friends" competition, where you can win a real trip to meet and hang out with one of your Facebook buddies.
		</p>
		<h4 id="friendInvite friendName"><?php echo $name[0] ?> needs your help to get started.</h4>
		<p class="friendInvite text">
		You can help <?php echo $name[0] ?> getting closer to reach his goal, by answering this question: Wouldn’t it be cool if <?php echo $name[0] ?> came to see you and you could be at the airport to pick him up?
		</p>
		
		</div>
	</div>
			<!-- auch ausblenden!!!! -->
	<div  id="btn_<?php echo $i ?>"  class="buttons friendInvite">
		<a href="#" id="friendInviteDeny" onclick="denyFlight(<?php echo $request_data[$i]['from']['id'] ?>, <?php echo $i ?>, <?php echo $request_data[$i]['id']?> )"></a>
		<a href="#" id="friendInviteAccept" onclick="acceptFlight(<?php echo $request_data[$i]['from']['id'] ?>, <?php echo $i ?>, <?php echo $request_data[$i]['id']?> )"></a>
	</div>
<?php }?>
<div class="info_bottom friend">
<div id="startButton" <?php  if ($requestCount != 0)  { echo 'style="display:none;"';} ?> >
	<a href="#" class="button start" onclick="toMap()"><span class="button_right"><span id="goToApp" class="button_label start"><?php echo __('')?></span></span></a>
</div>

<script type="text/javascript">
function toMap(){
	document.location.href= PAGE_URL+'dashboard';
}
</script>
</div>	
