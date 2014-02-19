<?php
$user = new BS_User( 'current' );
echo $this->getModule( 'header' );
?>
<h1>Hello World !</h1>
<?php
if ( $user->isLoggedIn() ) {
    echo '<p>Hello ' . $user->getEmail() . '</p>';
}
echo $this->getModule( 'footer' );
