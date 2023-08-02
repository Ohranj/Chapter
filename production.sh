#! /bin/bash



echo "Changing read/write access"
read -t 2
chmod -R 775 storage/ bootstrap/

echo "Changing owner/group access"
read -t 2
chown -R www-data:alex .
chown -R www-data:www-data storage/ bootstrap/

echo "SCRIPT COMPLETE"