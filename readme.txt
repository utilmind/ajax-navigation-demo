What I have added:

  1. /.htaccess -- you may see the redirection of all "missing" content to "/index.php". (This index.php is our main engine for processing all requests.)
     BTW, I would suggest to move this redirection into your Apache configuration. .htaccess may slow down your system because it read on each HTTP request.
     This redirection should be described right in httpd.conf/nginx.conf, which loaded once when Apache/Nginx starts.

  2. /assets/js/ajax_navigation.js -- jQuery-based object which hooks all clicks on the links in all <nav> areas.
     It downloads some contents from URL and displays it in "#content-fill" area (see inside dotted red border in live demo).
     The navigation object initializes automatically after full load of web page and jQuery.

  3. /assets/js/hourglass.js (and /assets/js/hourglass.min.js) -- this script used to display tiny animated hourglass, while performing some AJAX request.
     The hourglass is being created and added to DOM itself automatically. To display hourglass -- call "hourglass.show(1)", and "hourglass.show(0)" to hide it.

  4. /index.php -- it's our primary engine (php code prior to HTML) and the template. My modifications in your HTML-template:
        4.1: requesting to use 2 JavaScripts: "ajax_navigation.js" and "hourglass.js";
        4.2: added "/" before each link, to specify an absolute path to some content (or relative to the website root).
             We need these links working (and CSS/JS loaded) even when we're in "/items" folder. Of course there is no "/items/assets", so we need absolute paths.
        4.3: added red dotted border over "#content-fill" area)


What can be improved:
  1. ajax_navigation.js -- it should distinguish local and external links. Of course it shouldn't hook external links (because remote content can't be gracefully
     loaded with AJAX without some backend-based "proxy" script due to cross-domain security policies). But your site seems contains only local links, so I didn't
     overloaded this script with unnecessary functionality.