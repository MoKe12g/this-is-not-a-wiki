FROM mediawiki:1.37

COPY ./ /var/www/html/extensions/ThisIsNotAWiki
COPY NoWikiSettings.php /var/www/html/

COPY run /usr/local/bin/
CMD ["/usr/local/bin/run"]
