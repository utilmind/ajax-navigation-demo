// wReady and doInit -- helpers to wait for some *side* initialization before execution of some *our* initialization code.
wReady=function(f,w){var r=document.readyState;w||r!="loading"?r!="complete"?window.addEventListener("load",function(){f(3)}):f(3):document.addEventListener("DOMContentLoaded",function(){f(2)&&wReady(f)})}
doInit=function(f,w){(w>1||(w&&document.readyState=="loading")||f(1))&&wReady(f,w>1)}

var site_root = "/demos/2019/ajax-navigation";

// The task. Catching all links in <nav> section
var AJAXNavigation = {
    hasHistoryAPI: false,

    init: function(){
      var me = this
      this.hasHistoryAPI = !!(window.history && history.pushState);

      $("nav a").each(function() { me.hook_link(this) });

      // prevent leave + AJAX refresh hoox
      $(window).bind("popstate", function(e){ me.navigate(location.href, 1); });
    },

    hook_link: function(e) {
      if (!e || $(e).prop("ajax")) return; // avoid non-anchors and double hooks.

      var me = this
      $(e).prop('ajax', 1).click(function() {
        return me.navigate($(this).prop('href'));
      });
    },

    navigate: function(url, is_back) {

      var me = this,
          cur_url = url,
          nav_url = url+'.php';

      // Preparing AJAX-request...
      hourglass.show(1);
      $.ajax({
         url: nav_url,

         success: function(data, status) {
           me.display_content(data, cur_url);
         },
         error: function(jqXHR, textStatus, errorThrown) {
           me.display_content(jqXHR.responseText, cur_url);
         }
      }).always(function(jqXHR, exception) {
         if (!is_back)
           window.history.pushState(null, null, url);
         hourglass.show(0);
      });

      return false;
    },

    display_content: function(data, url) {
      var me = this
      if (site_root !== "undefined") {
        var i = url.indexOf(site_root);
        if (i >= 0)
          url = url.substr(i + site_root.length + 1);
      }
      $("#current-area").html(url);
      $("#content-fill").html(data);
      $("#content-fill nav a").each(function() { me.hook_link(this); });
    }
};


doInit(function() {
  if (typeof $=="undefined") return 1;
  AJAXNavigation.init();
});
