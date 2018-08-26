# Basic Interactive Voice Response (IVR) Phone Menu
## Based on PHP and the Nexmo Voice API

* This app enables users to check order status through an interactive phone menu.
* Users can search orders by order ID or get their order status by their numbers.

## Prerequisites
* One Nexmo Virtual Number
* Install PHP [composer](http://getcomposer.org/)
* Install and setup [Nexmo CLI][cli]
* Setup [ngrok][ngrok] on local machine

## Step by Step Guide
1. Clone source code repo and prepare PHP code:
```sh
git clone https://github.com/nexmo/php-phone-menu.git
cd php-phone-menu
composer install
```
2. Publish local port 8080 to the Internet:
```sh
./ngrok http 8080
```
3. Note down the ngrok public URL `ngrok_url`, copy `config.php.dist` to
`config.php`, and add `ngrok_url` into it.  
4. Setup Nexmo voice application and note down the app ID `nexmo_app`:
```sh
nexmo app:create phone-menu [ngrok_url]/answer [ngrok_url]/event
```
4. Buy a US Nexmo virtual number `nexmo_lvn` to provide the IVR service.
```sh
nexmo number:buy --country_code US --confirm
```
5. Link the virtual number to the voice application:
```sh
nexmo link:app [nexmo_lvn] [nexmo_app]
```

## Run the application
1. Start the local PHP development server:
```sh
php -S 0:8080 ./public/index.php
```
2. Call the Nexmo virtual number `nexmo_lvn` to check order status.
3. System will reply a message about a dummy order, number generated from DTMF,
with status in random between `shipped`, `backordered`, and `pending`, and with
date in random between the date of `yesterday`, `today` and `last week`.

## Notice
1. DTMF is not always correctly caught by the system.
2. Update `ngrok_url` for `config.php` and the voice app if reload ngrok.

[php-lib]: https://github.com/Nexmo/nexmo-php
[ngrok]: https://ngrok.com/
[cli]: https://github.com/Nexmo/nexmo-cli/
