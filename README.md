DataGenerator
=============

Version: 1.0

##This tool able to:##
1. displays all tables and columns information for any database you want
2. generates random data for almost all MySQL types
3. inserts all this data to table, that you choose 
4. displays content(all rows) for any table 

##Requirements:##
PHP >=5.4, enabled PDO, MySQL >= 5.0

###TODO:###
* implement Blob type mapping with random images generating (now strings)
* use 'TOTAL_ROWS' for MyISAM (and count for InnoDB, as it is now for all types)
* implement FormHtmlFormatter
* implement config file
* use memcached for INFORMATION_SCHEMA data