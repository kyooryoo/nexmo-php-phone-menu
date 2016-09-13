# Basic Phone Menu using PHP and the Nexmo Voice API

This app uses the Nexmo Voice API to demonstrate an interactive order status phone menu.

* Callers can search for orders by order ID.
* If the caller's number is found, they can get the status of their latest order.

## Prerequisites

You will need:

* At least one Nexmo Virtual Number (Phone Number)
* `composer` or the [Nexmo CLI][cli] installed
* A public web server to host this web app, or [ngrok][ngrok] on your local development system.

## Installation

```sh
git clone https://github.com/nexmo/php-phone-menu.git
```

## Setup (Composer)

Use composer to install the dependencies (the [Nexmo PHP Client Library][php-lib])

```sh
cd ./php-phone-menu
composer install
```

Once installed, copy `config.php.dist` to `config.php`, and edit with your Nexmo credentials, as well as the public URL
Nexmo can use to access the application. If you're using [ngrok][ngrok] you'll need to know what subdomain will be used
to expose your application. 
 
Finally, run the setup script to provision a new application and virtual number:

```sh
php ./bin/setup.php
```

## Setup (Nexmo CLI)

Create the nexmo application, using the [Nexmo CLI][cli] and take note of the application universally unique identifier (UUID):

```sh
nexmo app:create demo-app --keyfile private.key http://example.com http://example.com
```

Rename the config file:

```sh
mv example.env .env
```

Fill in the values in `.env` as appropriate.

Buy numbers for calls that you would like to track. The following example buys the first available number in a given country by country code.

```sh
nexmo number:buy --country_code [YOUR_COUNTRY_CODE]
```

Link the virtual numbers to the app id with the Nexmo CLI:

```sh
nexmo link:app [NUMBER] [app-id]
```

Update the app to set the webhook urls to be your server (or [ngrok][ngrok] subdomain) instead of the example.com 
placeholders used at creation.

```sh
nexmo app:update ['app-id'] demo-app [your url]/answer [your url]/event
```

### Running the App

Using the PHP development server:

```sh
php -S 0:8080 ./public/index.php
```

To expose the application to the public internet:

```sh
ngrok http 8080
```

Or you can configure a webserver to serve the app using `/public` as the webroot.

### Using the App

Call the virtual number to check order status over the phone. Find the order ids in `config.php`. Update `config.php` 
with your phone number to have the application lookup a recent order based on your caller id.

[php-lib]: https://github.com/Nexmo/nexmo-php
[ngrok]: https://ngrok.com/
[cli]: https://github.com/Nexmo/nexmo-cli/