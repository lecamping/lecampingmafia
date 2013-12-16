#!/bin/bash

php5='/Applications/MAMP/bin/php/php5.4.10/bin/php'

dir="src/LCM/CoreBundle/"
dst="src/LCM/AdminBundle/"

$php5 app/console generate:doctrine:entities LCMCoreBundle --no-backup

rm -fr src/LCM/CoreBundle/Entity/*.php~

for entity in `ls $dir/Entity/`
do
	entity=`echo $entity | sed "s:\.php::g"`
	rm -fr ${dir}Controller/${entity}Controller.php
	rm -fr ${dir}Resources/views/${entity}
	#rm -fr ${dst}Form/${entity}Type.php
	rm -fr ${dir}Tests/Controller/${entity}ControllerTest.php
	$php5 app/console doctrine:generate:crud --format=annotation --entity=LCMCoreBundle:${entity} --with-write -n 
done

$php5 app/console doctrine:schema:update --force

#php5 app/console cache:clear --env=dev
#php5 app/console cache:clear --env=prod



