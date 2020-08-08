## Task: User Login Activity Graph
The main objective of this project is for you to demonstrate your technical skills and allowing us to assess your approach, thought process, methodology etc.

We are a global organisation and we have a lot of users across the globe. On a daily basis we would like to analyse how often and when are the peak times of our user login activity.

We want you to create a web application where we can generate a user login activity graph on a daily basis. This graph must allow us to compare user login activities from different regions.

We will not be actually logging in as our created users. We just need a lot of “user login activity” records. To help us simulate that, we want a script that can insert roughly 100,000+ rows of sample user data for testing.

## User Requirements
### User Login Activity Graph Page
User wants multiple input criteria they can select before generating the user login activity graph. For example:

Regions, we have systems for the following
* Cities:
   * Dublin (HQ)
   * Bratislava
   * Berlin
   * Paris
   * Hong Kong
   * Sydney
   * New York
* Date Time Range (from – to)
* Date Time Interval
    * Every 5 minutes
    * Every 10 minutes
    * Every 15 minutes
    * Every 30 minutes
    * Every hour

Since Dublin is our HQ, it must always be selected. User may select additional regions if they wish for comparison. User will always be generating this graph from Irish Standard Time.

User wants to see the number of logins on the y-axis on the left of the graph, where the bottom x-axis will output the date time range separated depending on the selected date time interval. Each selected region will be a data marker on the graph.

User wants to see the peak time outputted on the graph, subject to the selected date time interval. For example, if the Date Time Range is set to: 25-07-2020 to 30-07-2020 and the Date Time Interval is set to every 5 minutes, the peak time could be
“27-07-2020 08:45:00”, “28-07-2020 12:55:00”, or “30-07-2020 13:55:00”.

## Setup
This is a Laravel application. Place the files on your server and create a `.env` file in the root and set the database connection parameters. The `.env.example` in the codebase can be used as a basis.

To setup the database, run the migration script from the site root:

```php artisan migrate```

To insert sample location data, run the following seeding script:

```php artisan db:seed --class=locationsSeeder```

To insert sample login data, run the following seeding script:

``` php artisan db:seed --class=loginSeeder```


## Languages and libraries

This is a website, using HTML, CSS, JavaScript and PHP.

Libraries include:

* [Laravel](https://laravel.com/) v8 - PHP framework
* [Bulma](https://bulma.io) v0.9.0 - Styling of basic UI elements and grid layout
* [FontAwesome](http://fontawesome.io) v4.7.0 - Icons
* [Google Charts](https://developers.google.com/chart) - Line graph
* [Lightpicker](https://wakirin.github.io/Litepicker/) v1.5.7 - Date-range picker