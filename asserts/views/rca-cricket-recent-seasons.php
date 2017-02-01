<div class="rca-container rca-margin">
	<div class="rca-row">
		<div class="rca-column-12">
		  	<div class="rca-menu-scroll rca-left-border">
		    	<ul class="rca-season-list">
		    		<?php foreach($recentSeasons as $season): ?>
		      			<li>
		      				<a style="box-shadow: none;" href="<?php echo $season['key']; ?>"><?php  echo $season['short_name']; ?></a>
		      			</li>
		      		<?php endforeach; ?>
		    	</ul>
		  	</div>
		</div>
    </div>
</div>