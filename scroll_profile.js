(function($) {
 "use strict";
	$(window).load(function(){
		/*var summary=$('.summary');
		if (summary.parent().hasClass('section-video'))
{
  summary.css("display:block");
}
*/
$(function () {
    // init
    var controller = new ScrollMagic.Controller({
        globalSceneOptions: {
            triggerHook: 'onLeave'
        }
    });

    // get all slides
    var slides = document.querySelectorAll("section.panel");

    // create scene for every slide
    for (var i=0; i<slides.length; i++) {
        new ScrollMagic.Scene({
                triggerElement: slides[i]
            })
           .setPin(slides[i])
				 // add indicators (requires plugin)
				.addTo(controller);
    }
	});
//scrollto


var wrapper = $("#section-wipes"),
    $menu = $("#nav"),
    $window = $(window);

$menu.on("click","a", function(){
    var $this = $(this),
        href = $this.attr("href"),
        topY = $(href).offset().top;
   
    TweenMax.to($window, 1, {
        scrollTo:{
            y: topY, 
            autoKill: true
        }, 
        ease:Power3.easeOut 
     });
  
  return false;
});  
// moving image




//frong page animation

var mySplitText = new SplitText("#quote", {type:"chars, words"}),
    tl = new TimelineLite(),
    numChars = mySplitText.chars.length;

for(var i = 0; i < numChars; i++){
  //random value used as position parameter
  tl.from(mySplitText.chars[i], 2, {opacity:0}, Math.random() * 2);
}
		
// Selected work parallax scene     
      
    var selectedWork = new TimelineMax();
    
    // Stagger tl
    selectedWork
        .staggerFromTo('.project', 1, {y:0, autoAlpha:0}, {y:20, autoAlpha:1, ease:Elastic.easeOut.config(2, 0.75)}, 0.1)
        .staggerFromTo('ul#nav h3', 0.5, {y:-10, scale:1.1},{y:0, scale:1, ease:Back.easeOut.config(4)}, '-=0.5');

    $('.project').each(function(index, element){
      var projectHover = new TimelineMax({paused:true});
      projectHover
              .to(($(this).find('figure')), 0.5, {scale:1.1, ease:Back.easeOut.config(3)}, 0)
              .to(($(this).find('h3')), 0.5, {y:20, scale:1.1, ease:Back.easeOut.config(3)}, '-=0.5');
        element.animation = projectHover;
    });
    
$('.project').hover(over, out);
function over(){ this.animation.play() };
function out(){ this.animation.reverse() };
    
});

})(jQuery); 