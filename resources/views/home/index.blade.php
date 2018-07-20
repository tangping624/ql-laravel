<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
  <meta name="apple-mobile-web-app-capable" content="yes"/>
  <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
  <meta name="format-detection" content="telephone=no"/>
  <title>麒麟文化--首页</title>
  <link rel="stylesheet" type="text/css" href="/s/css/base.css"/>
  <link rel="stylesheet" type="text/css" href="/s/css/index.css"/>
  <link rel='stylesheet' type="text/css" href='/s/css/swiper.min.css'>
  <!-- <link rel="stylesheet" href="css/based.css" /> -->
  <link rel="stylesheet" href="/s/css/demo.css"/>
  <!-- <link rel="stylesheet" type="text/css" href="css/default.css"> -->
  <link rel="stylesheet" href="/s/css/osSlider.css"/>
  <script type="text/javascript" src="/s/js/jquery-1.9.1.js"></script>

  <script type="text/javascript" src="/s/js/TouchSlide.1.1.js"></script>
  <!--<script type="text/javascript" src="js/idangerous.swiper.min.js"></script>-->
  <!--改动1-->
  <script type="text/javascript" src="http://cdn.bootcss.com/Swiper/3.4.2/js/swiper.min.js"></script>
  <!--改动1 end-->
  <script src="/s/js/osSlider.js"></script>
  <!-- <script src="js/jquery-2.1.1.min.js" type="text/javascript"></script> -->
  <!--改动2-->
  <style type="text/css">
    body {
      background: #f0f0f0 !important;
    }

    .copyright {
      visibility: hidden;
      text-align: center
    }

    .copyright a {
      font-size: 10px;
      color: #ccc;
      height: 30px;
      line-height: 30px;
    }

    .info p {
      text-overflow: -o-ellipsis-lastline;
      overflow: hidden;
      text-overflow: ellipsis;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
    }

    .prolist11 li .info {
      border-bottom: 1px solid #e6e6e6;
    }

    /*.actybox{background:-webkit-linear-gradient(rgb(246,226,196), rgb(230,187,124));padding:3% 0;margin-top:0px;}*/
    .actybox {
      background: none;
      padding: 0;
    }

    .actybox li {
      background: #fff;
    }

    /*.myAdvert{margin: 3% 1.75% 0 1.75%;height: 9.2rem}*/
    .myAdvert {
      margin: 3% 0 0 0;
      height: auto;
    }

    .iconBox {
      display: block;
      background: #fff;
      text-align: center;
      height: auto;
    }

    .leftAd {
      margin-right: 3px;
      height: 100%;
    }

    .leftAd .img {
      height: 100%;
    }

    .leftAd .img img {
      width: 100%;
      height: 100%;
    }

    .rightAd .img img {
      height: 100%;
      width: 100%;
    }

    .rightAd .img {
      height: 100%;
    }

    .rightAd .iconBox { /*height:4.5rem*/
    }

    .actybox li .img {
      height: 100%;
      padding: 0;
    }

    .actybox li img {
      width: 100%;
      height: 100%;
    }

    .add_top {
      width: 30px;
      height: 30px;
      position: fixed;
      bottom: 65px;
      right: 15px;
      background-color: #fff;
      border: 1px solid #e6e6e6;
      z-index: 100;
      border-radius: 50%;
      display: none;
      box-shadow: 0 0 5px #111;
    }

    .add_top img {
      width: 15px;
      height: 15px;
      position: relative;
      top: 8px;
      left: 8px;
    }

    #more {
      width: 100%;
      height: 40px;
      line-height: 40px;
      text-align: center;
      display: none;
    }

    .kong {
      padding: 50px 0;
    }

    .actybox li.fore2 {
      margin: 0 2%;
    }

    #loading img {
      width: 20px;
      margin-top: 20px;
      padding-bottom: 1000px;
    }

    #LoadMore {
      margin: 20px 0;
    }

    #LoadMore img {
      width: 20px;
    }

    .ho_loading {
      width: 100%;
      height: 100px;
      text-align: center;
      padding-top: 45px;
      background: #f0f0f0;
    }

    .actybox li {
      margin-left: 0;
      width: 32%;
    }

    .navfix li {
      width: 33%;
      z-index: 105;
    }

    .swiper-pagination-bullet-active {
      background: #f47920;
    }
  .slider{
    width: 100%;
    height: 120px;
  }
  .slider img {
    width: 100%;
    height: 100%;
    display: block;
  }

    /*.slider-main img{width:100%;height:6.3rem!important;}*/
  </style>
  <!--改动2 end-->
