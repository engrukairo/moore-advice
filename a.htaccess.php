RewriteEngine On 

RewriteCond %{HTTPS} !on 
RewriteCond %{REQUEST_URI} !^/[0-9]+\..+\.cpaneldcv$ 
RewriteCond %{REQUEST_URI} !^/\.well-known/pki-validation/[A-F0-9]{32}\.txt(?:\ Comodo\ DCV)?$ 
RewriteRule (.*) https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

Options All -Indexes
RewriteEngine on

RewriteRule ^home?$ index.php
RewriteRule ^new-task new.php
RewriteRule ^login login.php
RewriteRule ^reset-pass passreset.php
RewriteRule ^logout logout.php
RewriteRule ^signup signup.php
RewriteRule ^search search.php
RewriteRule ^ongoing-tasks ongoing.php
RewriteRule ^all-tasks viewall.php
RewriteRule ^all-my-tasks viewallmytasks.php
RewriteRule ^task/([0-9a-zA-Z-.]+) viewtask.php?task=$1
RewriteRule ^mytask/([0-9a-zA-Z-.]+) viewmytask.php?task=$1
RewriteRule ^edit/([0-9a-zA-Z-.]+) edittask.php?task=$1
RewriteRule ^myedit/([0-9a-zA-Z-.]+) editmytask.php?task=$1

## php -- BEGIN cPanel-generated handler, do not edit
## Set the “ea-php73” package as the default “PHP” programming language.
#<IfModule mime_module>
#  AddHandler application/x-httpd-ea-php73 .php .php7 .phtml
#</IfModule>
# php -- END cPanel-generated handler, do not edit

<Files .htaccess>
order allow,deny
deny from all
</Files>