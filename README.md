# Atk9demo

Atk9Demo is a lesson-based demo application for [the Atk Framework](https://github.com/Sintattica/atk), illustrating the basic concepts of the ATK Framework through a series of lessons. It is an updated version of [atkdemo](https://github.com/atkphpframework/atkdemo/), written for ATK Framework v6.5.0.

WARNING : ATK framework suffer from several security flaws and shouldn't be used for the moment.

If you want to start a new atk project, start from [the atk skeleton](https://github.com/Sintattica/atk-skeleton).

Atk9Demo currently uses ATK Framework v9.

Atk9Demo is licensed under the terms of the GNU GPL v2.

# Run the demo

1. Create a database
2. Import install_mysql.sql or install_oracle.sql depending on your database system into your database
3. Fill the database parameters in config/parameters.prod.php
4. [Get composer](https://getcomposer.org/)
5. At this document root, run :
````
$ composer update
$ APP_ENV=prod php -S localhost:8000 -t web/
````
6. Visit [http://localhost:8000](http://localhost:8000) and enter credentials (administrator/administrator).
