# Charlie

## Introduction

The application here covers all aspects of the given spec. Assumptions are listed further on in this document. The
application does not use any Laravel starter kits, but does lean heavily on Laravel's built-in features.

I have chosen to focus on the backend Laravel application, so have created a simple blade + tailwind frontend. I can of
course add a more complex JavaScript-based frontend if required.

## Architecture

The application is built using Laravel 8.4. The frontend is built using Tailwind CSS and Blade. The application takes the
slim controller approach, keeping domain logic out of the controllers. This means that the controllers are very simple and 
we don't suffer from bloated controllers. This domain code lives in `App/Domain/` and can be reused in other applications 
(e.g. queues, console commands, etc).

## Assumptions & Clarifications

1. Env file is committed here for ease of setup. But for a real production application it should definitely not be committed.
2. In production The email sending and other long-running backend processes should run in queue workers.
3. Depending on the scale of data the app is required to handle, export and import functionality should also run via queue workers.
4. Also depending on the scale of data using a tool more suited to search and analytics of data (e.g. Elasticsearch for search, and OLAP database for analytics) is recommended.
5. For the customer slug-based URL requirement. The slug of the name is included in the URL, but I've also included a hash of the customer's id. This is to mitigate two customers having the same name.
6. For the users only seeing and being able to manage their own customer data. This is achieved in two ways. The first is by using the `OwnedByAuthenticatedUser` eloquent scope on the `Customer` model to ensure that a user_id where clause is always added to customer queries. The second is by using a CustomerPolicy which is configured via the routes and route model binding.
7. For the customer filtering and searching requirement. This is achieved using the `Filterable` eloquent trait. 
8. For the customer auditing requirement. This is achieved using the `Auditable` eloquent trait. 
9. The blade forms have CSRF protection enabled. 
10. Environment is setup using docker-compose. I wrote the docker configuration myself rather than using Laravel Sail or other pre-built solutions as I thought this was a better showcase of my knowledge.

## Improvements to be made

1. Better phone number input and validation (using libPhoneNumber)
2. Demonstrate more advanced frontend technology

## Installation

This app requires:

- PHP 8.4
- MySQL 8.0
- Node v22
- Composer v2
- Docker v28

Once you have all of the above installed, run the following commands:

```
composer install
npm install
npm run build
docker compose up -d
# wait a few seconds for mysql to start
docker compose exec app php artisan migrate
docker compose exec app php artisan db:seed
```

## Usage

The database seeder adds multiple users and associated customers. You should be able to login with:

```
http://localhost:8098/
Username: test@example.com
Password: password
```

When registering a user, the mailpit driver is used for email sending. The web UI for this can be found at 
http://localhost:8025/ once the docker containers are running.

## Linter

Laravel Pint is used for linting. To run the linter, run the following command from the project root:

```
./vendor/bin/pint
```

## Tests

### Running tests
Tests can be run from within the docker container with the following command:

```
docker compose exec app php artisan test
```

### Testing approach

Laravel works really well with feature tests because so much of the framework (routing, middleware, eloquent models, 
validation, authentication, events) is tightly coupled. Trying to test these pieces in isolation with unit tests usually 
means a lot of mocking and stubbing, which can get messy. 

The usual approach I take to testing Laravel applications is to lean heavily on feature tests that let you run real 
requests and see how everything actually behaves together, giving you confidence that the app works as expected.
