<?php
if(!defined('TSEntry') || !TSEntry) die('Not A Valid Entry Point');
?>
<!-- BEGIN: LEFT COLUMN -->
 <style>
/* Base Styles */
#cssmenu, #cssmenu ul, #cssmenu li, #cssmenu a {
    border: 0 none;
    font-family: 'Open Sans',sans-serif;
    font-size: 14px;
    font-weight: normal;
    line-height: 1;
    list-style: none outside none;
    margin: 0;
    padding: 0;
    position: relative;
    text-decoration: none;
}
#cssmenu a {
    line-height: 1.3;
}
#cssmenu {
    width: 250px;
}
#cssmenu > ul > li > a {
    background: none repeat scroll 0 0 #2188d7;
    border-bottom: 1px solid #13507f;
    color: #ffffff;
    display: block;
    font-size: 25px;
    font-weight: bold;
    padding-right: 40px;
    text-transform: uppercase;
}
#cssmenu > ul > li > a > span {
    background: none repeat scroll 0 0 #48a0e3;
    display: block;
    font-size: 13px;
    font-weight: 300;
    padding: 10px;
}
#cssmenu > ul > li > a:hover {
    text-decoration: none;
}
#cssmenu > ul > li.active {
    border-bottom: medium none;
}
#cssmenu > ul > li.active > a {
    color: #fff;
}
#cssmenu > ul > li.active > a span {
    background: none repeat scroll 0 0 #2188d7;
}
#cssmenu span.cnt {
    background: none repeat scroll 0 0 rgba(0, 0, 0, 0);
    margin: 0;
    padding: 0;
    position: absolute;
    right: 15px;
    top: 8px;
}
#cssmenu ul ul {
    display: none;
}
#cssmenu ul ul li {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    border-color: -moz-use-text-color #e0e0e0 #e0e0e0;
    border-image: none;
    border-right: 1px solid #e0e0e0;
    border-style: none solid solid;
    border-width: 0 1px 1px;
}
#cssmenu ul ul a {
    color: #5b5c64;
    display: block;
    font-size: 13px;
    padding: 10px;
}
#cssmenu ul ul a:hover {
    color: #4389d8;
}
#cssmenu ul ul li.odd {
    background: none repeat scroll 0 0 #f4f4f4;
}
#cssmenu ul ul li.even {
    background: none repeat scroll 0 0 #fff;
}

 </style>
 <script>
 ( function( $ ) {
$( document ).ready(function() {
$(document).ready(function(){

$('#cssmenu > ul > li ul').each(function(index, e){
  var count = $(e).find('li').length;
  var content = '<span class=\"cnt\">' + count + '</span>';
  $(e).closest('li').children('a').append(content);
});
$('#cssmenu ul ul li:odd').addClass('odd');
$('#cssmenu ul ul li:even').addClass('even');
$('#cssmenu > ul > li > a').click(function() {
  $('#cssmenu li').removeClass('active');
  $(this).closest('li').addClass('active');	
  var checkElement = $(this).next();
  if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
    $(this).closest('li').removeClass('active');
    checkElement.slideUp('normal');
  }
  if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
    $('#cssmenu ul ul:visible').slideUp('normal');
    checkElement.slideDown('normal');
  }
  if($(this).closest('li').find('ul').children().length == 0) {
    return true;
  } else {
    return false;	
  }		
});

});

});
} )( jQuery );

</script>
		
		
		
		<div id="ja-col1">


		<div id='cssmenu'>
