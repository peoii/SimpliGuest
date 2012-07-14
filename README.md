SimpliGuest
===========
Version:         0.7
Author:          Jamie Harrell (jamie@jamieharrell.com)
Website:         [jamieharrell.com](http://www.jamieharrell.com/)

Description
-----------

A guestbook designed in PHP for use on any website. This guestbook (unlike most I've found on the internet) is easily expandable, easily customizeable, completely templated, and best of all, secure.

**NOTE:** It should be noted that this code was released initially back in 2003 under the name _peoGuest_, and I haven't had a proper chance to give it a code update yet.  Is it functional? Yes.  Does it need some polish? Definitely.
It's on my list of things to update, but as the page that originally hosted the file is still getting hit regularly, I'm releasing the code here in GitHub in order to facilitate updates more frequently once 
I get a chance to work this project.

Installation
------------

   1. Unzip the package into a new folder on your server.
   2. Change the permissions on entries.php to either 777 or 666 (typically 666 should work). This gives read and write access to the file.
   3. Open config.php
   4. Edit the following lines with your admin username and password:
         * $admin_name = "admin";
         * $admin_password = "admin";
   5. Modify your templates (.tpl files) to suit, if you'd like.
   6. Modify header.inc and footer.inc to fit your sites design.
   7. If you need any help or have any questions, please feel free to ask in <a href="http://www.peoii.com/community/viewforum.php?f=15">the forums</a>.

License
-------

Copyright 2003 Jamie Harrell (Peoii). All rights reserved.

You may use the code associated with this project so long as you abide by the information located 
within the LICENSE file included in the Git repository located at [github.com/peoii](https://github.com/peoii/SimpliGuest), 
and that this README is included in your package and remains unaltered.

