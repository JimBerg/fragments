<div id="rankingPager">
	<?php 
		$numPagesWidth = ($pager->getLastPage())*31;
		if($pager->haveToPaginate()) { 
			if(!$pager->isFirstPage()) { 
				echo '<a class="firstPage" href="'.url_for("ranking", array("page" => $pager->getFirstPage(), 'week' => $week)).'"></a>'; 
				echo '<a class="prevPage" href="'.url_for("ranking", array("page" => $pager->getPreviousPage(), 'week' => $week)).'"></a>'; 
			} else{
				echo '<span class="firstPage"></span>'; 
				echo '<span class="prevPage"></span>'; 
			} ?>
			<div class="pages" style="width:<?php echo $numPagesWidth;?>px">
			<?php foreach ($pager->getLinks() as $page) { 
				$link = sprintf ("%02d", $page); 
				if($page == $pager->getPage()){
				 	echo '<a href="#" class="active">'.$link."</a>"; 
				} else{
					echo link_to($link, 'ranking', array('page' => $page, 'week' => $week));
				}
			} ?>
			</div> 
			<?php 
			if(!$pager->isLastPage()) { 
				echo '<a class="nextPage" href="'.url_for("ranking", array("page" => $pager->getNextPage(), 'week' => $week)).'"></a>'; 
				echo '<a class="lastPage" href="'.url_for("ranking", array("page" => $pager->getLastPage(), )).'"></a>'; 
			}
			else{
				echo '<span class="nextPage"></span>'; 
				echo '<span class="lastPage"></span>'; 
			}
		} 
	?>
</div>
