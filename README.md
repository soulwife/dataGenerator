DataGenerator
=============
##This tool able to:##
1. displays all tables and columns information for any database you want
2. generates random data for almost all MySQL types
3. inserts all this data to table, that you choose 

##Requirements:##
PHP >=5.4, enabled PDO, MySQL >= 5.0

###TODO:###
* use memcached for INFORMATION_SCHEMA data
* implement Blob type mapping and random images generating
* use 'TOTAL_ROWS' for MyISAM (and count for InnoDB)
* implement FormHtmlFormatter