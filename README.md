socialscript
============

Social community script

Version 2.0

http://www.social-script.com

Copyright
---------

Copyright (C) 2012-2013
    Paul Trombitas <immortalzn2_at_gmail.com>

License
-------

This program is free software; you can redistribute it and/or modify it under
the terms of the GNU General Public License version 2, as published by the
Free Software Foundation.

This program is distributed in the hope that it will be useful, but WITHOUT
ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
 

Requirements
------------

* PHP 5.4 or later
* PDO
* APC or MEMCACHE if you want to enable them
* MySQL 5.0 or later
 




Download
--------

You can get the newest version at https://github.com/immortalzn/socialscript


Installation
------

Copy the content of httpdocs dir in the web root folder,and the 'application' folder above your web root folder.
Add the database credentials and google analytics credentials(if you want it to show in admin) in application/configs/config.php.

Make the following directories recursive 777:
data/cache
data/compile
data/logs
data/sessions (if you want the sessions files to be saved in this directory)
data/uploads

The database file is community.sql,you can import it in your phpmyadmin or whatever you use for managing your databases.
Login to admin and go to settings and insert the website url.That would be it.



