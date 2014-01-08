#!/bin/bash

php5='/Applications/MAMP/bin/php/php5.4.10/bin/php'

dir="src/LCM/AdminBundle/"

$php5 app/console generate:doctrine:entities LCMAdminBundle --no-backup

rm -fr src/LCM/AdminBundle/Entity/*.php~

for entity in `ls $dir/Entity/`
do
	entity=`echo $entity | sed "s:\.php::g"`
	rm -fr ${dir}Controller/${entity}Controller.php
	rm -fr ${dir}Resources/views/${entity}
	if [ "$entity" != "User" ] && [ "$entity" != "Startup" ]
	then
		rm -fr ${dir}Form/${entity}Type.php
	fi
	rm -fr ${dir}Tests/Controller/${entity}ControllerTest.php
	$php5 app/console doctrine:generate:crud --format=annotation --entity=LCMAdminBundle:${entity} --with-write -n
	if [ "$entity" == "User" ]
	then
		sed -i '' 's/{{ entity.roles }}/{% for role in entity.roles %}{{ role}} {% endfor %}/g' ${dir}Resources/views/${entity}/index.html.twig
		sed -i '' 's/{{ entity.roles }}/{% for role in entity.roles %}{{ role}} {% endfor %}/g' ${dir}Resources/views/${entity}/show.html.twig
	fi
done

$php5 app/console doctrine:schema:update --force

#php5 app/console cache:clear --env=dev
#php5 app/console cache:clear --env=prod



