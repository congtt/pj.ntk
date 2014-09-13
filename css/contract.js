			$(function() {
				$( "#dialog-form1" ).dialog({
					autoOpen: false,
					height: 600,
					width: 700,
					modal: true,
					resizable:false,
					buttons: {
						"Thoát": function() {
							$( this ).dialog( "close" );
						}		

					},
					close: function() {}
				});

			});
			function hths_show1(msg){	
				$('#preview_info1').html(msg)							
			}

			function hths_close1(){	
				$('#preview_info1').html('')		
			}	


			function get_product_contract(cId,token,str){
					var preload = message('Processing files. This may take several minutes.',100000);	
					$.ajax({
					   type: "POST",
					   url: "?module=Ajax&formaction=ajax&sugar_body_only=true",
					   data: "ajmode=getpcontract&cId="+cId+"&token="+token+'&'+str,
					   success: function(msg){	
							hths_show1(msg);		
							$( "#dialog-form1" ).dialog( "open" );					
							preload.achtung('close');
							
					   }
				});				
			}