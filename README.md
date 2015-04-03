Key components:
==============
Behat 3
Mink Extension
PageObjects
WebAPIContext

==============
RUNNING BEHAT TESTS

From Behat repo root run:-
* php composer.phar install
* npm install -g phantomjs
* wget http://selenium-release.storage.googleapis.com/2.44/selenium-server-standalone-2.44.0.jar

Before running behat to test the feature files in features directory, ensure the following commands are executed :-
* java -jar selenium-server-standalone-[version].jar

To run tests (open another terminal window):-
* bin/behat features

First scenario will run in Goutte, second using Guzzle (for API), the rest using Firefox

If you run tests like this, it will run the first and last test (both tagged "@phantomjs") in phantomJS:-
* bin/behat -p phantomjs --tags '@phantomjs' features


PERFORMANCE TEST
----------------

Run Tests In Parallel (from Behat root folder)
----------------------------------------------

* apt-get install parallel
* java -jar selenium-server-standalone-2.43.1.jar --role hub
* find features -iname '*.feature'|  parallel --gnu -j5 --group bin/behat --ansi {}


CROSS BROWSER
-------------

Using saucelabs service, you can run tests against most OS/browser combinations and mobile platforms too.

I added an example profile for IE8, as example.  To run it:-

* bin/behat -p saucelabs features/
