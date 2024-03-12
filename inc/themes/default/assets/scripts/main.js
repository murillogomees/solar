$(document).ready(function() {
  setTimeout(function() {
    $(".info-holder").addClass("active");
  }, 100);
  
  //expanding login side on click
  if ($(window).innerWidth() > 1024) {
    $("#signin .side").click(function(params) {
      if ($(this).attr("data-active") !== "open") {
        $(this).attr("data-active", "true");
        $(this)
          .siblings()
          .attr("data-active", "false");
      }
    });
    $(document).on(
      "click",
      "#signin .page-holder.signin-active .signup",
      function(params) {
        $(".page-holder").removeClass("signin-active");
      }
    );
  }
  

  //animating scroll
  $("header [data-scroll]").click(function(e) {
    e.preventDefault();
    var scrollSection = $(this).data("scroll");
    var scrollTop =
      $('section[data-scroll="' + scrollSection + '"]').offset().top -
      $("header").height();
    $("html, body").animate({ scrollTop: scrollTop + "px" }, 1000);
  });

  //check if resized to responsive mode for forms
  $(window).on("resize load", function() {
    if ($(window).innerWidth() < 1024) {
      // $("#signin .side").attr("data-active", "start");
    }
  })  
});

  $(".dropdown.dropdown-click").click(function(e) {
    $(this)
      .find(".dropdown-list")
      .fadeToggle(200);
  });

  $(document).click("body", function(e) {
    if (
      $(e.target).closest(".dropdown-list").length === 0 &&
      $(e.target).closest(".dropdown").length === 0 &&
      !$('.dropdown input[data-role="value"]').is(":focus")
    ) {
      $(".dropdown-list").fadeOut(300);
    }
  });

  $(".js-timezone-dropdown a").click(function(e) {
    e.preventDefault();
    $(this)
      .closest(".dropdown")
      .find(".dropdown-append-value")
      .val($(this).data("value"))
      .addClass("has-value");
  });

  //change background of header on scroll
  $(window).on("scroll", function() {
    if ($(window).scrollTop() > 50) {
      $("header").addClass("fixed");
    } else {
      $("header").removeClass("fixed");
    }
  });

  //material style input
  $(".material-style input").focusout(function(e) {
    if (e.target.value.length > 0) {
      $(this).addClass("has-value");
    } else {
      $(this).removeClass("has-value");
    }
  });

  //expanding login side on click
  if ($(window).innerWidth() > 1024) {
    $("#signin .side").click(function(params) {
      if ($(this).attr("data-active") !== "open") {
        $(this).attr("data-active", "true");
        $(this)
          .siblings()
          .attr("data-active", "false");
      }
    });
    $(document).on(
      "click",
      "#signin .page-holder.signin-active .signup",
      function(params) {
        $(".page-holder").removeClass("signin-active");
      }
    );
  }

  //toggle menu responsive mode
  $(".menu-toggle").click(function() {
    $(this).toggleClass("is-active");
    $(".menu").fadeToggle(300);
  });

  //animating scroll
  $("header [data-scroll]").click(function(e) {
    e.preventDefault();
    var scrollSection = $(this).data("scroll");
    var scrollTop =
      $('section[data-scroll="' + scrollSection + '"]').offset().top -
      $("header").height();
    $("html, body").animate({ scrollTop: scrollTop + "px" }, 1000);
  });

  //check if resized to responsive mode for forms
  $(window).on("resize load", function() {
    if ($(window).innerWidth() < 1024) {
      // $("#signin .side").attr("data-active", "start");
    }
  })  
});
//# sourceMappingURL=main.js.map

/**
 * NeptuneTheme Namespace
 */
var NeptuneTheme = {};

/**
 * Login with facebook
 * @param {string} appid Facebook App ID
 */
NeptuneTheme.FacebookLogin = function(appid, url) {
  (function(d, s, id) {
    var js,
      fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  })(document, "script", "facebook-jssdk");

  window.fbAsyncInit = function() {
    FB.init({
      appId: appid,
      cookie: true,
      xfbml: true,
      version: "v2.9"
    });

    $(".fbloginbtn").fadeIn(500);

    $("body").on("click", ".fbloginbtn", function() {
      FB.login(
        function(auth) {
          if (auth.status == "connected") {
            FB.api("/me", { fields: "first_name, last_name, email" }, function(
              userinfo
            ) {
              $("body").addClass("onprogress");

              $.ajax({
                url: url,
                type: "POST",
                dataType: "jsonp",
                data: {
                  action: "fblogin",
                  firstname: userinfo.first_name,
                  lastname: userinfo.last_name,
                  email: userinfo.email,
                  token: auth.authResponse.accessToken,
                  userid: auth.authResponse.userID
                },

                error: function() {
                  $("body").removeClass("onprogress");
                },

                success: function(resp) {
                  if (resp.result == 1) {
                    window.location.href = resp.redirect;
                  } else {
                    $("body").removeClass("onprogress");
                  }
                }
              });
            });
          }
        },
        { scope: "email, public_profile" }
      );
    });
  };
};

//input search for custom lists
(function($, window, document, undefined) {
  "use strict";

  // undefined is used here as the undefined global variable in ECMAScript 3 is
  // mutable (ie. it can be changed by someone else). undefined isn't really being
  // passed in so we can ensure the value of it is truly undefined. In ES5, undefined
  // can no longer be modified.

  // window and document are passed through as local variable rather than global
  // as this (slightly) quickens the resolution process and can be more efficiently
  // minified (especially when both are regularly referenced in your plugin).

  // Create the defaults once
  var pluginName = "listSearch",
    defaults = {
      propertyName: "value"
    };
  var _list,
    _input,
    listValues = [];

  // The actual plugin constructor
  function Plugin(element, options) {
    this.element = element;
    _list = $(this.element).find('[data-role="list"]');
    _input = $(this.element).find('[data-role="value"]');
    this.options = $.extend({}, defaults, options);

    // jQuery has an extend method which merges the contents of two or
    // more objects, storing the result in the first object. The first object
    // is generally empty as we don't want to alter the default options for
    // future instances of the plugin
    this.settings = $.extend({}, defaults, options);
    this._defaults = defaults;
    this._name = pluginName;
    this.init();
  

  // Avoid Plugin.prototype conflicts
  $.extend(Plugin.prototype, {
    init: function() {
      setListValues();
      bindInputListener.call(this);
    },
    yourOtherFunction: function(text) {
      // some logic
      $(this.element).text(text);
    }
  })};

  function bindInputListener() {
    var _this = this;
    _input.on("input", function() {
      var value = $.trim($(this).val()).toLowerCase();
      console.log(value);
      filterKeywords(value);
    });
  }

  function setListValues() {
    var _this = this;
    _list.find("[data-list-item]").each(function(index, element) {
      listValues.push($.trim($(element).text()).toLowerCase());
    });
  }

  function filterKeywords(value = "") {
    var _this = this;
    for (var i = 0; i < listValues.length; i++) {
      if (listValues[i].includes(value)) {
        _list
          .find("[data-list-item]")
          .eq(i)
          .show();
      } else {
        _list
          .find("[data-list-item]")
          .eq(i)
          .hide();
        }
      }
    }});

function scrollTo(hash) {
    location.hash = "#" + hash;
}

var element_to_scroll_to = document.getElementById('cadastro');
 
