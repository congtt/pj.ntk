
			var fbc = 1;
			$(function() {				
				$('input').keypress(function(event){			
					if (event.keyCode==13){				
						//frm_action(1); 
					}		
				})			

				// check all
				$('#check_all').click(function(){
					var cur_stat = $(this).attr('checked');
					$('#aj_result input[id*=chk_]').attr('checked', (cur_stat)? 'checked' : '');
				}); 
				/*
				$( "#dialog:ui-dialog" ).dialog( "destroy" );	
				$( "#dialog-form" ).dialog({
					autoOpen: false,
					height: 470,
					width: 400,
					modal: true,
					resizable:false,
					buttons: {
						"Thoát": function() {
							$( this ).dialog( "close" );
						},
						"Lưu thông tin": function() {
							var bValid = true;
							if ( bValid ) {
								sbm_form(5);						
								return;
							}
							
						}
					},
					close: function() {
						
					}
				});	*/
			
			});


			function hths_show2(msg){					
				$('#preview_info2').html(msg)							
			}

			function hths_close2(){	
				$('#preview_info2').html('')		
			}	

			function dg_add(module,action,Id,chkSum,title,width,height){
				//alert("?module="+module+"&action="+action+"&formaction=ajax&no_body=true");
				var preload = message('Processing files. This may take several minutes.',100000);	
					$.ajax({
					   type: "POST",
					   url: "?module="+module+"&action="+action+"&formaction=ajax&no_body=true",
					   data: "ajmode=get"+action+"&Id="+Id+"&token="+chkSum,
					   success: function(msg){	
							hths_show2(msg);							
							$( "#dialog-form" ).dialog( "option","title",title);
							if (width>0 && height>0)
							{
								$( "#dialog-form" ).dialog( "option","height",height);	
								$( "#dialog-form" ).dialog( "option","width",width);	
							}

							$( "#dialog-form" ).dialog( "open" );					
							preload.achtung('close');
							if ($('#formmode').val()=='VIEW')
							{
								$(":button:contains('Lưu thông tin')").hide(); 
							}
							else{
								$(":button:contains('Lưu thông tin')").show();
							}
							
					   }
				});	
			}


			function dg_del(id,token,pos,captcha){
				$("#chk_"+pos).attr('checked',false)
				$('#form1 #captcha').val(captcha);	
				if (confirm('Bạn có thật sự muốn xóa thông tin này ?'))
				{				
					
					var frm = document.form1;
					$('#mode_inpvl').val('DELETE');
					$("#chk_"+pos).attr('checked',true);
					$('#delId').val(id);
					$('#delToken').val(token);
					
					if(btn_submit('#form1'))
					{
						message('',10);
					}			
				}else{
					$("#chk_"+pos).attr('checked',false)
				}
			}

   function sbm_form(num,captcha){
		var frm = document.form1;
		$('#form1 #captcha').val(captcha);	
		$('#no_body').val('false');	
		if (num==1){
			$('#mode_inpvl').val('SEARCH');
			if(btn_submit('#form1'))
				{
					message('',10);
				}	
		}
		else if (num==16){
			$('#mode_inpvl').val('EXPORT');
			$('#no_body').val('true');			
			btn_submit('#form1')
		}
		else if (num==2){
			$('#mode_inpvl').val('ADD');
			$('#no_body').val('false');			
			btn_submit('#form1')
		}
		else if (num==4){
			$('#mode_inpvl').val('EDIT');
			$('#no_body').val('false');			
			btn_submit('#form1')
		}
		else if (num==8){
			if (confirm('Bạn có thật sự muốn xóa thông tin này ?'))
			{
				$('#mode_inpvl').val('DELETE');
				$('#no_body').val('false');			
				btn_submit('#form1')
			}
		}
		else if (num==05){	
			btn_submit('#form2')
		}	
	}


	function sbm_form_2(form,mode){
			$('#mode_inpvl').val(mode);
			btn_submit('#'+form)	
	}


	function timestamp(){
		var milliseconds = new Date().getTime();
		return milliseconds
	}



	function fnc_get_chained_box(firstId,nextId,Id,mode){
		var firstObj  = $('#'+firstId);
		var nextObj  = $('#'+nextId);

		var _x_options = nextObj.attr('options'); 
		_x_options.length =1;
		notify('Đang xử lý, vui lòng chờ trong giây lát...',0,10000);
		if (Id=='@'){return;}
		$.ajax({
			   type: "POST",
			   url: "?module=Ajax&action=Ajax&no_body=true",
			   data: "ajmode=location&Id="+Id+"&mode="+mode,
			   success: function(msg){
				   //$.pnotify_remove_all();
					var js_obj = eval('(' + msg + ')');				
					if(js_obj.length>0)			
						{		
							for (i=0;i<js_obj.length;i++){
								var val = js_obj[i].record_id;
								var text = js_obj[i].item;
								var tmp=' ';
								nextObj.append($('<option  '+tmp+'></option>').val(val).html(text))
							}
						}	
					
				}
			});	
			
	}


	function notify(txt,type,delay){
		if (!delay)
		{
			delay=8000
		}
		var _type='info';
		if (type==0){ _type='';}
		else if (type==1){ _type='info';}
		else if (type==2){ _type='success';}
		else if (type==3){ _type='error';}
		$.pnotify({
			title: '',
			text: txt,
			delay: delay,
			type: _type,
			styling: 'jqueryui'
		});	
	}

	function notLogin(){
		//alertify.error('Vui lòng đăng nhập để thực hiện chức năng này.');
		alert('Vui lòng đăng nhập để thực hiện chức năng này.');
	}