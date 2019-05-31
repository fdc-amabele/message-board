<div class="container">
  <h1>New Message</h1>
  <div class="col-md-12">
    <?php echo $this->Form->create('Message');?>
    <div class="form-group form-inline nopadding">
      <div class="col-md-2 nopadding">
        <label for="to">To:</label>
      </div>
      <div class="col-md-10 nopadding">
        <?php echo $this->Form->input('to_id', array('label' => false, 'class' => 'select2')); ?>

<!-- <select class="select2" > -->
        </select>   
      </div> 
    </div>    
    <div class="form-group form-inline nopadding">
      <div class="col-md-2 nopadding">
        <label for="message">Message:</label>
      </div>
      <div class="col-md-10 nopadding">
        <?php echo $this->Form->input('content', array('label' => false, 'type' => 'textarea', 'class' => 'form-control')); ?>
      </div> 
    </div>
    <div class="col-md-4 text-center"> 
      <?php echo $this->Form->submit('Send', array('class' => 'btn btn-primary',  'title' => 'Send') );  ?>
    </div>
        
    <?php echo $this->Form->end(); ?>    

  </div>
</div>