# Small Address Book PHP&SQLite project [Demo](https://book.srv43250.seohost.com.pl/)

Created for skill testing and educational purposes in pure PHP without any framework or external PHP library (except PHPUnit).

This small application allows you to manage the address book (create, update, display, delete) records.

For faster and more convenient development, used composer with psr-4 autoloading.

A project based on very basic MVC structure.

On front-end, used Bootstrap 5 and jQuery.

Provided docker-compose configuration for faster deployment.

Created unit and feature tests.

Input data validated and filtered.

## Technical requirements

Write a simple application (without using any framework)

> :heavy_check_mark: No PHP frameworks used

Using the SQLite database

> :heavy_check_mark: Used the SQLite database wrapped with PDO

Whose task will be to manage the address book

> :heavy_check_mark: With this application you can CRUD address book records

The address book record should contain: \
:heavy_check_mark: first name, 
:heavy_check_mark: last name,
:heavy_check_mark: telephone number, 
:heavy_check_mark: e-mail address, 
:heavy_check_mark: and a physical address field

Providing a runtime environment (e.g. based on Docker/Docker Compose) is welcome.
> :heavy_check_mark: Provided docker-compose configuration for faster deployment.

Remember about data validation and filtering.
> :heavy_check_mark: Input data validated and filtered. All SQL queries written with prepared statements.

## Installation & running using Docker compose

1) Clone this repository.

```sh
git clone https://github.com/alexcherniatin/address-book.git
```
2) Open project folder in terminal and run next commands:

3) Build docker compose

> with GNU Make tool

```sh
make dc_build
```
> or manually

```sh
docker-compose -f ./docker/docker-compose.yml build
```

4) Create and start containers

> with GNU Make tool

```sh
make dc_up
```
> or manually

```sh
docker-compose -f ./docker/docker-compose.yml up -d --remove-orphans
```

5) Open docker compose php-fpm bash

> with GNU Make tool

```sh
make app_bash
```
> or manually

```sh
docker-compose -f ./docker/docker-compose.yml exec -u www-data php-fpm bash
```

6) Migrate database from app bash

> with GNU Make tool

```sh
make migrate
```
> or manually

```sh
php database/migrate.php
```

7) If all went well you can reach the project in browser at

```sh
http://localhost:888/
```

## Testing

You can run all the tests in a directory using the PHPUnit binary

> with GNU Make tool

```sh
make test
```
> or manually

```sh
./vendor/bin/phpunit --verbose
```

## What can be improved

Add more validation to phone number field, add country selecting, validate number by country

Separate address field to country, city, street etc.

Add pagination

Add sorting by table field

Add search

Write more tests

Better ui/ux

Ability to change database from configs

Add separate database for testing