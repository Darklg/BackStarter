<?php
$user = new BS_User( 'current' );
echo $this->getModule( 'before-header' );
echo $this->getModule( 'header' );
?>
<p>A lot of people in our industry haven't had very diverse experiences. So they don't have enough dots to connect, and they end up with very linear solutions without a broad perspective on the problem. The broader one's understanding of the human experience, the better design we will have.</p>
<?php
echo $this->getModule( 'footer' );
