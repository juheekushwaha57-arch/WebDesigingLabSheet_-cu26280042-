<?php

$extensions = [
    'mysqli',
    'pdo_mysql',
    'mbstring',
    'curl'
];

foreach ($extensions as $extension) {

    if (extension_loaded($extension)) {
        echo $extension . " is Enabled<br>";
    } else {
        echo $extension . " is Disabled<br>";
    }

}

?>
