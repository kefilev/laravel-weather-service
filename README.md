# Laravel Weather Service App

This is a simple weather service that lets users subscribe to the service and receive everyday weather reports. The app uses weatherstack.com to retrive weather data. 

## Subscribtion

To subscibe go to `http://localhost/api/subscribe?email=your@email.com&location=your_location_or_coordinates`

For example: `http://localhost/api/subscribe?email=your@email.com&location=sofia`

or with coordinates `http://localhost/api/subscribe?email=your@email.com&location=40.7831,-73.9712`

After you subscribe you should receive an email confirming your subscribtion and a link to unsubscribe.

To unsubscribe go to: `http://localhost/api/unsubscribe?email=your@email.com`

For more realistic scenario an encrypted key for each user may be included in the unsubscribe link.

## Tests

One additional test file (WeatherAPITest.php) is included in the tests/Feature directory. WeatherAPITest.php does HTTP tests for the API subscribe and unsubscribe endpoints using PHPUnit.

To run the tests execute `php artisan test` in the console

## Database structure

The app uses MySQL database with one additional table for the email subscribers that holds the email and location for each subscriber. It uses soft deletes for deactivation of subscription. When the user unsubscribe himself he gets hard deleted from the database. 

For more advanced app more DB tables can be used. If we need to enable users subscribe to multiple locations, then we will need one table for the subscriber emails, another table for the locations and one pivot table for the many-to-many relation between emails and locations. 

To run the migrations execute in the console:

`php artisan migrate`

## Sending the welcome emails to subscribers

To send the welcome emails to subscribers we use queue worker. To run the queue:

`php artisan queue:work`

## Sending the weather report emails

We use task scheduling to send the weather reports daily. For local development we can run the schedule for sending weather reports like this:

`php artisan schedule:work`

The schedule is defined in the routes/console.php file

