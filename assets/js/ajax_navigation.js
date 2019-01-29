// wReady and doInit -- helpers to wait for some *side* initialization before execution of some *our* initialization code.
wReady=function(f,w){var r=document.readyState;w||r!="loading"?r!="complete"?window.addEventListener("load",function(){f(3)}):f(3):document.addEventListener("DOMContentLoaded",function(){f(2)&&wReady(f)})}
doInit=function(f,w){(w>1||(w&&document.readyState=="loading")||f(1))&&wReady(f,w>1)}


// The task. Catching all links in <nav> section
var AJAXNavigation = {
    this_navigator: false,
    hasHistoryAPI: false,

    init: function(){
      this_navigator = this
      hasHistoryAPI = !!(window.history && history.pushState)

      $('nav a').each(this_navigator.hook_link)

      // prevent leave + AJAX refresh hoox
      $(window).bind('popstate', function(e){ this_navigator.navigate(location.href, 1) })
    },

    hook_link: function() {
      // avoid double hook
      if (!$(this).prop('ajax'))
        $(this).prop('ajax', 1).click(function() { return this_navigator.navigate($(this).prop('href')) })
    },

    navigate: function(url, is_back) {

      nav_url = url+'.php'

      // Preparing AJAX-request...
      hourglass.show(1)
      $.ajax({
         url: nav_url,

         success: function(data, status) {
           this_navigator.display_content(data)
         },
         error: function(jqXHR, textStatus, errorThrown) {
           this_navigator.display_content(jqXHR.responseText)
         }
      }).always(function(jqXHR, exception) {
         if (!is_back)
           window.history.pushState(null, null, url)
         hourglass.show(0)
      })

      return false
    },

    display_content: function(data) {
      $("#content-fill").html(data)
      $("#content-fill nav a").each(this_navigator.hook_link)
    }
}


doInit(function() {
  if (typeof $=="undefined") return 1
  AJAXNavigation.init()
})