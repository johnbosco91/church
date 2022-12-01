<p align="center">
   <a href="https://www.vatican.va/" target="_blank">
      <img src="https://www.vatican.va/etc/designs/vatican/library/clientlibs/themes/homepage_popes/images/icona.png" 
         height="100px" alt="Church"/>
   </a>
    <h1 align="center">Church Management System</h1>
 <br/>

[Roman Catholic Church](https://www.vatican.va/) application for management of church activities and her Project

The software contains various application that helps carry out activity for Roman Catholic Church.

REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 8.1.

INSTALLATION
------------

### Install via Composer

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

You can then install this project template using the following command:
1. Create [MySQL](https://www.mysql.com/) database with name of your choice.
2. Update `config/db.php` as per your mysql database setting.
   ```php
   return [
       'class' => 'yii\db\Connection',
       'dsn' => 'mysql:host=localhost;dbname=yii2basic',
       'username' => 'root',
       'password' => '1234',
       'charset' => 'utf8',
   ];
   ```
3. Clone the project.
   ~~~
   git clone git@github.com:johnbosco91/church.git
   ~~~

4. Change directory to `church` folder.
   ~~~
   cd church
   ~~~

5. Update the project by running the following command.
   ~~~
   composer update
   ~~~
6. Run `./yii serve` and see the instruction to run project.


TESTING
-------

Tests are located in `tests` directory. They are developed with [Codeception PHP Testing Framework](http://codeception.com/).
By default, there are 3 test suites:

- `unit`
- `functional`
- `acceptance`

Tests can be executed by running

```
vendor/bin/codecept run
```

The command above will execute unit and functional tests. Unit tests are testing the system components, while functional
tests are for testing user interaction. Acceptance tests are disabled by default as they require additional setup since
they perform testing in real browser.


### Running  acceptance tests

To execute acceptance tests do the following:

1. Rename `tests/acceptance.suite.yml.example` to `tests/acceptance.suite.yml` to enable suite configuration

2. Replace `codeception/base` package in `composer.json` with `codeception/codeception` to install full-featured
   version of Codeception

3. Update dependencies with Composer

    ```
    composer update  
    ```

4. Download [Selenium Server](http://www.seleniumhq.org/download/) and launch it:

    ```
    java -jar ~/selenium-server-standalone-x.xx.x.jar
    ```

   In case of using Selenium Server 3.0 with Firefox browser since v48 or Google Chrome since v53 you must download [GeckoDriver](https://github.com/mozilla/geckodriver/releases) or [ChromeDriver](https://sites.google.com/a/chromium.org/chromedriver/downloads) and launch Selenium with it:

    ```
    # for Firefox
    java -jar -Dwebdriver.gecko.driver=~/geckodriver ~/selenium-server-standalone-3.xx.x.jar
    
    # for Google Chrome
    java -jar -Dwebdriver.chrome.driver=~/chromedriver ~/selenium-server-standalone-3.xx.x.jar
    ``` 

   As an alternative way you can use already configured Docker container with older versions of Selenium and Firefox:

    ```
    docker run --net=host selenium/standalone-firefox:2.53.0
    ```

5. (Optional) Create `yii2basic_test` database and update it by applying migrations if you have them.
   ```
   tests/bin/yii migrate
   ```
   The database configuration can be found at `config/test_db.php`


6. Start web server:

    ```
    tests/bin/yii serve
    ```

7. Now you can run all available tests

   ```
   # run all available tests
   vendor/bin/codecept run

   # run acceptance tests
   vendor/bin/codecept run acceptance

   # run only unit and functional tests
   vendor/bin/codecept run unit,functional
   ```

### Code coverage support

By default, code coverage is disabled in `codeception.yml` configuration file, you should uncomment needed rows to be able
to collect code coverage. You can run your tests and collect coverage with the following command:

```
#collect coverage for all tests
vendor/bin/codecept run --coverage --coverage-html --coverage-xml

#collect coverage only for unit tests
vendor/bin/codecept run unit --coverage --coverage-html --coverage-xml

#collect coverage for unit and functional tests
vendor/bin/codecept run functional,unit --coverage --coverage-html --coverage-xml
```

You can see code coverage output under the `tests/_output` directory.
