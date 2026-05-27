$(document).ready(function(){
  var lastScrollTop = window.pageYOffset || document.documentElement.scrollTop;
  var hideAfter = 24;
  var topbar = document.getElementById("topbar");
  var widebar = document.querySelector(".widebar");

  function updateHeaderMeasurements() {
    if (!topbar || !widebar) {
      return;
    }

    var topbarHeight = topbar.offsetHeight;
    var headerHeight = topbarHeight + widebar.offsetHeight;
    document.documentElement.style.setProperty("--topbar-height", topbarHeight + "px");
    document.documentElement.style.setProperty("--site-header-height", headerHeight + "px");
  }

  function updateHeaderVisibility() {
    var currentScrollTop = Math.max(window.pageYOffset || document.documentElement.scrollTop, 0);
    var scrollDelta = currentScrollTop - lastScrollTop;

    if (Math.abs(scrollDelta) < 4) {
      return;
    }

    if (currentScrollTop <= hideAfter || scrollDelta < 0) {
      document.body.classList.remove("site-header-hidden");
    } else if (scrollDelta > 0) {
      document.body.classList.add("site-header-hidden");
    }

    lastScrollTop = currentScrollTop;
  }

  updateHeaderMeasurements();
  window.addEventListener("resize", updateHeaderMeasurements);
  window.addEventListener("scroll", updateHeaderVisibility, { passive: true });

  // light up parent menu option when poem submenu is highlighted 
  $(".poemoptions a").hover(function() {
      $(this).css("background-color","#000000");
      $(".poetry").css("background-color","#000000");

      $(".poemoptions a, .poetry").hover(function() {
          $(".poetry").css("background-color","#000000");
      }, function() {
	  $(".poetry").css("background-color","#444444");
      });
  },
  function () {
      $(this).css("background-color","#444444");
  }); 

  // light up parent menu option when poem submenu is highlighted 
  $(".articleoptions a").hover(function() {
      $(this).css("background-color","#000000");
      $(".journalism").css("background-color","#000000");

      $(".articleoptions a, .journalism").hover(function() {
          $(".journalism").css("background-color","#000000");
      }, function() {
	  $(".journalism").css("background-color","#444444");
      });
  },
  function () {
      $(this).css("background-color","#444444");
  }); 

  // light up menu options when mouse hovers over them
  $(".navitem, .connect, .writings").hover(function() {
      $(this).css("background-color","#000000");
  },
  function () {
      $(this).css("background-color","#444444");
  });

  // keep second tier of submenus open when hovered over
  $(".poetry").hover(function() {
      $(".poemoptions a").height($(".poetry").height()-2);
      $(".poemoptions").show();
      $(".poemoptions").hover(function() {
          $(".poemoptions").show();},
			      function() {
	  $(".poemoptions").hide();});
  },
  function () {
      $(".poemoptions").hide();
  });

  // keep second tier of submenus open when hovered over
  $(".journalism").hover(function() {
      $(".articleoptions a").height($(".poetry").height()-2);
      $(".articleoptions").show();
      $(".articleoptions").hover(function() {
          $(".articleoptions").show();},
			      function() {
	  $(".articleoptions").hide();});
  },
  function () {
      $(".articleoptions").hide();
  });

  // hide poem divs
  $("#content").hide();

  $("#content a").click(function(event) {
    event.preventDefault();
    $("#content").slideToggle();
  });

  $(".subnav").click(function(event) { //When trigger is clicked...	 	
    
      //Following events are applied to the subnav itself (moving subnav up and down)
      $(this).parent().find("ul.submenu").slideToggle(); //Drop down the subnav on click
      event.preventDefault();

      // When the mouse hovers out of the subnav, move it back up
      $(this).parent().hover(function() {}, function(){	
      $(this).parent().find("ul.submenu").slideUp(); 
    });
  });

    // The old poem browser loaded text from a PHP/MySQL endpoint. The static site keeps the
  // click styling but does not attempt to fetch retired server-side content.
  $(".poemlink1bg a, .poemlink0bg a").click(function(event) {
    event.preventDefault();
    $(".poemlink1bg").css("background-color","#DDDDDD");
    $(".poemlink0bg").css("background-color","#999999");
    $(".poemlink1bg a, .poemlink0bg a").css("font-style","normal");
    $(this).parent().css("background-color","#9999FF");
    $(this).css("font-style","italic");
    $("#poemtext").html("This archived poem browser is not included in the static site.");
  });
});
