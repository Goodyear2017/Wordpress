		
	(function($){
	  $(window).load(function() {
		  var canvas = document.getElementById('kenburns');
		
           // context = canvas.getContext('2d');
			

    // resize the canvas to fill browser window dynamically
    window.addEventListener('resize', resizeCanvas, false);

    function resizeCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight/1.4;



            /**
             * Your drawings need to be inside this function otherwise they will be reset when 
             * you resize the browser window and the canvas goes will be cleared.
             */
           
   
				$('#kenburns').kenburns({
					images:[
					'img1.jpg',
					'img2.jpg'
							
							
			
							],
					frames_per_second: 30,
					display_time: 9000,
					fade_time: 1500,
					zoom: 2,
					background_color:'#ffffff',
					post_render_callback:function($canvas, context) {
						// Called after the effect is rendered
						// Draw anything you like on to of the canvas
						
						context.save();
						context.fillStyle = '#000';
						context.font = 'normal 14px sans-serif';
						var width = $canvas.width();
						var height = $canvas.height();												
						var text = "Photos by  ";
						var metric = context.measureText(text);
						
						context.fillStyle = '#fff';
						
						context.shadowOffsetX = 1;
						context.shadowOffsetY = 1;
						context.shadowBlur = 2;
						context.shadowColor = 'rgba(0, 0, 0, 0.8)';
						
						context.fillText(text, width - metric.width - 8, height - 8);						
						
						context.restore();						
					}
					
				});
				
				 }
    resizeCanvas();
	});
	})(jQuery);
	
	