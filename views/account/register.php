<?php
$user = new BS_User( 'current' );
$model = $this->getModel();
echo $this->getModule( 'before-header' );
echo $this->getModule( 'header' );
echo $model->display_messages();
?>
<form action="<?php echo $model->getUrl( 'account/register' ); ?>" method="post" autocomplete="off">
    <p><?php echo _( 'Create your account!' ); ?></p>
    <ul>
        <li>
            <label><?php echo _( 'Name' ); ?></label>
            <input type="text" name="name" required value="<?php echo $model->getFieldValue( 'name' ); ?>" />
        </li>
        <li>
            <label><?php echo _( 'Email' ); ?></label>
            <input type="email" name="email" required value="<?php echo $model->getFieldValue( 'email' ); ?>" />
        </li>
        <li>
            <label><?php echo _( 'Password' ); ?></label>
            <input type="password" name="password" required value="<?php echo $model->getFieldValue( 'password' ); ?>" />
        </li>
        <li>
            <button type="submit"><?php echo _( 'Login' ); ?></button>
        </li>
    </ul>
</form>
<?php
echo $this->getModule( 'footer' );
