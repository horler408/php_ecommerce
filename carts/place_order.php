<?php
// you can do a lot more processing here but for now,
// we'll just empty the cart contents and redirect to a 'thank you' page
header('Location: empty_cart.php?redirect_to=thank_you');
die();
?>