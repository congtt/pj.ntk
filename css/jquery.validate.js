var _xVLDAlert = null;
_xVLDReAlert = null;
_xVLDMask = null;
_xVLDMinLength = null, _xVLDOBJCompare = null;
_xVLDType = null;
var xVLDFlag = true,
	_VLDClassName = null,
	xVLDMode = null,
	xVLDMode1 = null;

function btn_submit(frmame) {

	var frm = $(frmame).serializeArray();
	var xVLDFlag = true,
		_VLDClassName = null,
		xVLDMode = null,
		xVLDMode1 = null;
	if (typeof chkall_first == "function") {
		chkall_first();
	};



	for (var i = 0; i < frm.length; i++) {
		_obj = $('#' + frm[i]['name'])

		if (typeof _obj != 'undefined' && typeof _obj.attr('rel') != 'undefined') {

			if (_obj.attr('rel') != '' && _obj.attr('rel').indexOf('{') >= 0) {
				
				_obj.attr('style','background-color:')
				_xVLDType = _obj.attr('type');
				_rel = eval(' _rel = ' + _obj.attr('rel'));
				xVLDMode = _rel.Require.toUpperCase()
				_xVLDAlert = _rel.Alert;
				_xVLDReAlert = _rel.ReAlert;
				xVLDMode1 = xVLDMode.substring(0, 1);				
				if (xVLDMode1 == 'R') {
					xVLDFlag = OBJRequire(_obj);
					if (xVLDFlag == false) {
						i = frm.length;
						return xVLDFlag;
					}
				}
				if (xVLDMode == 'REMAIL' || xVLDMode == 'EMAIL') {
					xVLDFlag = OBJEmail(_obj);
					if (xVLDFlag == false) {
						i = frm.length;
						return xVLDFlag;
					}
				}
				
				if (xVLDMode=='REXTFILE' || xVLDMode=='EXTFILE' ){
					xVLDFlag=OBJExtFile(_obj);
					if (xVLDFlag==false){
						i=frm.length;
						return xVLDFlag;
					}
				}
			}
		}
	}
	if (typeof chkall_ext == "function") {
		return chkall_ext();
	}
	$(frmame).submit();
	return xVLDFlag;
}

function OBJRequire(obj) {

	if (_xVLDType == 'checkbox') //checkbox
	{
		if (obj.attr('checked') == false) {
			ShowError(obj, _xVLDAlert);
			return false
		}

	}
	else if (_xVLDType == 'select-one') //selectbox
	{
		if (obj.get(0).selectedIndex == 0) {
			ShowError(obj, _xVLDAlert);
			//OBJFocus(obj);
			return false
		}

	}
	else if (_xVLDType == 'select-multiple') //multiple
	{
		var multipleValues = obj.val() || [];
		if (multipleValues.join(", ") == '') {
			ShowError(obj, _xVLDAlert);
			//OBJFocus(obj);
			return false
		}
	}
	else //khac
	{
		if (obj.val() == '') {
			ShowError(obj, _xVLDAlert);
			//OBJFocus(obj);
			return false
		}
	}

	return true;
}


function OBJEmail(obj) {
	if (obj.val() != '') {
		if (isValidEmailAddress(obj.val()) == false) {
			if (typeof _xVLDReAlert == 'undefined') {
				ShowError(obj, _xVLDAlert)
			}
			else {
				ShowError(obj, _xVLDReAlert)
			}
			//OBJFocus(obj);
			return false;
		}
	}
	return true;
}


function OBJExtFile(obj){
	vl =obj.val(); 
	if (vl!=''){

		var xValueArr=vl.split(".");
		var xExtFile=xValueArr[xValueArr.length-1].toLowerCase();		
		var xAcceptArr = obj.attr('accept').split(",");
		for (i=0;i<xAcceptArr.length ;i++ )
		{
			if (xAcceptArr[i].toLowerCase()==xExtFile){return true;i=xAcceptArr.length}
		}
		if (typeof _xVLDReAlert == 'undefined') {ShowError(obj, _xVLDAlert)}
		else {ShowError(obj, _xVLDReAlert)}
		OBJFocus(obj);
		return false;	
	}
   return true;
}


function sortObj(arr) {
	// Setup Arrays
	var sortedKeys = new Array();
	var j = 0;
	for (var i in arr) {
		sortedKeys[j] = i;
		j++;
	}
	sortedKeys.sort();
	var tmp = new Array();
	j = 0;
	for (var i in sortedKeys) {
		tmp[j] = arr[sortedKeys[i]];
		j++;
	}
	return tmp;
}

function OBJFocus(obj) {
	obj.focus();
}


function ShowError(obj, txt) {
	//obj.attr('style','background-color:#CCCCCC')
	alert(txt)
	obj.focus();
}

function isValidEmailAddress(emailAddress) {
	var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
	return pattern.test(emailAddress);
}




//==============Site=============================================//

	function message(msg,_timeout){
		if (msg=='')
		{msg='Thông tin đang được xử lý.'
		}
		var updateSuccess = {
			timeout: 3,
			className: 'achtungSuccess',
			icon: 'ui-icon-check'
		};
		var updateFail = {
			timeout: 3,
			className: 'achtungFail',
			icon: 'ui-icon-check'
		};


		var preload = $.achtung(updateSuccess, {message: msg,timeout:_timeout});
		return preload;
	}

	function hths_close(){
		$('#preview_info').html('')
		$.hbox.HBClose();
	}

	function shPanel(id)
	{	
		var arr = $(id).attr('style').split(';');
		var st = '';
		for (i=0;i<arr.length ;i++ )
		{
			if(arr[i].indexOf('display:')>=0){
				
				st	=	 arr[i];
				i	=	arr.length;
			}
		}
		if (st=='display:')
		{
			$(id).attr('style','display:none')
		}else{
			$(id).attr('style','display:')
		}
		
		/*alert(id)
		alert($(''+id).attr(display))*/
	}

	function fnc_valid(_obj,vl,txt){
		if (txt==''){txt = 'Vui lòng nhập thông tin';}
		var _objvl = _obj.val();
		if (_objvl==vl)
		{
			alert(txt);
			_obj.focus();
			return false;
		}
		return true;
	}

	function sys_per(txt){
		if (txt==-1){txt = 'Bạn không có quyền truy cập vào trang này';}
		alert(txt);
	}
//==============================================================//