<ul>
        <li><a title="TRANG CHỦ"  href="http://www.ngoaithankinh.com.vn/"><span class="nav-active">TRANG CHỦ</span></a>
        </li>
        <li class="havechild active"><a title="Giới thiệu hiệp hội" href="/vi/gioi-thieu-hiep-hoi.html"><span >Giới thiệu hiệp hội</span></a>
            <ul  class="active">
                <li><a title="Lịch sử hình thành hiệp hội" id="menu74" class=" first-item" href="/vi/gioi-thieu-hiep-hoi/lich-su-hinh-thanh-hiep-hoi.html"><span>Lịch sử hình thành hiệp hội</span></a>
                </li>
                <li><a title="Cơ cấu tổ chức" id="menu75" href="/vi/gioi-thieu-hiep-hoi/co-cau-to-chuc.html"><span class="menu-title">Cơ cấu tổ chức</span></a>
                </li>
                <li><a title="Mạng lưới - thần kinh" id="menu76" class=" last-item" href="/vi/gioi-thieu-hiep-hoi/mang-luoi-than-kinh.html"><span class="menu-title">Mạng lưới - thần kinh</span></a>
                </li>
            </ul>
        </li>
        <li class="havechild"><a title="Tin tức sự kiện" id="menu53" class="menu-item2" href="/vi/tin-tuc-su-kien.html"><span class="menu-title">Tin tức sự kiện</span></a>
            <ul>
                <li><a title="Trong nước" id="menu77" class=" first-item" href="/vi/tin-tuc-su-kien/trong-nuoc.html"><span class="menu-title">Trong nước</span></a>
                </li>
                <li><a title="Quốc tế" id="menu78" href="/vi/tin-tuc-su-kien/quoc-te.html"><span class="menu-title">Quốc tế</span></a>
                </li>
                <li><a title="Thông tin hội nghị" id="menu79" class=" last-item" href="/vi/tin-tuc-su-kien/thong-tin-hoi-nghi.html"><span class="menu-title">Thông tin hội nghị</span></a>
                </li>
            </ul>
        </li>
        <li class="havechild"><a title="Đào tạo" id="menu80" class="menu-item3" href="/vi/dao-tao.html"><span class="menu-title">Đào tạo</span></a>
            <ul>
                <li><a title="Thông tin đào tạo" id="menu81" class=" first-item" href="/vi/dao-tao/thong-tin-dao-tao.html"><span class="menu-title">Thông tin đào tạo</span></a>
                </li>
                <li><a title="Cập nhật kiến thức" id="menu82" href="/vi/dao-tao/cap-nhat-kien-thuc.html"><span class="menu-title">Cập nhật kiến thức</span></a>
                </li>
                <li><a title="Journal Club" id="menu83" class=" last-item" href="/vi/dao-tao/journal-club.html"><span class="menu-title">Journal Club</span></a>
                </li>
            </ul>
        </li>
        <li class="havechild"><a title="Sức khỏe cộng đồng" id="menu84" class="menu-item4" href="/vi/suc-khoe-cong-dong.html"><span class="menu-title">Sức khỏe cộng đồng</span></a>
            <ul>
                <li><a title="Hỏi đáp" id="menu85" class=" first-item" href="/vi/suc-khoe-cong-dong/hoi-dap.html"><span class="menu-title">Hỏi đáp</span></a>
                </li>
                <li><a title="Bài viết" id="menu86" class=" last-item" href="/vi/suc-khoe-cong-dong/bai-viet.html"><span class="menu-title">Bài viết</span></a>
                </li>
            </ul>
        </li>
        <li><a title="Liên hệ" id="menu87" class="menu-item5 last-item" href="/vi/lien-he.html"><span class="menu-title">Liên hệ</span></a>
        </li>
    </ul>
</div>
		<div class="ja-innerpad">
			<div class="module">
			<div>
				<div>
					<div>
													<h3>Support Online</h3>
											<div align="center">
				<div><a href="ymsgr:sendIM?sundbeez">
				<img title="" alt="" src="" border="0">
				</a>
				</div>
								<div>SundBeez </div>
				</div>

					</div>
				</div>
			</div>
		</div>
			<div class="module">
			<div>
				<div>
					<div>
													<h3>Who's Online</h3>
											 We have&nbsp;11 guests&nbsp;online					</div>
				</div>
			</div>
		</div>
			<div class="module">
			<div>
				<div>
					<div>
													<h3>Link</h3>
											
<center>

<select name="SltWebkhoa" onchange="ClickToURL(this.value);" size="1">
<option selected="selected" value="0">--- Website Links --- </option>

		<option value="http://cns.org">CNS</option>
		<option value="http://aans.org">ANNS</option>
		<option value="http://wfns.org">WFNS</option>
		<option value="http://asiancns.org">ASIA CNS</option>
</select>
</center>					</div>
				</div>
			</div>
		</div>
			<div class="module">
			<div>
				<div>
					<div>
													<h3>Visit Counter </h3>
											<div><div style="text-align: center;"><img src="http://www.ngoaithankinh.com.vn/modules/mod_vvisit_counter/images/mechanical/0.gif" alt="mod_vvisit_counter" /><img src="http://www.ngoaithankinh.com.vn/modules/mod_vvisit_counter/images/mechanical/2.gif" alt="mod_vvisit_counter" /><img src="http://www.ngoaithankinh.com.vn/modules/mod_vvisit_counter/images/mechanical/4.gif" alt="mod_vvisit_counter" /><img src="http://www.ngoaithankinh.com.vn/modules/mod_vvisit_counter/images/mechanical/0.gif" alt="mod_vvisit_counter" /><img src="http://www.ngoaithankinh.com.vn/modules/mod_vvisit_counter/images/mechanical/3.gif" alt="mod_vvisit_counter" /><img src="http://www.ngoaithankinh.com.vn/modules/mod_vvisit_counter/images/mechanical/3.gif" alt="mod_vvisit_counter" /><img src="http://www.ngoaithankinh.com.vn/modules/mod_vvisit_counter/images/mechanical/5.gif" alt="mod_vvisit_counter" /></div><div><table cellpadding="0" cellspacing="0" style="text-align: center; width: 90%;" class="vinaora_counter"><tbody align="center"></tbody></table></div></div>					</div>
				</div>
			</div>
		</div>
	

		</div>
		</div><br />
		<!-- END: LEFT COLUMN -->