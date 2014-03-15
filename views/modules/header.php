<?php
$user = new BS_User( 'current' );
$model = $this->getModel();
?><h1><?php echo $this->getInfo( 'title' ); ?></h1>
<ul>
    <li><a href="<?php echo $model->getUrl( ); ?>"><?php echo _( 'Home' ); ?></a></li>
    <?php if ( $user->isLoggedIn() ) { ?>
    <li><img src="<?php echo $user->getAvatar(12); ?>" alt="" /> <a href="<?php echo $model->getUrl( 'account/dashboard' ); ?>"><?php echo $user->getName(); ?></a></li>
    <li><a href="<?php echo $model->getUrl( 'account/logout' ); ?>"><?php echo _( 'Logout' ); ?></a></li>
    <?php } else { ?>
    <li><a href="<?php echo $model->getUrl( 'account/login' ); ?>"><?php echo _( 'Login' ); ?></a></li>
    <li><a href="<?php echo $model->getUrl( 'account/register' ); ?>"><?php echo _( 'Register' ); ?></a></li>
    <?php } ?>
</ul>
