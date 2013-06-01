fluencytechtest
===============

Fluency Technical Test

This is code for the Fluency Technical Test.

This was coded using PHP CuRL and PHP Version 5.2.4 (This matches my current live working environment)

SETUP
-------

Edit the settings.php to:
      match your DB authentication and setup
      the site URL and the DIR that the project sits in

      Example:
        If the project is in C:\apache\htdocs\test\ then set the define('BASE_DIR', 'C:/apache/htdcos/test/') or
        if the project is in /var/www/test/fluency/ then set the define('BASE_DIR', '/var/www/test/fluency/');
        If the project is hosted on http://example.com/test/ then set the define('BASE_URL', 'http://example.com/test/');
  
Without these settings the code will just give an error.

I have included the sql structure in a file called fluency_test.sql. So just run that file against mysql to set 
that up. The file contains no data.

Any issues please contact me.
