# Laravel email subscription service App for automatic weather reports

This is a simple weather subscription service built with Laravel 12 that lets users subscribe to the service trough API (using get requests) and receive everyday weather reports by email. The app uses weatherstack.com to retrieve weather data but can easily be configured to use any other service.

## Requirements

Web `server` like Apache, nginx or XAMPP with `PHP 8.2` and `MySQL`. Also install `composer` and `artisan` (if you install Laravel globally from the Laravel Installer this will include artisan for your system).

## Configuration

Run in console:

`composer install` to install the PHP dependencies in vendor folder

`npm install` to install the JS dependencies in node_modules folder

Configure your .env file.

```
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=....
MAIL_PASSWORD=....

#additional stuff
WEATHERSTACK_ADDRESS=https://api.weatherstack.com
WEATHERSTACK_API_KEY=....
```

`php artisan key:generate` to generate encryption key for Laravel

`php artisan migrate` to create the database

## Running the app

Make sure you have your server, php and mysql running (Latest XAMPP for example). Then make sure you see the Laravel 12 homepage on the browser by visiting `http://localhost`.

## Subscription

To subscribe go to: `/api/subscribe?email=your@email.com&location=your_location_or_coordinates`

For example: `/api/subscribe?email=your@email.com&location=sofia`

or with coordinates: `/api/subscribe?email=your@email.com&location=40.7831,-73.9712`

After you subscribe you should receive an email confirming your subscription and a link to unsubscribe.

To unsubscribe go to: `/api/unsubscribe?email=your@email.com`

For more realistic scenario an encrypted key for each user may be included in the unsubscribe link.

## Tests

One additional test file (WeatherAPITest.php) is included in the tests/Feature directory. WeatherAPITest.php does HTTP tests for the API subscribe and unsubscribe endpoints using PHPUnit.

To run the tests execute `php artisan test` in the console.

For tests to pass the `APP_URL` .env variable should point to `http://localhost`. If changing the .env or other configurations make sure to execute `php artisan config:clear` before running tests.

## Database structure

The app uses MySQL database with one additional table for the email subscribers that holds the email and location for each subscriber. It uses soft deletes for deactivation of subscription. When the user unsubscribe himself he gets hard deleted from the database. 

For more advanced app more DB tables can be used. If we need to enable users subscribe to multiple locations, then we will need one table for the subscriber emails, another table for the locations and one pivot table for the many-to-many relation between emails and locations. 

To run the migrations execute in the console:

`php artisan migrate`

## Sending the emails to subscribers

To send the email verification messages and weather reports to subscribers we use queue worker. To run the queue:

`php artisan queue:work`

## Sending the weather report emails

Only users that have verified their email address will receive weather reports.

We use task scheduling with a queue worker to send the weather reports daily. For local development we can run the schedule for sending weather reports like this:

`php artisan schedule:work`

Also make sure the queue is running:

`php artisan queue:work`

The schedule is defined in the routes/console.php file. To test if the emails are coming you can change `daily` function to `everyMinute`.

The logic for sending the weather report emails is here: `app\Console\Commands\SendWeatherReportEmails.php`

## Emails

In this app we use Mailables to send emails only. If you need to use different channels to send Weather Reports you can use Laravel Notifications.

Email design is done by blade and views are located in resources/views/email folder.

![Weather Report email](weather-report-email-screenshot.jpg)

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

