# Nightguard

Set up Auth guards using Eloquent in seconds.

[![Unit Tests](https://github.com/lukeraymonddowning/nightguard/actions/workflows/main.yml/badge.svg)](https://github.com/lukeraymonddowning/nightguard/actions/workflows/main.yml)

## Introduction

Laravel guards provide a super convenient way of authorizing different areas
of your application based on the *type* of your user. For a lot of projects, 
gates and permissions suffice, but guards go one step further by allowing you
to use dedicated eloquent models for each area of authentication.

However, guards can be a little confusing to set up, especially if you're new
to it all. The documentation is thorough, but because of the low level nature of guards,
it can be overwhelming.

That's why Nightguard was created. Rather than you having to dig into config files and jump
from file to file, you can have a guard set up around your own custom Eloquent model
with **a single line of code**!

## Installation

You can install Nightguard via composer:

```bash
composer require lukeraymonddowning/nightguard
```

## Usage

Imagine we want an admin panel for our application. We want to have a dedicated
`administrators` table, and an `Administrator` Eloquent model. Only administrators
should be allowed into the admin panel. Even if a `User` model is logged in under the default guard, they should
not have access to any admin route.

Let's start by creating a model and migration for our administrators. Nightguard
provides a super convenient Artisan command that will create a model and migration
with all the columns you'll need for authentication:

```bash
php artisan nightguard:model Administrator
```

That was simple!

With that out of the way, all that's left is to set up the guard. Head in to your
`AuthServiceProvider`, and add the following code to your `boot` method:

```php
public function boot() 
{
    Nightguard::create(App\Models\Administrator::class);
}
```

...and voilà! You've successfully registered a gate that only an authenticated
`Administrator` can access.

If you create a route protected by your new 'administrator' gate, it will be protected:

```php
Route::get('example-url', fn() => 'Super secret!')->middleware('auth:administrator');
```

> The name of the guard is set automatically based on the class name of the model you pass to
> the `create` method. The guard name will always be singular and kebab-cased.

## Nightguard Facade

The `Nightguard` Facade includes the following methods:

### `create($model, $guard = null)`

This is how you register a new Eloquent guard. The first parameter should be the 
class name of your eloquent model (eg: `App\Models\Administrator::class`).

The second parameter is entirely optional and is only needed if you want to use a
custom guard name. When omitted, Nightguard will guess the guard name based on your
model name.

You should place these method calls in the `boot` method of one of your Service
Providers.

## Commands

Nightguard provides the following Artisan commands for you to use:

### `php artisan nightguard:model YourModelName`

This command allows you to quickly scaffold files for your
new Authenticatable Eloquent model. The database will have all the required
columns, and the model will extend the correct classes and have the desired
traits and casts out of the box.
