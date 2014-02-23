<?php
$m = $this->getModel();
echo $this->getModule( 'before-header' );
echo $this->getModule( 'header' );
echo $m->getWelcome();
?>
<p><?php echo _( 'Dashboard' ); ?></p>
<?php
echo $this->getModule( 'footer' );
