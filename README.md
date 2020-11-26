# DuckID - an Discord Ticket System Website

DuckID is an Ticket System which uses Discord as an Login Method.

(Tested on Debian 10)

## Requirements

- PHP 7.3
- Apache 2.4
- MySQL
- phpMyAdmin

## How to setup

The setup ist pretty easy. Just follow the following steps:

### Step 1:

Import the `setup/tables.sql` File into phpMyAdmin

### Step 2:

Head over to the `api/inc/db.inc.php` File and fill in the variables with the real values for your Database Connection

- `$db`: Name of the Database
- `$db_username`: Your username for mysql
- `$db_password`: Your password for mysql
- `$db_host`: Host of your mysql database (usually `localhost`)


### Step 3:

Head over to the `api/inc/discord.inc.php` File and fill in the `OAUTH2_CLIENT_ID`, `OAUTH2_CLIENT_SECRET` and `OAUTH_REDIRECT_URI` Variables from
the Discord Developers Page!

### Step 4:

Register on the Page, go to phpMyAdmin's `users` Table and change your status to `admin`


**You are ready to go!**

----------------------------------------------------------------------

If you encounter any bugs or need help, please open an issue.
