Twathletic
==========

Provides a web front-end for registering a Twitter account to post monthly workout statistics.


How to use
----------

This is built as a web front-end for users to add an app to their Twitter account which will post monthly athletic activity summaries, similar to what is seen on [DailyMile](http://www.dailymile.com/) on a weekly basis. Users will simply go through the OAuth procedure to authorize the app to post to their Twitter accounts, and will provide any credentials necessary to access the sites containing workout information.

### Supported Sites

 - Garmin Connect (username / password)

### Supported Activities

 - Running

### Roadmap

 - Add **Strava**, **MapMyRun** to supported sites
 - Add **Cycling** to supported activities
 - Customizable tweet format
 - SSL/TLS encryption for protecting usernames and passwords in-transit

Dependencies
------------

 1. PHP / MySQL
 2. [twitteroauth](https://github.com/abraham/twitteroauth)
 3. [Smarty](http://www.smarty.net/)
 4. Python
 5. mechanize