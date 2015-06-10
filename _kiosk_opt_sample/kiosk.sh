#!/bin/bash

xset -dpms
xset s off
openbox-session &

while true; do

    #if google chrome is used (sucks balls)
     
    #rm -rf ~/.{config,cache}/google-chrome/
    #rm -rf /home/kiosk/.cache/google-chrome/
    #google-chrome --kiosk --no-first-run  'localhost'


    #if firefox used (rocks socks)

    #rm /home/kiosk/.mozilla/firefox/*.default/*.sqlite #bad idea

    #clear nasty cache and session restore bullshit 
    rm /home/kiosk/.mozilla/firefox/*default/sessionstore.js
    rm -r /home/kiosk/.cache/mozilla/firefox/*.default/*

    # use in case of FUBAR
    # firefox -safe-mode

    # default normal mode
     firefox -url http://127.0.0.1

    # (IF) YOU NEED TO INSTALL PLUGINS WITHOUT KEYBOARD
    # GrabNDrag - allowed scrolling via touchscreen (crappy though)
    # firefox https://addons.mozilla.org/en-us/firefox/addon/grab-and-drag/

    # R-Kiosk - firefox pretty much enters limbo aftter this point,
    # so keep whole .mozilla folder backup handy
    # firefox https://addons.mozilla.org/en-US/firefox/addon/r-kiosk/
done
