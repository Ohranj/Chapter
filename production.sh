#! /bin/bash

echo "Changing read/write access"
read -t 2
chmod -R 775 storage/ bootstrap/

echo "Changing owner/group access"
read -t 2
chown -R www-data:alex storage/ bootstrap/

echo "Caching config and routes"
php artisan optimize

echo "SCRIPT COMPLETE"