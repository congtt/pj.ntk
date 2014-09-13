<?if(!defined('TSEntry') || !TSEntry) die('Not A Valid Entry Point');
if ($_SESSION[_PLATFORM_]['FRM_INPUT']==''){
	$_SESSION[_PLATFORM_]['FRM_INPUT'] = time();
}
//==HTML Form====================================================//	
   
    function startForm($action = '#', $method = 'post', $id = NULL, $attr_ar = array() ) { 
        $str = "<form action=\"$action\" method=\"$method\""; 
        if ( isset($id) ) { 
            $str .= " id=\"$id\" name=\"$id\"  "; 
        } 
        $str .= $attr_ar? $this->addAttributes( $attr_ar ) . '>': '>'; 
        return $str; 
    } 
     
    function addAttributes( $attr_ar ) { 
        $str = ''; 
        // check minimized attributes 
        $min_atts = array('checked', 'disabled', 'readonly', 'multiple'); 
		$tmp='';
        foreach( $attr_ar as $key=>$val ) { 
			if ($key=='defined')
				$tmp =$val;
			else
			{		
			    if ( in_array($key, $min_atts) ) { 
	                if ( !empty($val) && $key!='defined' ) {  
	                    $str .= " $key=\"$key\""; 
	                } 
	            } else { 
					$str .= " $key=\"$val\""; 	
		        } 
			}
        } 
        return $str.$tmp; 
    } 
     
    function addInput($type, $name, $value, $attr_ar = array(),$OBJ) { 

		if (trim($value)=='')
		{
			$value = $_POST[$name];
		}	
	
        $str = "<input type=\"$type\" name=\"$name\" id=\"$name\" value=\"$value\""; 
        if ($attr_ar) { 
            $str .= addAttributes( $attr_ar ); 
        } 
        $str .= ' />'; 
		
		$OBJ->assign('_'.$name,$str);
        return $str; 
    } 
	
    function addInput2($type, $name, $value, $attr_ar = array(),$OBJ,$df_val) { 

		if (trim($value)=='')
		{
			$value = $_POST[$name];
		}	
		if ($df_val!='') {$value = $df_val;}
		
        $str = "<input type=\"$type\" name=\"$name\" id=\"$name\" value=\"$value\""; 
        if ($attr_ar) { 
            $str .= addAttributes( $attr_ar ); 
        } 
        $str .= ' />'; 
		$OBJ->assign('_'.$name,$str);
        return $str; 
    }  

  
    function addTextarea($name, $rows = 4, $cols = 30, $value = '', $attr_ar = array(),$OBJ ) { 
        $str = "<textarea name=\"$name\" rows=\"$rows\" cols=\"$cols\""; 
        if ($attr_ar) { 
            $str .= addAttributes( $attr_ar ); 
        } 
        $str .= ">$value</textarea>"; 
		$OBJ->assign('_'.$name,$str);
        return $str; 
    } 
     
    // for attribute refers to id of associated form element 
    function addLabelFor($forID, $text, $attr_ar = array() ) { 
        $str = "<label for=\"$forID\""; 
        if ($attr_ar) { 
            $str .= addAttributes( $attr_ar ); 
        } 
        $str .= ">$text</label>"; 
        return $str; 
    } 
     
    // from parallel arrays for option values and text 
    function addSelectListArrays($name, $val_list, $txt_list, $selected_value = NULL, $header = NULL, $attr_ar = array() ) { 
        $option_list = array_combine( $val_list, $txt_list ); 
        $str = $this->addSelectList($name, $option_list, true, $selected_value, $header, $attr_ar ); 
        return $str; 
    } 
     
    // option values and text come from one array (can be assoc) 
    // $bVal false if text serves as value (no value attr) 
     function addSelectList($name, $option_list,  $header = NULL, $attr_ar = array(),$OBJ) { 
        $str = "<select name=\"$name\" id=\"$name\" "; 
        if ($attr_ar) { 
            $str .= addAttributes( $attr_ar ); 
        } 
        $str .= ">\n"; 
        if ( isset($header) ) { 
            $str .= "  <option value=\"\">$header</option>\n"; 
        } 
        foreach ( $option_list as $val => $text ) { 
            $str .= "<option value=\"$val\""; 
            if ( isset($_POST[$name]) && ( trim($_POST[$name]) === trim($val) || trim($_POST[$name]) === trim($text)  ) ) { 
                $str .= ' selected '; 
            } 
            $str .= ">$text</option>\n"; 
        } 
        $str .= "</select>"; 
		$OBJ->assign('_'.$name,$str);
        return $str; 
    } 
     
    // option values and text come from one array (can be assoc) 
    // $bVal false if text serves as value (no value attr) 
     function addSelectList2($name, $option_list,  $header = NULL, $attr_ar = array(),$OBJ,$slted = NULL) { 
        $str = "<select name=\"$name\" id=\"$name\" "; 
        if ($attr_ar) { 
            $str .= addAttributes( $attr_ar ); 
        } 
        $str .= ">\n"; 
        if ( isset($header) ) { 
            $str .= "  <option value=\"\">$header</option>\n"; 
        } 
        foreach ( $option_list as $val => $text ) { 
            $str .= "<option value=\"$val\"  "; 
            if ( isset($_POST[$name]) && ( trim($_POST[$name]) === trim($val) || trim($_POST[$name]) === trim($text) ) || trim($slted) === trim($val) ) { 
                $str .= ' selected '; 
            } 
            $str .= ">$text</option>\n"; 
        } 
        $str .= "</select>"; 
		$OBJ->assign('_'.$name,$str);
        return $str; 
    } 	 
	
	 
    // option values and text come from one array (can be assoc) 
    // $bVal false if text serves as value (no value attr) 
     function addSelectList5($name, $option_list,  $header = NULL, $attr_ar = array(),$OBJ,$slted = NULL) { 
        $str = "<select name=\"$name\" id=\"$name\" "; 
        if ($attr_ar) { 
            $str .= addAttributes( $attr_ar ); 
        } 
        $str .= ">\n"; 
        if ( isset($header) ) { 
            $str .= "  <option value=\"\">$header</option>\n"; 
        } 
        foreach ( $option_list as $val => $text ) { 
			$arvl = array_values($text);
            $str .= "<option value=\"$val\"  "; 
            if ( isset($_POST[$name]) && ( trim($_POST[$name]) === trim($val) || trim($_POST[$name]) === trim($text) ) || trim($slted) === trim($val) ) { 
                $str .= ' selected '; 
            } 
            $str .= ">$arvl[0]</option>\n"; 
        } 
        $str .= "</select>"; 
		$OBJ->assign('_'.$name,$str);
        return $str; 
    }

	 
    // option values and text come from one array (can be assoc) 
    // $bVal false if text serves as value (no value attr) 
     function addSelectList3($name, $option_list,  $header = NULL, $attr_ar = array(),$OBJ,$slted = NULL) { 
        $str = "<select name=\"$name\" id=\"$name\" "; 
        if ($attr_ar) { 
            $str .= addAttributes( $attr_ar ); 
        } 
        $str .= ">\n"; 
        if ( isset($header) ) { 
            $str .= "  <option value=\"\">$header</option>\n"; 
        } 
        foreach ( $option_list as $val => $text ) { 
            $str .= "<option value=\"$val\"  "; 
            if ( isset($_POST[$name]) && ( trim($_POST[$name]) === trim($val) || trim($_POST[$name]) === trim($text) ) || trim($slted) === trim($val) ) { 
                $str .= ' selected '; 
            } 
			
			foreach($text as $keyext => $valext){
				if ($keyext>0){
					$str .= ' item'.$keyext.' = "'.$valext.'" '; 
				}
			}
			
            $str .= " >".$text[0]."</option>\n"; 
        } 
        $str .= "</select>"; 
		$OBJ->assign('_'.$name,$str);
        return $str; 
    }	 

	 
    // option values and text come from one array (can be assoc) 
    // $bVal false if text serves as value (no value attr) 
     function addSelectList4($name, $option_list,  $header = NULL, $attr_ar = array(),$OBJ,$slted = NULL) { 
        $str = "<select name=\"$name\" id=\"$name\" "; 
        if ($attr_ar) { 
            $str .= addAttributes( $attr_ar ); 
        } 
        $str .= ">\n"; 
        if ( isset($header) ) { 
            $str .= "  <option value=\"\">$header</option>\n"; 
        } 
        foreach ( $option_list as $val => $text ) { 
            $str .= "<option value=\"$val\"  "; 
            if ( isset($_POST[$name]) && ( trim($_POST[$name]) === trim($val) || trim($_POST[$name]) === trim($text) ) || trim($slted) === trim($val) ) { 
                $str .= ' selected '; 
            } 
			if (is_array($text[1])){
				foreach($text[1] as $keyext => $valext){			
						$str .= ' item'.$keyext.' = "'.$valext.'" '; 
				}
			}
			
            $str .= " >".$text[0]."</option>\n"; 
        } 
        $str .= "</select>"; 
		$OBJ->assign('_'.$name,$str);
        return $str; 
    }	

    function addSelectListMulti($name, $option_list,  $header = NULL, $attr_ar = array(),$OBJ,$vl_selected,$size=5) { 
		if (is_array($vl_selected))
			$vl_selected_arr = $vl_selected;
		else
			$vl_selected_arr = explode(",",$vl_selected);
		foreach($vl_selected_arr as $k=>$vl){
			$sl_arr[$vl] = $vl;
		}

		$str = $$name."<select name=\"$name\" id=\"$name\" multiple SIZE=\"$size\" "; 
        if ($attr_ar) { 
            $str .= addAttributes( $attr_ar ); 
        } 
        $str .= ">\n"; 
        if ( isset($header) ) { 
            $str .= "  <option value=\"\">$header</option>\n"; 
        } 
		
        foreach ( $option_list as $val => $text ) { 
            $str .= "<option value=\"$val\""; 
			
			if (array_key_exists($val, $sl_arr)){
				 $str .= ' selected="selected"'; 
			}
			
           // if ( isset($_POST[$name]) && ( trim($_POST[$name]) === trim($val) || trim($_POST[$name]) === trim($text)) || trim($vl_selected)===trim($val) ) { 
               
           // } 
            $str .= ">$text</option>\n"; 
        } 
        $str .= "</select>"; 
		$OBJ->assign('_'.$name,$str);
        return $str; 
    } 

	 
    function endForm() { 
        return "</form>"; 
    } 
     
//==END HTML Form====================================================//	

?>