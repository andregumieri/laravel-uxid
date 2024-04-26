env:
	composer install

dev_env:
	rm -rf dev-app
	composer create-project laravel/laravel dev-app
	cd dev-app && composer config repositories.laravel-uxid path "../"
	cd dev-app && composer require "andregumieri/laravel-uxid @dev"