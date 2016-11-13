Installation
------

Create a project:

~~~
composer global require "fxp/composer-asset-plugin:^1.2.0"
composer create-project --prefer-dist promo-pr/cms project
~~~

or clone the repository for `pull` command availability:

~~~
git clone https://github.com/promo-pr/cms.git project
cd project
composer global require "fxp/composer-asset-plugin:~1.0.0"
composer install
~~~

Init an environment:

~~~
php init
~~~

Fill your DB connection information in `config/common-local.php` and execute migrations:

~~~
php yii migrate
~~~

Sign up on site or create your first user manually:

~~~
php yii user/users/create
~~~

Init RBAC roles:

~~~
php yii rbac/init
~~~

Assign `admin` role to your user:

~~~
php yii roles/assign
~~~

Gulp init

~~~
cd assets
npm install
gulp
~~~