<?php
$user = new BS_User( 'current' );
$model = $this->getModel();
echo $this->getModule( 'before-header' );
echo $this->getModule( 'header' );
echo $model->display_messages();
?>
<form action="" method="post">
    <ul>
        <li>
            <label>Email</label>
            <input type="email" name="email" required value="<?php echo $model->getFieldValue( 'email' ); ?>" />
        </li>
        <li>
            <label>Password</label>
            <input type="password" name="password" required value="<?php echo $model->getFieldValue( 'password' ); ?>" />
        </li>
        <li>
            <button type="submit">Login</button>
        </li>
    </ul>
</form>
<?php
echo $this->getModule( 'footer' );
