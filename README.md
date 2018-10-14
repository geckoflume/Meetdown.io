# Meetdown&#46;io
A simple Symfony project allowing its users to organize events using a common platform.

## Requirements

  * PHP 7.1.3 or higher;
  * PDO-SQLite PHP extension enabled;
  * and the [usual Symfony application requirements][1].


## Installation

```bash
$ git clone https://github.com/geckoflume/Meetdown.io.git
$ cd Meetdown.io/
$ composer install
```
### Database setup
Setup your database informations in the .env file (example:  `DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/meetdownio`).
Then execute these commands:
```bash
$ php bin/console cache:clear
$ php bin/console cache:warmup
$ php bin/console doctrine:database:drop --force #The db table will be wiped!
$ php bin/console doctrine:database:create
$ php bin/console doctrine:schema:update --force
```

## Usage

Then execute this command to run the built-in web server and access the application in your browser at <http://localhost:8000>:

```bash
$ php bin/console server:run 0.0.0.0:8000
```

[1]: https://symfony.com/doc/current/reference/requirements.html
