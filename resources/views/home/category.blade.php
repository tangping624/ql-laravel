@extends('home.public.layouts')
@section('content')
  <div class="padt21">
     <div class="rankbox">
        <ul class="flex">
           <li class="flex_div"><a href="#"><span>区域</span><i></i></a></li>
           <li class="flex_div"><a href="#"><span>全部分类</span><i></i></a></li>
           <li class="flex_div"><a href="#"><span>智能排序</span><i></i></a></li>
        </ul>
     </div>
     <div class="mart1">
        <ul class="prolist1 Abg">
        @foreach ($merchants as $merchant) 
            <li>
              <a href="{{ route('details', ['merchant' => $merchant]) }}">
                 <div class="img"><span><img src="{{ $merchant->cover(1)->uri }}" /></span></div>
                 <div class="info">
                     <h3 >{{ $merchant->name }}</h3>
                     <!--
                     <p><i class="bg-green">中国旅行社</i></p>
                       -->
                     <div class="agent">简介:{{ $merchant->summary }}</div>
                 </div>
              </a>
            </li>
       @endforeach 
         </ul>   
     </div>
     
  </div>
  
  <!--排序 S-->
  <div class="Prank" style="display:none;">
     <div class="mask"></div>
     <div class="layer">
        <div class="conbox Pnearby" >
           <ul class="popL">  
               <li class="cur"><a href="#list1">北京市</a>
                  
               </li>
               <li><a href="#list2">尼科西亚</a></li>
               <li><a href="#list3">利马索</a></li>
               <li><a href="#list4">法马古斯塔</a></li>
               <li><a href="#list5">拉纳卡</a></li>
               <li><a href="#list6">帕福斯</a></li>
               <li><a href="#list7">凯里尼亚</a></li>
            </ul>
            <ul class="poprank popR" id="list1">
               <li><a href="#">东城区</a></li>
               <li><a href="#">西城区</a></li>
               <li><a href="#">朝阳区</a></li>
               <li><a href="#">海淀区</a></li>
               <li><a href="#">丰台区</a></li>
               <li><a href="#">石景山区</a></li>
               
            </ul>
            <ul class="poprank popR" id="list2" style="display:none;">
               <li><a href="#">坎布里亚郡</a></li>
               <li><a href="#">兰开夏郡</a></li>
               <li><a href="#">默西塞德</a></li>
               <li><a href="#">大曼彻斯特</a></li>
               <li><a href="#">柴郡</a></li>
               <li><a href="#">泰恩-威尔</a></li>
            </ul>
            <ul class="poprank popR" id="list3" style="display:none;">
               <li><a href="#">达勒姆</a></li>
               <li><a href="#">北约克郡</a></li>
               <li><a href="#">西约克郡</a></li>
               <li><a href="#">南约克郡</a></li>
               <li><a href="#">林肯郡</a></li>
               <li><a href="#">诺丁汉郡</a></li>
            </ul>
            <ul class="poprank popR" id="list4" style="display:none;">
               <li><a href="#">莱斯特郡</a></li>
               <li><a href="#">北安普敦郡</a></li>
               <li><a href="#">斯塔福德郡 </a></li>
               <li><a href="#">西米德兰</a></li>
               <li><a href="#">沃里克郡</a></li>
               <li><a href="#">什罗普郡</a></li>
            </ul>
            <ul class="poprank popR" id="list5" style="display:none;">
               <li><a href="#">伍斯特郡</a></li>
               <li><a href="#">诺福克郡</a></li>
               <li><a href="#">萨福克郡 </a></li>
               <li><a href="#">剑桥郡</a></li>
               <li><a href="#">埃塞克斯郡</a></li>
               <li><a href="#">贝德福德郡</a></li>
            </ul>
            <ul class="poprank popR" id="list6" style="display:none;">
               <li><a href="#">赫特福德郡 </a></li>
               <li><a href="#">牛津郡</a></li>
               <li><a href="#">萨里郡 </a></li>
               <li><a href="#">汉普郡</a></li>
               <li><a href="#">西萨塞克斯郡</a></li>
               <li><a href="#">洛斯特郡</a></li>
            </ul>
        </div>
        <div class="conbox" style="display:none;">
           <ul class="poprank">
               <li><a href="#">本地旅行社</a></li>
               <li><a href="#">中国旅行社</a></li>
               <li><a href="#">导游</a></li>
            </ul>

        </div>
        <div class="conbox" style="display:none">
            <ul class="poprank">
               <li><a href="#">价格最低</a></li>
               <li><a href="#">推荐最多</a></li>
            </ul>
        </div>
     </div>
  </div>
  <!--排序 E-->
@endsection

@section('js')
<script type="text/javascript">
    TouchSlide({ 
        slideCell:"#picScroll2",
        titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
        autoPage:true, //自动分页
        
    });
   $(function(){
      $(".rankbox li").click(function(){
	    $(this).addClass("cur").siblings().removeClass("cur")
		  $(".Prank").show();
		  $(".layer").children().hide()
		  $(".layer").children().eq($(this).index()).show()
		  $("body,html").css({"overflow":"hidden"});
	  })
	  $(".poprank li").click(function(){
		 $(this).addClass("cur").siblings().removeClass("cur");
    
		 $(".Prank").hide()
		 $(".rankbox li").eq($(this).parent().parent().index()).find("span").html($(this).find("a").html())
		 $(".rankbox li").eq($(this).parent().parent().index()).removeClass("cur")
		 $("body,html").css({"overflow":"auto"});
	  })
	  $(".mask").click(function(){
	    $(".Prank").hide()
		$(".rankbox li").removeClass("cur")
		$("body,html").css({"overflow":"auto"});
	  })
	  $(".popL li").click(function(){
	    $(this).addClass("cur").siblings().removeClass("cur");
       $($(this).find("a").attr("href")).show().siblings(".poprank").hide();
	  })
   })
</script>
@endsection
