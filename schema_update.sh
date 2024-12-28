#!/bin/bash
php bin/console doctrine:schema:update --dump-sql
echo -n "Proceed? Y/n ? "
read input
if [ "$input" == "Y" ];
then
    php bin/console doctrine:schema:update --force
    echo "Done"
else
    echo "Exit"
fi