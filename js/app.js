$(function(){

	$(".login-sign").on("click",function(){		   
			  $(".pop-log-wrap").css("display","block");	
				 $(".pop-log").css("display","block");	
			   
	});
	$(".close").on("click",function(){		   
			 
				 $(".pop-log").css("display","none");	
				 $(".pop-log-wrap").css("display","none");	
			   
			   
	});
			   });
  $(document).ready(function() {
  
  var pages = $(".page").length,
      scrolling = false,
      curPage = 1;
  
  function pagination(page, movingUp) {
    scrolling = true;
    var diff = curPage - page,
        oldPage = curPage;
    curPage = page;
    $(".page").removeClass("active small previous");
    $(".page-" + page).addClass("active");
    $(".nav-btn").removeClass("active");
    $(".nav-page" + page).addClass("active");
    if (page > 1) {
      $(".page-" + (page - 1)).addClass("previous");
      if (movingUp) {
        $(".page-" + (page - 1)).hide();
        var hackPage = page;
        setTimeout(function() {
          $(".page-" + (hackPage - 1)).show();
        }, 600);
      }
      while (--page) {
        $(".page-" + page).addClass("small");
      }
    }
    console.log(diff)
    if (diff > 1) {
      for (var j = page + 1; j < oldPage; j++) {
        $(".page-" + j + " .half").css("transition", "transform .7s ease-out");
      }
    }
    setTimeout(function() {
      scrolling = false;
      $(".page .half").attr("style", "");
      $(".page")
    }, 700);
  }
  
  function navigateUp() {
    if (curPage > 1) {
      curPage--;
      pagination(curPage, true);
    }
  }

  function navigateDown() {
    if (curPage < pages) {
      curPage++;
      pagination(curPage);
    }
  }
  
  $(document).on("mousewheel DOMMouseScroll", function(e) {
    if (!scrolling) {
      if (e.originalEvent.wheelDelta > 0 || e.originalEvent.detail < 0) {
        navigateUp();
      } else { 
        navigateDown();
      }
    }
  });
  
  $(document).on("click", ".scroll-btn", function() {
    if (scrolling) return;
    if ($(this).hasClass("up")) {
      navigateUp();
    } else {
      navigateDown();
    }
  });
  
  $(document).on("keydown", function(e) {
    if (scrolling) return;
    if (e.which === 38) {
      navigateUp();
    } else if (e.which === 40) {
      navigateDown();
    }
  });
  
  $(document).on("click", ".nav-btn:not(.active)", function() {
    if (scrolling) return;
    pagination(+$(this).attr("data-target"));
  });

});
$(document).ready(function() {
  
  $(".animsition-overlay").animsition({
  
    inClass               :   'overlay-slide-in-right',
    outClass              :   'overlay-slide-out-right',
    inDuration            :    1500,
    outDuration           :    800,
    linkElement           :   '.animsition-link',
    // e.g. linkElement   :   'a:not([target="_blank"]):not([href^=#])'
    loading               :    true,
    loadingParentElement  :   'body', //animsition wrapper element
    loadingClass          :   'animsition-loading',
    unSupportCss          : [ 'animation-duration',
                              '-webkit-animation-duration',
                              '-o-animation-duration'
                            ],
    //"unSupportCss" option allows you to disable the "animsition" in case the css property in the array is not supported by your browser.
    //The default setting is to disable the "animsition" in a browser that does not support "animation-duration".
    
    overlay               :   true,
    
    overlayClass          :   'animsition-overlay-slide',
    overlayParentElement  :   'body'
  });
});