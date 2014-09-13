			var hButtons = null;
			$(function() {
				$( "#dialog:ui-dialog" ).dialog( "destroy" );
				$( "#hDialog" ).dialog({
					autoOpen: false,
					height: 0,
					width: 0,
					modal: true,
					resizable:false,
					buttons: {
						"Thoát": function() {
							$( this ).dialog( "close" );
						}		

					},
					close: function() {
						$('#hPreview').html('')	
					}
					, open: function(event, ui){
						var hDialogObj = $(event.target).parents(".ui-dialog.ui-widget");
						hButtons = hDialogObj.find(".ui-dialog-buttonpane").find("button");

						var arrInfo = $( "#hDialog" ).dialog( "option",'arrInfo');
						var btnQuit = hButtons[0];
						$(btnQuit).addClass("btn_quit");
						for (i=1;i<hButtons.length ;i++ )
						{							
							$(hButtons[i]).addClass("btn_all btn_act"+i);
						}
						$('.btn_all').hide();
						$('.btn_act1').show();

					
						var fn = window['hDialogOpen']; 
						if(typeof fn === 'function') {
							fn(arrInfo);
						}

					
					
					}
				});

			});
			function hShow(msg){	
				$('#hPreview').html(msg)							
			}

			function hClose(){	
				$('#hPreview').html('')		
			}	


 
			function setDialog(msg,title,width,height,arrInfo){
				
				hShow(msg);
				var option = {};
				if(typeof(width)=='undefined')
					option.width=400;
				else
					option.width=width;

				if(typeof(title)=='undefined')
					option.title="Thong bao";
				else
					option.title=title;


				if(typeof(height)=='undefined')
					option.height=400;
				else
					option.height=height;

				option.buttons={
						'Thoát': function() { $(this).dialog("close");}
						, "btn1": function() { 	}
						, "btn2": function() { 	}
					};

				if(typeof(arrInfo)!='undefined')
					option.arrInfo = arrInfo

				$( "#hDialog" ).dialog( "option", option );
				$( "#hDialog" ).dialog("open" );	
								
				
			
			}

	function chk_flag(text){
		if (text=='')
		{
			text = 'Vui lòng chọn thông tin trước khi thực hiện thao tác!'
		}
	
		var cnt =$('[name=chk[]]:checked').length;
		if (cnt==0)
			{
				alert(text);
				return false;
			}	
		return true;
	}		