<?php
$user = new BS_User( 'current' );
$model = $this->getModel();
?><h1><?php echo $this->getInfo( 'title' ); ?></h1>
<ul>
    <li><a href="<?php echo $model->getUrl( ); ?>">Home</a></li>
    <?php if ( $user->isLoggedIn() ) { ?>
    <li><a href="<?php echo $model->getUrl( 'account/dashboard' ); ?>"><?php echo $user->getEmail(); ?></a></li>
    <li><a href="<?php echo $model->getUrl( 'account/logout' ); ?>">Logout</a></li>
    <?php } else { ?>
    <li><a href="<?php echo $model->getUrl( 'account/login' ); ?>">Login</a></li>
    <li><a href="<?php echo $model->getUrl( 'account/register' ); ?>">Register</a></li>
    <?php } ?>
</ul>
