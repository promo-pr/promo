Installation
------

Create a project:

~~~
composer global require "fxp/composer-asset-plugin:^1.2.0"
composer create-project --prefer-dist promo-pr/promo project
~~~

Fill your DB connection information in `environments/**/common-local.php` and init an environment:

~~~
php init
~~~

Execute migrations:

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