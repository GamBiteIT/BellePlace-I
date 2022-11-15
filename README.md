# Belle Place

## Installation

Clone the repo locally:

```sh
git clone https://github.com/GamBiteIT/BellePlace.git BellePlace
cd BellePlace
```

Install PHP dependencies:

```sh
composer install
```

Install NPM dependencies:

```sh
npm ci
```

Build assets:

```sh
npm run dev
```

Setup configuration:

```sh
cp .env.example .env
```

Generate application key:

```sh
php artisan key:generate
```

Create an SQLite database. You can also use another database (MySQL, Postgres), simply update your configuration accordingly.

```sh
touch database/database.sqlite
```

Run database migrations:

```sh
php artisan migrate
```


Run the dev server (the output will give the address):

```sh
php artisan serve
```

A Screen Shot for the .env file

![](https://raw.githubusercontent.com/GamBiteIT/BellePlace/main/env.png)
