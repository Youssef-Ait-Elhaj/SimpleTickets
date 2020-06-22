# SimpleTickets
_Simple Tickets_ is a simple tickets management system written in `PHP` using [Symfony Framework](https://symfony.com/).

## Requirements
- [Apache Server](https://httpd.apache.org/download.cgi) *
- [MySQL](https://www.mysql.com/downloads/) *
- [PHP version 7.2 or above](https://www.php.net/downloads.php) *
- [Symfony](https://symfony.com/download)
- [Composer](https://getcomposer.org/download/)

`* = for WindowsOS` [WAMP Server](https://www.wampserver.com/en/#download-wrapper) `can be used instead.` 

## Installing
After installing all the requirements, run the following commands in your terminal from the project's root folder :
1. Install dependencies.
    - `composer install`
2. Update your MySQL login credentials in the `.env` file then create the Database and Tables by running :
    - `php bin/console doctrine:database:create`
    - `php bin/console doctrine:schema:update --force`
3. Create the default admin, you can change its information in `src/DataFixtures/UserFixtures.php` :
    - `php bin/console doctrine:fixtures:load`
4. Start the server by running 
    - `symfony server:start`

## Screenshots
##### User
![User](https://imgur.com/N8WQU0p.png)

***

##### Technician
![Technician](https://i.imgur.com/aLnboPS.png)

***

##### Admin
![Admin](https://i.imgur.com/emrWH1C.png)

<br>

***

### Developers

[![Youssef-AH](https://badgen.net/badge/Developer/Youssef-AH/black?icon=github)](https://github.com/Youssef-AH)

#### Contributors

[![MERZAK-X](https://badgen.net/badge/Developer/MERZAK-X/grey?icon=github)](https://github.com/MERZAK-X)