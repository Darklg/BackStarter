<?php
$model = $this->getModel();
echo $this->getModule( 'before-header' );
?>
<h1>Hello install !</h1>
<?php echo $model->display_messages(); ?>
<form action="" autocomplete="off" method="post">
    <fieldset class="cssc-form">
        <div class="box"><label for="bs-name"><?php echo _( 'Site Name:' ); ?></label><input required name="bs-name" id="bs-name" type="text" value="<?php echo $model->getFieldValue( 'bs-name' ); ?>" /></div>
    </fieldset>
    <fieldset class="cssc-form">
        <div class="box"><label for="bs-adminemail"><?php echo _( 'Admin email:' ); ?></label><input required name="bs-adminemail" id="bs-adminemail" type="email" value="<?php echo $model->getFieldValue( 'bs-adminemail' ); ?>" /></div>
        <div class="box"><label for="bs-adminpass"><?php echo _( 'Pass:' ); ?></label><input required name="bs-adminpass" id="bs-adminpass" type="password" value="<?php echo $model->getFieldValue( 'bs-adminpass' ); ?>" /></div>
    </fieldset>
    <fieldset class="cssc-form">
        <div class="box"><label for="bs-dbhost"><?php echo _( 'Host:' ); ?></label><input required name="bs-dbhost" id="bs-dbhost" type="text" value="<?php echo $model->getFieldValue( 'bs-dbhost' ); ?>" /></div>
        <div class="box"><label for="bs-dbname"><?php echo _( 'Name:' ); ?></label><input required name="bs-dbname" id="bs-dbname" type="text" value="<?php echo $model->getFieldValue( 'bs-dbname' ); ?>" /></div>
        <div class="box"><label for="bs-dbuser"><?php echo _( 'User:' ); ?></label><input required name="bs-dbuser" id="bs-dbuser" type="text" value="<?php echo $model->getFieldValue( 'bs-dbuser' ); ?>" /></div>
        <div class="box"><label for="bs-dbpass"><?php echo _( 'Pass:' ); ?></label><input required name="bs-dbpass" id="bs-dbpass" type="text" value="<?php echo $model->getFieldValue( 'bs-dbpass' ); ?>" /></div>
        <div class="box"><label for="bs-dbprefix"><?php echo _( 'Prefix:' ); ?></label><input required name="bs-dbprefix" id="bs-dbprefix" type="text" value="<?php echo $model->getFieldValue( 'bs-dbprefix' ); ?>" /></div>
    </fieldset>
    <div>
        <button class="cssc-button" type="submit"><?php echo _( 'Submit' ); ?></button>
    </div>
</form>
<?php
echo $this->getModule( 'footer' );
