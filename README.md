food-diary
==========

This application integrates an authentication with Github. You first need
 to create an OAuth application on the Github website : https://github.com/settings/applications/new.
 
 ![Creation OAuth app](https://cloud.githubusercontent.com/assets/667519/25222203/1d9ad858-25b8-11e7-8a8c-7980a53c971f.png)

 
 ![OAuth app created](https://cloud.githubusercontent.com/assets/667519/25222188/08488aae-25b8-11e7-8f5e-b240b28c46ab.png)
 
 Once you created the OAuth application, you need to get the `client ID` and
 `client secret` to put those information in the `app/config/parameters.yml` file.
 
Installation
============
 
First of all you need to run the `$ composer install`.
 
 This application requires a MySQL database. You need to configure the following parameters in the app/config/parameters.yml
 file :
 
     database_host
     database_port
     database_name
     database_user
     database_password
Then run the following commands in your favorite command line tool :

`$ bin/console doctrine:database:create`
`$ bin/console doctrine:schema:create`
