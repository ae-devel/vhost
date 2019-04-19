#/bind/bash

FilePath='/var/www/vhost.rasp1.dev/data/db_shutdown_flag.txt'
if [ -f $FilePath ]
then
    sudo service mysql stop > /dev/null
    rm $FilePath
fi