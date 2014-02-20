<?php
$user = new BS_User( 'current' );
$model = $this->getModel();
?><h1><?php echo $this->getInfo( 'title' ); ?></h1>
<ul>
    <?php if ( $user->isLoggedIn() ) { ?>
    <li><a href="#">My account</a></li>
    <li><a href="<?php echo $model->getUrl( 'logout' ); ?>">Logout</a></li>
    <?php } else { ?>
    <li><a href="<?php echo $model->getUrl( 'login' ); ?>">Login</a></li>
    <?php } ?>
</ul>
