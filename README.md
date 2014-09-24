Project Structure
=================
trunk/sample_data - sample csv files
trunk/html - HTML layout
trunk/phpapp - PHP application


Project Frameworks and Libraries
=================
## Server: 
[Silex](http://silex.sensiolabs.org/) - microframework
[Humanity](https://github.com/humanityapp/php-sdk) - PHP SDK

## Client:
[AngularJS](https://angularjs.org/) - js framework
[DropzoneJS](http://www.dropzonejs.com/) - drag and drop support


Deploy Tutorial
=================
1. Set up web root to ```trunk/phpapp``` folder
2. Run ```php composer.phar install``` in ```trunk/phpapp``` folder
3. Make ```conf.php``` file in ```trunk/phpapp/config``` folder (just copy it from ```conf.php.sample```) and set there valid configs (client_id, etc.)
4. Config ```trunk/phpapp/config/validator.json``` file for proper column validation


Requirenments
=================
1. PHP >= 5.4


Notes
=================
1. For speed up loading page minimize all javascript and css files