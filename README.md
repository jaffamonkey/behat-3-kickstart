[![Build Status](https://travis-ci.org/jaffamonkey/behat-3-kickstart.svg?branch=master)](https://travis-ci.org/jaffamonkey/behat-3-kickstart)

Key components:
==============
Behat 3
Mink Extension
PageObjects
WebAPIContext

SETUP
==============

From Behat repo root folder run following commands:-
* composer install (install composer first, of course :))
* npm install -g phantomjs (or brew install phantomjs)
* wget http://selenium-release.storage.googleapis.com/2.44/selenium-server-standalone-2.44.0.jar

RUNNING SELENIUM BROWSER TESTS
==============================

Before running behat to test the feature files in features directory, ensure the following commands are executed :-
* java -jar selenium-server-standalone-[version].jar

To run tests (open another terminal window):-
* bin/behat features

Second test runs using Guzzle (for API), the rest using Firefox

RUNNING PHANTOMJS TESTS
=======================

* phantomjs --webdriver=4444
* bin/behat -p phantomjs features

PERFORMANCE/PARALLEL TESTING
============================

* apt-get install parallel
* java -jar selenium-server-standalone-2.43.1.jar --role hub
* find features -iname '*.feature'|  parallel --gnu -j5 --group bin/behat --ansi {}

CROSS BROWSER
============

Using saucelabs service, you can run tests against most OS/browser combinations and mobile platforms too.

I added an example profile for IE8, as example.  To run it, first run sauceconnect config:-

* bin/sauce_config saucelabs_user_id saucelabs_api_key

Now try running the tests ....

* bin/behat -p saucelabs_ie8 features/

If you want to use saucelabs service against a localhost url, or any url behind a firewall, then follow these steps (assuming linux):

1. sudo wget https://saucelabs.com/downloads/sc-4.3.8-linux.tar.gz
2. sudo tar -xvf sc-4.3.8-linux.tar.gz
3. cd sc-4.3.8-linux
4. bin/sc -u saucelabs_user_id -k saucelabs_api_key


REPORTING
============

As well as a html style report, there is a graphical report-based version using Twig.  These are generated in the "reports" folder.  Below is example of the Twig report output.

<img src="http://jaffamonkey.com/wp-content/uploads/2015/05/Screen-Shot-2015-05-20-at-03.30.51.png" style="max-width:100%;">

