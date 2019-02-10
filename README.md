# Atk9demo

Atk9Demo is a lesson-based demo application for [the Atk Framework](https://github.com/Sintattica/atk), illustrating the basic concepts of the ATK Framework through a series of lessons. See doc/INSTALL for instructions. It is an updated (and still incomplete) version of [atkdemo](https://github.com/atkphpframework/atkdemo/), written for ATK Framework v6.5.0

Atk9Demo currently uses ATK Framework v9.

Atk9Demo is licensed under the terms of the GNU GPL v2.

# Run the demo

1. Create a database
2. Import install_mysql.sql or install_oracle.sql depending on your database system into your database
3. Fill the database parameters in config/parameters.dev.php
4. [Get composer](https://getcomposer.org/)
5. At this document root, run :
````
$ composer update
$ APP_ENV=dev php -S localhost:8000 -t web/
````
