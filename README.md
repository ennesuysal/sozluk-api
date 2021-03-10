## Requirements

- PHP, Laravel, Passport
- MySQL
- You must configure database information from .env file before run.

## Installation

	composer require laravel/passport

	php artisan migrate

	php artisan passport:install

	php artisan serve

if you get connection error, after configuration try this:
	
	php artisan config:cache


## Roles

- Admin => 2
- Moderator => 1
- Suser => 0 (roles store in susers table)

### What can Admin do?

- Everything :)

### What can Moderator do?

- Open topic
- Edit topic
- Delete topic
- Enter entry
- Edit own entry
- Delete any entry
- Delete suser's account

### What can Suser do?

- Open topic
- Enter entry
- Edit own entry
- Delete own entry


## Routes

- POST: /register => user registration (user role default: 0)
Params: email, nick, password
- POST: /login => user login
Params: nick, password

- GET: /entries => show all entries
- GET /entries/{id} => show entry
- POST /entries/store => post entry
Params: title_id, entry

- PUT: /entries/update/{id} => Update entry
Params: entry
- DELETE: /entries/destroy/{id} => delete entry

- GET: /titles => show all titles
- GET: /titles/{id}/entries' => show entries of title
- POST: /titles/store => post title
Params: title
- PUT: /titles/update/{id} => update title
Params: title
DELETE: /titles/destroy/{id} => delete title

- GET: /susers => show all users
- GET: /susers/{id} => show user
- GET: /susers/{id}/entries' => show entries of user
- POST: /susers/store => Register a user with a role
Params: email, nick, password, role
- DELETE => /susers/destroy/{id} => delete user