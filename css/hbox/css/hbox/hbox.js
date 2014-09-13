(function($) {
  $.hbox = function(data, klass) {

  }

  /*
   * Public, $.hbox methods
   */
	$.extend($.hbox, {
		//settings//
		settings: {
				  opacity      : 0,
				  overlay      : true,
				  rootImage	   : 'css/hbox/css/hbox/',
				  loadingImage : 'loading.gif',
				  closeImage   : 'closelabel.gif',
				  imageTypes   : [ 'png', 'jpg', 'jpeg', 'gif' ]	

		 },
		//show//
		HBShow: function(data, klass) {

				//showOverlay()
				$('#hbox .content').empty()
				$('#hbox .content').append(data)
				//$('#hbox_overlay .loading').remove();

				var xTop = $(window).height() / 2 - ($('#hbox').height() / 2);
				var y=0;
				if (self.pageYOffset) // all except Explorer
				{
					y = self.pageYOffset;
					xTop+=y;
				}
				else if (document.documentElement && document.documentElement.scrollTop)
				{			
					y = document.documentElement.scrollTop;
					xTop+=y;
				}


				$('#hbox').css('left', $(window).width() / 2 - ($('#hbox').width() / 2))
				$('#hbox').css('top',xTop)
				$('#hbox_overlay').css('display','')
				$('#hbox').hide().fadeIn(100)

		},
		//==================//
	    HBClose: function() {
  		  $('#hbox_overlay').css('display','none')
		  $(document).trigger('close.hbox')
		  return false
		}	

	})
  /*
   * Public, $.fn methods
   */

  $.fn.hbox = function(settings) {
		init(settings);
	
		function clickHandler(){
			//return false;
			if(this.rel.indexOf('hbox')>-1)
			{
				showOverlay()
				var klass = this.rel.match(/hbox\[?\.(\w+)\]?/)
			    if (klass) klass = klass[1]	
				fillFromHref(this.href,klass)	
				return false
			}else{
				return true;	
			//	
			}
		}
		
		
		return this.click(clickHandler)			
  }

  /*
   * Private methods
   */

  function init(){
	
	var imageTypes = $.hbox.settings.imageTypes.join('|')
	$.hbox.settings.imageTypesRegexp = new RegExp('\.' + imageTypes + '$', 'i')
	pathImg		=	$.hbox.settings.rootImage;
	closeImg	=	pathImg+$.hbox.settings.closeImage;
	loadingImg	=	pathImg+$.hbox.settings.loadingImage;


	var hboxHTML = '				<div id="hbox" class="hbox_hide"> ';
	hboxHTML+= '						<table  border="0" cellpadding="0" cellspacing="0" id="hb_table"> ';
	hboxHTML+= '						  <tr> ';
	hboxHTML+= '							<td width="10" height="10"><img src="'+pathImg+'tl.png" width="10" height="10" /></td> ';
	hboxHTML+= '							<td height="10" background="'+pathImg+'b.png"></td> ';
	hboxHTML+= '							<td width="10" height="10"><img src="'+pathImg+'tr.png" width="10" height="10" /></td> ';
	hboxHTML+= '						  </tr> ';
	hboxHTML+= '						  <tr> ';
	hboxHTML+= '							<td width="10" background="'+pathImg+'b.png">&nbsp;</td> ';
	hboxHTML+= '							<td height="100%" align="left" valign="top" bgcolor="#FFFFFF"><table width=100% height=100% border=0 cellpadding=0 cellspacing=0><tr><td  align="left" valign="top"  bgcolor="#FFFFFF">';
//	hboxHTML+= '									<div id="hb_header"><a href="#" class="close"><img src="'+closeImg+'" border=0></a></div>';						
//	hboxHTML+= '									<div class="line" id="hb_line"></div> ';						
	hboxHTML+= '									<div class="content"></div> ';						
	hboxHTML+= '							</td></tr></table></td> ';
	hboxHTML+= '							<td width="10" background="'+pathImg+'b.png">&nbsp;</td> ';
	hboxHTML+= '						  </tr> ';
	hboxHTML+= '						  <tr> ';
	hboxHTML+= '							<td width="10" height="10"><img src="'+pathImg+'bl.png" width="10" height="10" /></td> ';
	hboxHTML+= '							<td height="10" background="'+pathImg+'b.png"></td> ';
	hboxHTML+= '							<td width="10" height="10"><img src="'+pathImg+'br.png" width="10" height="10" /></td> ';
	hboxHTML+= '						  </tr> ';
	hboxHTML+= '						</table> ';
	hboxHTML+= '					</div>';

	 $('body').append(hboxHTML);
     $("body").append('<div id="hbox_overlay" class="hb_overlay" style="display:none"></div>')
	 getPageSizeWithScroll()
     $('#hbox_overlay')
	  .addClass("hb_overlay")
	  //.click(function() {$(document).trigger('close.hbox') })
	  .css('height', yWithScroll)
	  .css('width', $(window).width())
	$('#hbox .close').click(function() {$(document).trigger('close.hbox') })
  }


  function showOverlay() {	

	$.hbox.HBShow('<div align=center><img src='+loadingImg+'></div>');
	$('#hbox_overlay').hide().fadeIn(100)
	$('#hbox .close').click(function() {$(document).trigger('close.hbox') })
    return false
  }

  function hideOverlay() {

    $('#hbox_overlay').fadeOut(100, function(){
     // $("#hbox_overlay").removeClass("hb_overlay")
     // $("#hbox_overlay").addClass("hbox_hide") 
      //$("#hbox_overlay").remove()

    })
    
	$('#hbox').fadeOut(200, function(){
      $('#hbox .content').empty()
    })

    return false
  }



  function fillFromHref(href, klass) {
    // div
   //fillFromAjax(href, klass)
   if (href.match(/#/)) {
      var url    = window.location.href.split('#')[0]
      var target = href.replace(url,'')
	  $.hbox.HBShow($(target).clone().show(), klass)

    // image
    } else if (href.match($.hbox.settings.imageTypesRegexp)) {
		fillFaceboxFromImage(href, klass) 
    // ajax
    } else {
		fillFromAjax(href, klass)
    }
  }

  function fillFaceboxFromImage(href, klass) {
    var image = new Image()
    image.onload = function() {
      $.hbox.HBShow('<div class="image"><img src="' + image.src + '" /></div>', klass)
    }
    image.src = href
  }

  function fillFromAjax(href, klass) {
	 $.get(href, function(data){
		$.hbox.HBShow(data, klass)
	});
  }

  function getPageScroll() {
    var xScroll, yScroll;
    if (self.pageYOffset) {
      yScroll = self.pageYOffset;
      xScroll = self.pageXOffset;
    } else if (document.documentElement && document.documentElement.scrollTop) {	 // Explorer 6 Strict
      yScroll = document.documentElement.scrollTop;
      xScroll = document.documentElement.scrollLeft;
    } else if (document.body) {// all other Explorers
      yScroll = document.body.scrollTop;
      xScroll = document.body.scrollLeft;	
    }
    return new Array(xScroll,yScroll) 
  }

  // Adapted from getPageSize() by quirksmode.com
  function getPageHeight() {
    var windowHeight
    if (self.innerHeight) {	// all except Explorer
      windowHeight = self.innerHeight;
    } else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
      windowHeight = document.documentElement.clientHeight;
    } else if (document.body) { // other Explorers
      windowHeight = document.body.clientHeight;
    }	
    return windowHeight
  }


	function getPageSizeWithScroll(){     
			if (window.innerHeight && window.scrollMaxY) {// Firefox        
				yWithScroll = window.innerHeight + window.scrollMaxY;         
				xWithScroll = window.innerWidth + window.scrollMaxX;   
			} else if (document.body.scrollHeight > document.body.offsetHeight){ // all but Explorer Mac    
				yWithScroll = document.body.scrollHeight;      
				xWithScroll = document.body.scrollWidth;     
				
			} else { 
			// works in Explorer 6 Strict, Mozilla (not FF) and Safari      
				yWithScroll = document.body.offsetHeight+30;        
				xWithScroll = document.body.offsetWidth;       
			}     
	 } 

  /*
   * Bindings
   */

  $(document).bind('close.hbox', function() {
	 hideOverlay()
  })

	var pathImg		=	null;
	var closeImg	=	null;
	var loadingImg	=	null;
})(jQuery);
