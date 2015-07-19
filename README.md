# E-Commerce

It's a simple e-commerce case of study built on top of Symfony 2.
It's using:
    - MySQL as default database
    - Redis as session storage
    - Behat to behavior tests
    - Composer to manage application dependencies

### Instalation

```sh
$ git clone [git-repo-url] ecommerce
$ cd ecommerce
$ composer install
$ php app/console doctrine:database:create
$ php app/console doctrine:schema:create
$ php app/console doctrine:fixtures:load
$ php app/console server:run

Now just access the url 127.0.0.1:8000 in your browser.

### Tests

```sh
$ ./bin/behat