</head>
<body>
<!--header S-->
<header class="bg-org">
  <div class="Head">
    <div class="idxHead clearfix">
      <a class="HLocation fd-left" href="Citychange.html"><span>尼科西亚</span><em></em></a>
      <div class="Hsearbox"><em></em><a href="Search.html">搜索</a></div>
    </div>

    <a href="Notice.html" class="top-message"></a>
  </div>
</header>
<!--header E-->
<div class="padt1 padb1">
  <!-- nav S-->
  <nav>
    <div id="picScroll" class="navbox">
      <div class="hd">
        <ul></ul>
      </div>
      <div class="bd">
        @foreach ($cates->chunk(10) as $chunk)
          <ul>
            @foreach ($chunk as $cate)
              <li>
                <a href="{{ route('category', ['catePath' => $cate->path]) }}">
                  <div class="idxicon"><img src="{{ asset($cate->icon()) }}"/></div>
                  <p>{{ $cate->name }}</p>
                </a>
              </li>
            @endforeach
          </ul>
        @endforeach
        <!--
        <ul>
          <li><a href="Bkindex.html">
            <div class="idxicon"><img src="images/idxIcon1.png"/></div>
            <p>百科</p></a></li>
          <li><a href="jingdian.html">
            <div class="idxicon"><img src="images/jingdian.png"/></div>
            <p>旅游</p></a></li>
          <li><a href="Yiminlist.html">
            <div class="idxicon"><img src="images/yimin.png"/></div>
            <p>移民</p></a></li>
          <li><a href="Tesefw.html">
            <div class="idxicon"><img src="images/idxIcon14.png"/></div>
            <p>服务</p></a></li>
          <li><a href="touzi.html">
            <div class="idxicon"><img src="images/idxIcon140.png"/></div>
            <p>投资</p></a></li>
          <li><a href="jiaoyu.html">
            <div class="idxicon"><img src="images/idxIcon3.png"/></div>
            <p>教育培训</p></a></li>
          <li><a href="xiecheng.html">
            <div class="idxicon"><img src="images/idxIcon50.png"/></div>
            <p>携程</p></a></li>
          <li><a href="Tesexm.html">
            <div class="idxicon"><img src="images/idxIcon2.png"/></div>
            <p>房产</p></a></li>
          <li><a href="techan.html">
            <div class="idxicon"><img src="images/idxIcon9.png"/></div>
            <p>特产</p></a></li>
          <li><a href="Shopindex.html">
            <div class="idxicon"><img src="images/idxIcon20.png"/></div>
            <p>购物惠</p></a></li>
        </ul>

        <ul>
          <li><a href="Cate.html">
            <div class="idxicon"><img src="images/idxIcon8.png"/></div>
            <p>餐饮</p></a></li>
          <li><a href="xiuxian.html">
            <div class="idxicon"><img src="images/idxIcon60.png"/></div>
            <p>休闲娱乐</p></a></li>
          <li><a href="vipfw.html">
            <div class="idxicon"><img src="images/idxIcon141.png"/></div>
            <p>VIP服务</p></a></li>
          <li><a href="Lobby.html">
            <div class="idxicon"><img src="images/idxIcon12.png"/></div>
            <p>游说</p></a></li>
          <li><a href="Urgentlist.html">
            <div class="idxicon"><img src="images/idxIcon5.png"/></div>
            <p>紧急</p></a></li>
          <li><a href="Category.html">
            <div class="idxicon"><img src="images/idxIcon15.png"/></div>
            <p>全部分类</p></a></li>
        </ul>
        -->

      </div>
    </div>
    <script type="text/javascript">2
    TouchSlide({
      slideCell: "#picScroll",
      titCell: ".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
      autoPage: true, //自动分页

    });
    </script>
  </nav>
  <!-- nav E-->
  <!--idxAd S-->
  <!-- <div class="idxAd"  id="picScroll2" >
     <div class="hd" style="display:none;"><ul></ul></div>
     <div class="bd">
         <ul>
            <li><a href="/Shopintro.html"><img src="ImgUpload/idxad1.jpg" /></a></li>
            <li><a href="/Catedetail.html"><img src="ImgUpload/idxad2.jpg" /></a></li>
         </ul>
         <ul>
            <li><a href="/Shopindex.html"><img src="ImgUpload/idxad3.jpg" /></a></li>
            <li><a href="/Shopindex.html"><img src="ImgUpload/idxad4.jpg" /></a></li>
         </ul>

     </div>
  </div> -->
  <script type="text/javascript">
    TouchSlide({
      slideCell: "#picScroll2",
      titCell: ".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
      autoPage: true, //自动分页

    });
  </script>
  <!--idxAd E-->
  <!--actybox S-->
  <!--
   -->
  <div class="htmleaf-container" style="margin-top:0.55rem;">
    <!--改动3-->
    <div class="slider swiper-container">
      <div class="swiper-wrapper">
        <div class="swiper-slide"><img src="ImgUpload/idxad1.jpg" alt=""></div>
        <div class="swiper-slide"><img src="ImgUpload/idxad2.jpg" alt=""></div>
        <div class="swiper-slide"><img src="ImgUpload/idxad3.jpg" alt=""></div>
      </div>
      <div class="swiper-pagination"></div>
    </div>
    <!--改动3 end -->
  </div>
  <!--改动4 -->
  <div class="myAdvert flex">
    <div class="leftAd flex_div ">
      <a class="iconBox" href="">
        <div class="img"><img
          src="http://qlwhtest01.oss-cn-shanghai.aliyuncs.com/root/qilinmanager/merchant/39df9cb0-d23b-cce7-b476-b9fdb99423c1_orig.png">
        </div>
      </a>
    </div>
    <div class="rightAd flex_div ">
      <a class="iconBox" style="margin-bottom: 1.8%" href=""><!-- <h5>购物大优惠</h5><p>多款商品优惠放送</p> -->
        <div class="img"><img
          src="http://qlwhtest01.oss-cn-shanghai.aliyuncs.com/root/qilinmanager/merchant/39df9cb1-1d72-7c78-ec79-621f395b116d_orig.png">
        </div>
      </a>
      <a class="iconBox" href=""><!-- <h5>线路精选</h5><p>热门景点一网打尽</p> -->
        <div class="img"><img
          src="http://qlwhtest01.oss-cn-shanghai.aliyuncs.com/root/qilinmanager/merchant/39dfa2a6-54e7-3166-e822-1c9b8e42d05a_orig.png">
        </div>
      </a>
    </div>
  </div>
  <div class="actybox">
    <ul class="clearfix">
      <li class="fore1" stlye="background:#fff;"><a href=""><!-- <h5>超值折扣菜</h5><p>劲爆折扣乐享不停</p> -->
        <div class="img"><img
          src="http://qlwhtest01.oss-cn-shanghai.aliyuncs.com/root/qilinmanager/merchant/39df9cb2-ab73-120b-2f1c-60f844991d9f_orig.png">
        </div>
      </a></li>
      <li class="fore2" stlye="background:#fff;"><a href=""><!-- <h5>购物大优惠</h5><p>多款商品优惠放送</p> -->
        <div class="img"><img
          src="http://qlwhtest01.oss-cn-shanghai.aliyuncs.com/root/qilinmanager/merchant/39df9cb2-d211-ce36-132f-c95c5759ded8_orig.png">
        </div>
      </a></li>
      <li class="fore3" stlye="background:#fff;"><a href=""><!-- <h5>线路精选</h5><p>热门景点一网打尽</p> -->
        <div class="img"><img
          src="http://qlwhtest01.oss-cn-shanghai.aliyuncs.com/root/qilinmanager/merchant/39df9cb2-f893-9c4d-2000-fe064529182b_orig.png">
        </div>
      </a></li>
    </ul>
  </div>
  <!--改动4 end -->
  <!--actybox E-->
  <script type="text/javascript" src="/s/js/jquery.mCustomScrollbar.concat.min.js"></script>
  <script>
    (function ($) {
      $(window).load(function () {
        $("#ho").mCustomScrollbar({
          axis: "x",
          advanced: {autoExpandHorizontalScroll: true}
        });
        <!--改动5 -->
        new Swiper('.slider.swiper-container', {
          autoplay: 3000,
          loop: true,
          pagination: '.swiper-pagination'
        });
        <!--改动5 end -->
      });
    })(jQuery);

    //      var slider = new osSlider({ //开始创建效果
    //      pNode:'.slider', //容器的选择器 必填
    //      cNode:'.slider-main li', //轮播体的选择器 必填
    //      speed:1000, //速度 默认3000 可不填写
    //      autoPlay:true //是否自动播放 默认true 可不填写
    //  });
  </script>
  <div class="made scrollbox" id="horizontal">
    <div class="title"><s></s><b><a href="Hotel.html">商家推荐 ></a></b></div>
    <div class="madegame">
      <ul class="clearfix" id="ho">
        <li>
          <a href="Hoteldetail.html">
            <img src="ImgUpload/img3330.jpg" class="gameImg"/>
            <p>Centrum Hotel</p>
            <span>公寓式酒店，免费wifi</span>
          </a>
        </li>
        <li>
          <a href="Hoteldetail.html">
            <img src="ImgUpload/img3331.jpg" class="gameImg"/>
            <p>Amathus</p>
            <span>豪华型酒店，含早餐</span>
          </a>
        </li>
        <li>
          <a href="Hoteldetail.html">
            <img src="ImgUpload/img3332.jpg" class="gameImg"/>
            <p>中心酒店</p>
            <span>豪华型酒店，含早餐</span>
          </a>
        </li>
        <li>
          <a href="Hoteldetail.html">
            <img src="ImgUpload/img3330.jpg" class="gameImg"/>
            <p>Centrum Hotel</p>
            <span>公寓式酒店，免费wifi</span>
          </a>
        </li>
        <li>
          <a href="Hoteldetail.html">
            <img src="ImgUpload/img3331.jpg" class="gameImg"/>
            <p>Amathus</p>
            <span>豪华型酒店，含早餐</span>
          </a>
        </li>


      </ul>

    </div>
  </div>
  <!--idxRecomme S-->
  <div class="idxRecomme">
    <div class="favor-header-bar" id="sidebar">
      <ul class="tabs">
        <li class="default"><a href="javascript:void(0);" id="btn1" hidefocus="true">房产</a></li>
        <li><a href="javascript:void(0);" id="btn2" hidefocus="true">购物</a></li>
        <li><a href="javascript:void(0);" id="btn3" hidefocus="true">特产</a></li>
        <li><a href="javascript:void(0);" id="btn4" hidefocus="true">景点</a></li>
      </ul>
    </div>
    <script src="/s/js/portamento.js"></script>
    <script>$('#sidebar').portamento({disableWorkaround: true});</script>

    <div class="swiper-container favor-list">
      <div class="swiper-wrapper">
        <ul class="prolist11 swiper-slide">
          <li>
            <a href="bendicantuan.html">
              <div class="img"><span><img src="ImgUpload/f1.jpg"/></span></div>
              <div class="info">
                <h3>帕福斯 - 利马索尔 - 拉纳卡五日游</h3>
                <p>纯自由行，包接机服务，私人游艇出海，包住宿费和早餐</p>
              </div>
            </a>
          </li>
          <li>
            <a href="bendicantuan.html">
              <div class="img"><span><img src="ImgUpload/f2.jpg" width="352" height="220"/></span></div>
              <div class="info">
                <h3>萨普鲁斯 - 帕福斯三日游</h3>
                <p>纯自由行，包接机服务，私人游艇出海，包住宿费和早餐</p>
              </div>
            </a>
          </li>
          <li>
            <a href="bendicantuan.html">
              <div class="img"><span><img src="ImgUpload/f3.jpg" width="348" height="220"/></span></div>
              <div class="info">
                <h3>法马古斯塔 - 凯里尼亚 - 拉纳卡五日游</h3>
                <p>包接机服务，私人游艇出海，包住宿费和早餐</p>
              </div>
            </a>
          </li>
          <li>
            <a href="bendicantuan.html">
              <div class="img"><span><img src="ImgUpload/f4.jpg" width="329" height="220"/></span></div>
              <div class="info">
                <h3>塞浦路斯七日游</h3>
                <p>包接机服务，私人游艇出海，包住宿费和早餐，金色沙滩等</p>
              </div>
            </a>
          </li>
          <li>
            <a href="bendicantuan.html">
              <div class="img"><span><img src="ImgUpload/f5.jpg"/></span></div>
              <div class="info">
                <h3>【参团】帕福斯 - 利马索尔 - 拉纳卡五日游</h3>
                <p>纯自由行，包接机服务，私人游艇出海，包住宿费和早餐</p>
              </div>
            </a>
          </li>
          <li>
            <a href="bendicantuan.html">
              <div class="img"><span><img src="ImgUpload/f2.jpg" width="352" height="220"/></span></div>
              <div class="info">
                <h3>【参团】萨普鲁斯 - 帕福斯三日游</h3>
                <p>纯自由行，包接机服务，私人游艇出海，包住宿费和早餐</p>
              </div>
            </a>
          </li>
        </ul>
        <ul class="prolist11 swiper-slide">
          <li>
            <a href="teseyou.html">
              <div class="img"><span><img src="ImgUpload/img61.jpg" width="348" height="220"/></span></div>
              <div class="info">
                <h3>【参团】法马古斯塔 - 凯里尼亚 - 拉纳卡五日游</h3>
                <p>包接机服务，私人游艇出海，包住宿费和早餐</p>
              </div>
            </a>
          </li>
          <li>
            <a href="teseyou.html">
              <div class="img"><span><img src="ImgUpload/img71.jpg" width="329" height="220"/></span></div>
              <div class="info">
                <h3>【参团】塞浦路斯七日游</h3>
                <p>包接机服务，私人游艇出海，包住宿费和早餐，金色沙滩等</p>
              </div>
            </a>
          </li>
          <li>
            <a href="teseyou.html">
              <div class="img"><span><img src="ImgUpload/img6.jpg"/></span></div>
              <div class="info">
                <h3>【参团】帕福斯 - 利马索尔 - 拉纳卡五日游</h3>
                <p>纯自由行，包接机服务，私人游艇出海，包住宿费和早餐</p>
              </div>
            </a>
          </li>
          <li>
            <a href="teseyou.html">
              <div class="img"><span><img src="ImgUpload/img51.jpg" width="352" height="220"/></span></div>
              <div class="info">
                <h3>【参团】萨普鲁斯 - 帕福斯三日游</h3>
                <p>纯自由行，包接机服务，私人游艇出海，包住宿费和早餐</p>
              </div>
            </a>
          </li>
          <li>
            <a href="teseyou.html">
              <div class="img"><span><img src="ImgUpload/img61.jpg" width="348" height="220"/></span></div>
              <div class="info">
                <h3>【参团】法马古斯塔 - 凯里尼亚 - 拉纳卡五日游</h3>
                <p>包接机服务，私人游艇出海，包住宿费和早餐</p>
              </div>
            </a>
          </li>
          <li>
            <a href="teseyou.html">
              <div class="img"><span><img src="ImgUpload/img71.jpg" width="329" height="220"/></span></div>
              <div class="info">
                <h3>【参团】塞浦路斯七日游</h3>
                <p>包接机服务，私人游艇出海，包住宿费和早餐，金色沙滩等</p>
              </div>
            </a>
          </li>
        </ul>
        <ul class="prolist11 swiper-slide">
          <li>
            <a href="zhutiyou.html">
              <div class="img"><span><img src="ImgUpload/img6.jpg"/></span></div>
              <div class="info">
                <h3>【参团】帕福斯 - 利马索尔 - 拉纳卡五日游</h3>
                <p>纯自由行，包接机服务，私人游艇出海，包住宿费和早餐</p>
              </div>
            </a>
          </li>
          <li>
            <a href="zhutiyou.html">
              <div class="img"><span><img src="ImgUpload/img51.jpg" width="352" height="220"/></span></div>
              <div class="info">
                <h3>【参团】萨普鲁斯 - 帕福斯三日游</h3>
                <p>纯自由行，包接机服务，私人游艇出海，包住宿费和早餐</p>
              </div>
            </a>
          </li>
          <li>
            <a href="zhutiyou.html">
              <div class="img"><span><img src="ImgUpload/img61.jpg" width="348" height="220"/></span></div>
              <div class="info">
                <h3>【参团】法马古斯塔 - 凯里尼亚 - 拉纳卡五日游</h3>
                <p>包接机服务，私人游艇出海，包住宿费和早餐</p>
              </div>
            </a>
          </li>
          <li>
            <a href="zhutiyou.html">
              <div class="img"><span><img src="ImgUpload/img71.jpg" width="329" height="220"/></span></div>
              <div class="info">
                <h3>【参团】塞浦路斯七日游</h3>
                <p>包接机服务，私人游艇出海，包住宿费和早餐，金色沙滩等</p>
              </div>
            </a>
          </li>
          <li>
            <a href="zhutiyou.html">
              <div class="img"><span><img src="ImgUpload/img6.jpg"/></span></div>
              <div class="info">
                <h3>【参团】帕福斯 - 利马索尔 - 拉纳卡五日游</h3>
                <p>纯自由行，包接机服务，私人游艇出海，包住宿费和早餐</p>
              </div>
            </a>
          </li>
          <li>
            <a href="zhutiyou.html">
              <div class="img"><span><img src="ImgUpload/img51.jpg" width="352" height="220"/></span></div>
              <div class="info">
                <h3>【参团】萨普鲁斯 - 帕福斯三日游</h3>
                <p>纯自由行，包接机服务，私人游艇出海，包住宿费和早餐</p>
              </div>
            </a>
          </li>
        </ul>
        <ul class="prolist11 swiper-slide">
          <li>
            <a href="youxuan.html">
              <div class="img"><span><img src="ImgUpload/img61.jpg" width="348" height="220"/></span></div>
              <div class="info">
                <h3>【参团】法马古斯塔 - 凯里尼亚 - 拉纳卡五日游</h3>
                <p>包接机服务，私人游艇出海，包住宿费和早餐</p>
              </div>
            </a>
          </li>
          <li>
            <a href="youxuan.html">
              <div class="img"><span><img src="ImgUpload/img71.jpg" width="329" height="220"/></span></div>
              <div class="info">
                <h3>【参团】塞浦路斯七日游</h3>
                <p>包接机服务，私人游艇出海，包住宿费和早餐，金色沙滩等</p>
              </div>
            </a>
          </li>
          <li>
            <a href="youxuan.html">
              <div class="img"><span><img src="ImgUpload/img6.jpg"/></span></div>
              <div class="info">
                <h3>【参团】帕福斯 - 利马索尔 - 拉纳卡五日游</h3>
                <p>纯自由行，包接机服务，私人游艇出海，包住宿费和早餐</p>
              </div>
            </a>
          </li>
          <li>
            <a href="youxuan.html">
              <div class="img"><span><img src="ImgUpload/img51.jpg" width="352" height="220"/></span></div>
              <div class="info">
                <h3>【参团】萨普鲁斯 - 帕福斯三日游</h3>
                <p>纯自由行，包接机服务，私人游艇出海，包住宿费和早餐</p>
              </div>
            </a>
          </li>
          <li>
            <a href="youxuan.html">
              <div class="img"><span><img src="ImgUpload/img61.jpg" width="348" height="220"/></span></div>
              <div class="info">
                <h3>【参团】法马古斯塔 - 凯里尼亚 - 拉纳卡五日游</h3>
                <p>包接机服务，私人游艇出海，包住宿费和早餐</p>
              </div>
            </a>
          </li>
          <li>
            <a href="youxuan.html">
              <div class="img"><span><img src="ImgUpload/img71.jpg" width="329" height="220"/></span></div>
              <div class="info">
                <h3>【参团】塞浦路斯七日游</h3>
                <p>包接机服务，私人游艇出海，包住宿费和早餐，金色沙滩等</p>
              </div>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="loader"><em class="clip-rotate"></em>加载中...</div>
    <script>
      var mySwiper = new Swiper('.swiper-container.favor-list', {
        autoHeight: true,
        onSlideChangeStart: function () {
          $(".tabs .default").removeClass('default');
          $(".tabs li").eq(mySwiper.activeIndex).addClass('default');
//            $(".tabs li").eq(mySwiper.activeIndex).click();
        }
      });
      $(".tabs li").on('click', function (e) {
        e.preventDefault();
        $(".tabs .default").removeClass('default');
        $(this).addClass('default');
        mySwiper.swipeTo($(this).index());
      });
      $(".tabs li").click(function (e) {
        e.preventDefault();
      });
    </script>
  </div>
  <!--idxRecomme E-->
</div>
<!--<div class="copyright align-c" id="page_footer" style="opacity: 1; visibility: visible;">-->
<!--<a href="javascript:;" target="_self">Powered by cyhere</a>-->
<!--</div>-->
<!--footer S-->
<footer>
  <div class="navfix">
    <ul class="clearfix">
      <li class="F-home cur"><a href="Index.html"><em></em>
        <p>首页</p></a></li>
      <!--<li class="F-location"><a href="Nearbyjq.html"><em></em><p>附近</p></a></li>-->
      <li class="F-user"><a href="Login.html"><em></em>
        <p>我</p></a></li>
      <li class="F-more"><a href="More.html"><em></em>
        <p>更多</p></a></li>
    </ul>
  </div>
</footer>
<!--footer E-->

<script type="text/javascript">
  $(function () {
    var marL = $(".HLocation").width()
    $(".Hsearbox").css({
      "margin-left": marL,
    });
  })
</script>
</body>
</html>
