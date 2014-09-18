cat <<HTACCESS > $DOCUMENT_ROOT/.htaccess
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
HTACCESS

chown $USER:$USER $DOCUMENT_ROOT/.htaccess
chmod 0644 $DOCUMENT_ROOT/.htaccess
