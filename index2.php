<?php
require_once('settings.php');
require_once('class/class.database.php');
require_once('class/class.ft.php');

?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="media/fluencytest.css"  />
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.0/jquery.min.js" type="text/javascript"></script>
        <script src="media/jquery.cookie.js" type="text/javascript"></script>
        <script src="media/fluencytest.js" type="text/javascript"></script>
        <title>Fluency Tech Test</title>
    </head>
    <body>
        <div id="container">
            <header>
                <h1>Fluency Technical Test</h1>
            </header>
            <article>
                <h2>Your Quote List for <?php echo Fluency::getCookieSitename(); ?> at <?php echo Fluency::getCookiePostcode(); ?></h2>
                <p>Please find below your quote options for your chosen contract length of <?php echo Fluency::getCookieContractLength(); ?> months</p>
                <ul>
                <?php
                //var_dump(Fluency::getQuoteList());
                $prev_carrier = "";
                    foreach(Fluency::getQuoteList() as $key => $quote) {
                        echo "  <li>";
                        if ($quote['carrier'] != $prev_carrier) {
                            echo "  <h3>Carrier: ".$quote['carrier']."</h3>";
                        }
                        echo "      <div class='list'>
                                        <div class='bearer inline cell'>
                                            <span class='label'>Bearer:</span>
                                            <span class='value'>".$quote['bearer']."Mb</span>
                                        </div>
                                        <div class='bandwidth inline cell'>
                                            <span class='label'>Bandwidth:</span>
                                            <span class='value'>".$quote['bandwidth']."Mb</span>
                                        </div>
                                        <div class='wholesale-install inline cell'>
                                            <span class='label'>Wholesale Install Price:</span>
                                            <span class='value'>&pound;".number_format($quote['wholesale_price_install'], 2)."</span>
                                        </div>
                                        <div class='wholesale-rental inline cell'>
                                            <span class='label'>Wholesale Rental Price:</span>
                                            <span class='value'>&pound;".number_format($quote['wholesale_price_rental'], 2)."</span>
                                        </div>
                                        <div class='rrp-install inline cell'>
                                            <span class='label'>RRP Install Price:</span>
                                            <span class='value'>&pound;".number_format($quote['rrp_price_install'], 2)."</span>
                                        </div>
                                        <div class='rrp-rental inline cell'>
                                            <span class='label'>RRP Rental Price:</span>
                                            <span class='value'>&pound;".number_format($quote['rrp_price_rental'], 2)."</span>
                                        </div>
                                        <div class='remove inline cell'>
                                            <span class='label'>Delete Quote:</span>
                                            <span class='value'><input type='button' class='delete_quote' id='delete_".$quote['id']."' name='quote_".$quote['id']."' value='Delete' /></span>
                                        </div>
                                    </div>";
                        echo "  </li>";
                        $prev_carrier = $quote['carrier'];
                    }
                ?>
                </ul>
            </article>
        </div>
    </body>
</html>
