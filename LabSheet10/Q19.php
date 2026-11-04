<?php
// Virtual Host setup guideline for httpd-vhosts.conf:
/*
<VirtualHost *:80>
    ServerName myproject.local
    DocumentRoot "C:/xampp/htdocs/your-project/public"
    <Directory "C:/xampp/htdocs/your-project/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
*/
echo "Virtual host mapping entry for system hosts file: 127.0.0.1 myproject.local";
?>
