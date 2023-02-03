# Docker setup
Docker configuration for Apache, PHP 7.4, MySQL 8 and phpmyadmin.

1. By: https://github.com/raj039/Docker-Apache-PHP7.4-MySQL8-phpmyadmin
2. Create **docker/sessions** folder
3. Create **docker/data/mysql** folder
4. Create **docker/logs/mysql** folder
6. Run: docker compose build
7. Run: docker compose up -d
8. Run: docker compose down

#### Link
1. Webserver: 0.0.0.0:8009
2. Phpmyadmin: 0.0.0.0:8010

#### Phpmyadmin credentials
1. Username: user
2. Password: password

# Action points
1. Execute **sql/php_task_1.sql** in phpMyAdmin

# Used libraries
1. *composer require vlucas/phpdotenv*
2. *composer require --dev phpunit/phpunit*
3. *composer require --dev squizlabs/php_codesniffer*
4. *composer require --dev phpstan/phpstan*
5. *composer require --dev mockery/mockery*
