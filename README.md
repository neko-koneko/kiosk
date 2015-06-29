Simple and lightweight web-application for LAMP-based "information kiosk" with minimalistic CMS for school.

Contains kiosk UI and CMS

Tailor-made for http://gym7.ru/

Kiosk UI has:

 - customizable single-level main menu
 - articles (main html entities)
 - announcements
 - news
 - schedule page for students and teachers


CMS includes:

 - Drag'n'Drop menu editor
 - WYSIWIG-editor (CKeditor) for announcements and articles with direct image and pdf upload
 - custom parser implementation for loading and processing of news from school's site http://gym7.ru/ site
 - schedule files import from "Profil" software product http://www.time-tabling.com/profil.php
 - cryptographically strong auth and password storage mechanism (single admin user)


KIOSK INSTALLATION BRIEF SUMMARY:

- install and configure LAMP stack on your kiosk machine
- calibrate touchscreen
- configure network for static IP address
- create user kiosk
- configure kiosk mode i.e. for Ubuntu https://thepcspy.com/read/converting-ubuntu-desktop-to-kiosk/
- use FireFox + grab-and-drag + R-kiosk instead of chrome (refer to /_kiosk_opt_sample/kiosk.sh)
- configure apache/nginx virtual host (default /var/www)
- copy this repo files i.e. via git clone
- create kiosk SQL user with basic CRUD permissions 
- import database from _database/kiosk-default.sql
- change password in /config/db_config.php
- test if UI works (CLI commands: start kiosk, stop kiosk)
- test if CMS works: open [kiosk ip]/admin in your browser. Default credentials are: admin/admin.
- remove /_database and /_kiosk_opt_sample from your installation
- harden access to admin part with SSL if necessery

AUTHOR:

(C) Korolev Alexey (_emploi-kun_), 2015
e-mail: neko-koneko@yandex.ru
tel: +7 (902) 251-19-29

LICENSE:

This project is licensed under the terms of the GPL license
Please refer to LICENSE.md in project's root directory
