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
                <div id="quote_form">
                    <form name="create_quote" action="" method="post">
                        <label for="customer_name">Customer Name</label>
                        <input type="text" name="customer_name" id="customer_name" />
                        <label for="contract_length">Contract Length</label>
                        <select name="contract_length" id="contract_length">
                            <option value="-1">Please Select&hellip;</option>
                            <?php
                            foreach(Fluency::contractLength() as $contract) {
                                echo "<option value='".$contract."'>".$contract." months</option>";
                            }
                            ?>
                        </select>
                        <label for="site_name">Customer Site Name</label>
                        <input type="text" name="site_name" id="site_name" />
                        <label for="postcode">Customer Site Postcode</label>
                        <input type="text" name="postcode" id="postcode" />
                        <input type="submit" name="get_quote" id="get_quote" value="Get Quote" />
                    </form>
                </div>
            </article>
            <article>
                <div id="results_set">
                    
                </div>
            </article>
        </div>
    </body>
</html>
