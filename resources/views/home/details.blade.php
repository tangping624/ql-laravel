<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<meta name="format-detection" content="telephone=no" />
<title>麒麟文化--购物详细</title>
<link rel="stylesheet" type="text/css" href="{{ asset('home/css/base.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('home/css/index.css') }}"/>
<script type="text/javascript" src="{{ asset('home/js/jquery-1.9.1.js') }}"></script>
</head>
<body>
  <!--header S-->
  <header>
     <div class="Head">
        <a class="top-back" href="javascript:history.back(-1);"></a>
        <div class="Hcon">
          <h1>商家详细</h1>
       </div>
       <!-- <a class="top-share Jshare" href="javascript:;"></a>
       <a class="top-star" href="javascript:;"></a> -->
     </div>
  </header>
  <!--header E-->
  <div class="padt1">
     <ul class="prolist1 nobg">
        <li class="nobd">
             <div class="img fd-locate"><a href="#"><span><img src="{{ asset('home/ImgUpload/img6660.jpg') }}" /></span><div class="imgnum">65张</div></a></div>
             <div class="info">
                 <h3>{{ $details->name }}</h3>
                <!--  <div class="com">
                    <span class="star"><label style="width:60%"></label></span>
                    <span style="font-size:14px;">联系电话：15527651204</span> 
                 </div> -->
                 <div class="about clearfix">
                    <!-- <span class="fd-left">商家电话：15527651204</span> -->
                    <a class="fd-right btn-intro" href="Travelroutelist.html">查看详细<s></s></a>
                 </div>
             </div>
          </li>
       </ul>
       <div class="DetItem bg-white">
         <a href="#">
            <div class="site"><em><img src="{{ asset('home/images/location.png') }}" /></em><span class="black">{{ $details->address }}</span></div>
         </a>
      </div>
      <div class="DetItem bg-white">
         <a href="#">
            <div class="site"><em><img src="{{ asset('home/images/phone.png') }}" /></em><span class="black">{{ $details->telephone }} </span></div>
         </a>
      </div>
      <!-- <div class="Detbox">
         <div class="tit"><s></s><b>商家优惠</b></div>
         <div class="DetItem">
             <a href="Shopcoupon.html" class="clearfix">
                <div class="icon"><img src="../home/images/gift.png" /></div>
                <div class="state">使用手机APP领取商店优惠券，享立减十元优惠</div>
             </a>
          </div>
     </div> -->
      
      <!-- <div class="mart1 bg-white">
          <div class="DetItem">
             <a href="#" class="clearfix">
                <div class="dt fd-left">
                   <b class="black">评论</b><span class="fs24 gray">（1136条评论）</span>
                </div>
                <div class="dd fd-right"><span class="star"><label style="width:100%"></label></span></div>
             </a>
          </div>
     </div> -->
     
     <div class="Detbox">
         <div class="tit borb1"><s></s><b>商家介绍</b><span class="fs24 gray"></span></div>
         <div class="prolist1 smallImg">
            <p style="font-size:16px;font-family: STHeiti,Microsoft YaHei,Helvetica,Arial,sans-serif;letter-spacing: 2px;padding:10px 0px;text-indent:30px;line-height:20px;">{!! $details->description !!}</p>

            <!-- <li>
              <a href="Shopdetail.html">
                 <div class="img"><span><img src="{{ asset('home/ImgUpload/img6661.jpg') }}" /></span></div>
                 <div class="info">
                     <h3>塞浦路斯瑚玛娜婴儿奶粉</h3>
                     <div class="com">
                        <span class="star"><label style="width:100%"></label></span>
                        <span>5分</span> <s></s> <span>1335条评论</span>
                     </div>
                     <div class="about">
                        <span>距离商家2.5km</span>
                     </div>
                 </div>
              </a>
            </li>
            <li>
              <a href="Shopdetail.html">
                 <div class="img"><span><img src="{{ asset('home/ImgUpload/img6662.jpg') }}" /></span></div>
                 <div class="info">
                     <h3>法国珠宝品牌万宝龙珠宝专柜</h3>
                     <div class="com">
                        <span class="star"><label style="width:80%"></label></span>
                        <span>4分</span> <s></s> <span>1335条评论</span>
                     </div>
                     <div class="about">
                        <span>距离商家2.5km</span>
                     </div>
                 </div>
              </a>
            </li> -->
          </div>
          </div>
        <div class="Detbox">
          <div class="tit borb1"><s></s><b>商家提醒</b><span class="fs24 gray"></span></div>
         <div class="prolist1 smallImg">
             <p style="font-size:16px;font-family: STHeiti,Microsoft YaHei,Helvetica,Arial,sans-serif;letter-spacing: 2px;padding:10px 0px;text-indent:30px;line-height:20px;">
             {{ $details->attention }}
             </p>
         </div>
     </div>
     
     


  <!--分享弹框 S-->
  <div class="Pshare" style="display:none">
      <div class="mask"></div>
      <div class="sharebox">
          <h2>分享到</h2>
          <ul class="clearfix">
             <li><a href="#"><img src="{{ asset('home/images/weixin.png') }}" /></a></li>
             <li><a href="#"><img src="{{ asset('home/images/blog.png') }}" /></a></li>
             <li><a href="#"><img src="{{ asset('home/images/qq.png') }}" /></a></li>
             <li><a href="#"><img src="{{ asset('home/images/more.png') }}" /></a></li>
          </ul>
      </div>
  </div>
  <!--分享弹框 E-->

<script type="text/javascript">
  $(function(){
     $(".Jshare").click(function(){
	    $(".Pshare").show()
		$("body,html").css({"overflow":"hidden"});
	 })
	 $(".mask").click(function(){
	    $(".Pshare").hide()
		$("body,html").css({"overflow":"auto"});
	 })
  })
</script>

</body>
</html>
