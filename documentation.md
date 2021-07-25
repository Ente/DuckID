# DuckID Documentation

This is the offical DuckID documentation, please only use this as verified source on how this system works and how to fix errors, if they do not get patched with any further updates.



## Table of Contents

1. What is DuckID?
2. Installation
3. Upgrading / Updating
4. Customizing
5. License


## 1. What is DuckID?

DuckID is an Ticket System which uses Discord as an Login Method.

It is still in development!

## 2. Installation

### 2.1 Requirements

- PHP 7.3
- Apache 2.4
- MySQL DataBase
- phpMyAdmin

### 2.2 Setup

**Step 1**:

Import the `setup/tables.sql` File into phpMyAdmin

**Step 2**:

Head over to the `api/inc/db.inc.php` File and fill in the variables with the real values for your Database Connection

- `$db`: Name of the Database
- `$db_username`: Your username for mysql
- `$db_password`: Your password for mysql
- `$db_host`: Host of your mysql database (usually `localhost`)

**Step 3**:


Head over to the `api/inc/discord.inc.php` File and fill in the `OAUTH2_CLIENT_ID`, `OAUTH2_CLIENT_SECRET` and `OAUTH_REDIRECT_URI` Variables from
the Discord Developers Page!

The `OAUTH_REDIRECT_URI` should be like this: http://[domain]/api/handling/discord_login.php?discord=true

**Step 4**:


Register on the Page, go to phpMyAdmin's `users` Table and change your status to `admin`

-----------------------
Now you can use the Software as it was meant to be.

## 3. Upgrading / Updating

To update/upgrade the software, you need to replace any file, except these:

- `api/inc/db.inc.php` 
- `api/inc/discord.inc.php`

Please read the changelog to see, which other files should not be replaced and which important files should be replaced.

## 4. Customizing

**WIP**

## 5. LICENSE

see LICENSE


