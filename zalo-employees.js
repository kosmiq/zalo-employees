jQuery(function( $ ){

  aboutheight = function() {
    $imageheight = 0;
    $imageheight = $(".zalo-employee-image img").outerHeight();
    if ($('.responsive-check').css('display') == 'inline') {
      $('.zalo-employee-about').css('height', $imageheight);
    } else {
      $('.zalo-employee-about').css('height', 'auto');
    }
    //console.log('about' + $imageheight);
  };
  skillsheight = function() {
    $skillsheight = 0;
    $skillsheight = $(".zalo-employee-whyilove").outerHeight();
    $skillsheight = ($skillsheight - 1);
    if ($('.responsive-check').css('display') != 'none') {
      $('.zalo-employee-skills').css('height', $skillsheight);
    } else {
      $('.zalo-employee-skills').css('height', 'auto');
    }
    //console.log('love' + $skillsheight);
  };
  innerskillsheight = function() {
    $innerskillswidth = 0;
    $innerskillswidth = $(".zalo-employee-skills").width();
    if ($('.responsive-check').css('display') != 'none') {
      $('.zalo-employee-skills-wrap').css('width', $innerskillswidth);
    } else {
      $('.zalo-employee-skills-wrap').css('width', 'auto');
    }
    //console.log('love' + $skillsheight);
  };
  checkWidth = function() {
    var maxHeight = $('.zalo-employee-skills-wrap').height();
    var totalWidth = $('.zalo-employee-skills-wrap').width();
    var skillCount = $('.zalo-employee-skill').length;
    if (skillCount >= 10) {
      maxHeight = Math.round( (maxHeight / 3) );
    } else {
      maxHeight = Math.round( (maxHeight / 2) );
    }

    var extraWidth = Math.max.apply(Math, $('.zalo-employee-skill-title').map(function(){ return $(this).width(); }).get());
    var halfCount = Math.round( (skillCount / 2) );
        skillWidth = (totalWidth / halfCount);
    if ( (extraWidth > skillWidth) || (skillWidth > maxHeight) ) {
        skillWidth = extraWidth;
    }

    $('.zalo-employee-skill').each(function()
    {
      $(this).css( {
        'width':skillWidth+"px",
        'height':skillWidth+"px"
      });
    });
  };

  $(document).ready(function() {
    skillsheight();
    checkWidth();
    innerskillsheight();
    //$('.zalo-employee-image').imagesLoaded(aboutheight);
    $( ".zalo-employee-image" ).on( "lazyload.bj", "img", function() {
      $('.zalo-employee-image').imagesLoaded(aboutheight);
    });
  });

  $(window).resize(function() {
    aboutheight();
    skillsheight();
    checkWidth();
    innerskillsheight();
    $('.zalo-employee-image').imagesLoaded(aboutheight);
  });

});
