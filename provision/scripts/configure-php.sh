# Configure PHP
sed -i s/'display_errors = Off'/'display_errors = On'/ $PHP_INI_PATH
sed -i s/'html_errors = Off'/'html_errors = On'/ $PHP_INI_PATH
sed -i s/'upload_max_filesize = 2M'/'upload_max_filesize = 40M'/ $PHP_INI_PATH
sed -i s/'post_max_size = 8M'/'post_max_size = 50M'/ $PHP_INI_PATH
sed -i s,';date.timezone =','date.timezone = America/Bogota', $PHP_INI_PATH
