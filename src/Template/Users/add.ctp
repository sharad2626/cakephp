<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">

      <?php echo $this->Form->create($user, ['type' => 'file']); ?>
    

    <fieldset>
        <legend><?= __('Add User') ?></legend>
        <?php
            echo $this->Form->input('firstname');
            echo $this->Form->input('lastname');
            echo $this->Form->input('email');
            echo $this->Form->input('username');
            echo $this->Form->input('password');
	    echo $this->Form->input('file', ['type' => 'file', 'class' => 'form-control']);

	?>
	
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
