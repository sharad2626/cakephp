<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?></li>
	<li><?= $this->Html->link(__('Change Password'), ['action' => 'changePassword/6/']) ?></li>
	<li><?php echo  $this->Html->link(__('Logout'), ['action' => 'logout']); 	
		$loggedin_user_arr = $this->request->session()->read('Auth');
		echo $loggedin_user_arr['User']['firstname']." ".$loggedin_user_arr['User']['lastname'];
		
		//echo "<pre>";
		//echo $loggedin_user_arr['User'][id];	

	?></li>
	<li><?php 			
	?></li>

    </ul>
</nav>

<div class="users index large-9 medium-8 columns content">
<?= $this->Form->create() ?>
<fieldset>
    <legend><?= __('Change password') ?></legend>
    <?= $this->Form->input('old_password',['type' => 'password' , 'label'=>'Old password'])?>
    <?= $this->Form->input('password1',['type'=>'password' ,'label'=>'Password']) ?>
    <?= $this->Form->input('password2',['type' => 'password' , 'label'=>'Repeat password'])?>
</fieldset>
<?= $this->Form->button(__('Save')) ?>
<?= $this->Form->end() ?>
</div>

