<?php
require_once('./class/class.database.php');
require_once('./class/class.ft.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="media/fluencytest.css"  />
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.0/jquery.min.js" type="text/javascript"></script>
        <script src="media/fluencytest.js" type="text/javascript"></script>
        <title>Fluency Tech Test</title>
    </head>
    <body>
        <div id="container">
            <header>
                <h1>Fluency Technical Test</h1>
            </header>
            <article>
                <form name="create_quote">
                    <label for="customer_name">Customer Name</label>
                    <input type="text" name="customer_name" id="customer_name" />
                    <label for="customer_name">Contract Length</label>
                    <select name="">
                        <option value="-1">Please Select&hellip;</option>
                        <?php
                        foreach(Fluency::contractLength() as $contract) {
                            echo "<option value='".$contract."'>".$contract." months</option>";
                        }
                        ?>
                    </select>
                    <label for="customer_name">Contract Length</label>
                    <input type="text" name="customer_name" id="customer_name" />
                </form>
            </article>
        </div>
    </body>
</html>

<?php


?>
