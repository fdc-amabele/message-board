<div class="container message-list">
 <?php echo $this->Html->link( "New Message",   array('action'=>'add'), array('class' => 'btn btn-sm btn-primary float-right') );  ?>
	<h1>Messages</h1>	
	<!-- Search form -->
	<div class="row col-md-6 float-right">
		<input class="form-control search" type="text" placeholder="Search" aria-label="Search">
	</div>
	<div class="clearfix"></div>
	<br>
	<ul class="items nopadding">
	</ul>
	<br>
	<?php if($messages): ?>
	<div class="text-center show-section d-none">
		<?php echo $this->Html->link( "Show More", array('action' => ''), array('class' => 'show-more'));  ?>
	</div>
	<?php endif; ?>
	<?php 
		unset($message); 
		
	?>	
	<input type="hidden" id="currpage" value="messagelist">
</div>
