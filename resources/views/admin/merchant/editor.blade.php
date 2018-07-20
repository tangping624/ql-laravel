@extends('admin.public.layouts')

@section('css')
<style type="text/css">
.thumb {position: relative; text-align: center; width: 100%; height: 150px; background-repeat: no-repeat; background-position: 50% 50%; background-size: cover;}
#add-file .thumb {width: 100%; overflow: hidden; background-repeat: no-repeat; background-size: cover; background-color: #e3e9e6; background-image:url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAfQAAAH0AQMAAADxGE3JAAAAA3NCSVQICAjb4U/gAAAABlBMVEX///////9VfPVsAAAAAnRSTlMA/1uRIrUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAAcdEVYdFNvZnR3YXJlAEFkb2JlIEZpcmV3b3JrcyBDUzbovLKMAAAAFnRFWHRDcmVhdGlvbiBUaW1lADA1LzMwLzE3jDoW9QAAAHBJREFUeJzty7ERABAQADAbGOlXt9mruNNRIulTCgAAAAAAwDcih+b7vu/7vu/7vu/7vu/7vu/7vu/7/vGvucP3fd/3fd/3fd/3fd/3/Rv/KuZou8X3fd/3fd/3fd/3fd/3fd/3fd/3fQAAAAAAgJd0e88ZtdVd1W4AAAAASUVORK5CYII=');}
.caption {text-align: center; height: 54px; line-height: 36px;}
.thumb span {display: block; position: absolute; top: 10px; right: 10px; opacity: 0.7;}
#uploader {opacity: 0; font-size: 999px;}
.thumbnail .progress {height: 100%; width: 100%; background: #000; bottom: 0; left: 0; opacity: 0.3; position: absolute; margin: 0;}
.nav-tabs {margin-bottom: 22px;}

.image-upload {float: left; overflow: hidden; position: relative;}
.image-upload input {font-size: 999px; position: absolute; top: 0; left: 0; opacity: 0;}
.image-upload img.loading {width: auto; height: auto; margin-top: 84px;}
.image-upload .progress {height: 100%; width: 100%; background: #000; bottom: 0; left: 0; opacity: 0.3; position: absolute; margin: 0;}
.btn {margin-left: 5px;}

</style>
@endsection

@section('content')
<ul class="nav nav-tabs">
    <li{!! $inProductTab ? '' : ' class="active"' !!}><a href="#tab-info" data-toggle="tab">商户信息</a></li>
    @if ($action != 'create')
        <li><a href="#tab-images" data-toggle="tab">商户图片</a></li>
        <li{!! $inProductTab ? ' class="active"' : '' !!}><a href="#tab-products" data-toggle="tab">商户产品</a></li>
    @endif
</ul>
<div class="tab-content">
    <div class="row tab-pane{{ $inProductTab ? '' : ' active' }}" id="tab-info">
        <form id="form-info" data-id="{{ $merchant->id }}">

            <div class="col-md-12" style="margin-bottom: 22px;">
                <span class="btn btn-success cmd-save">保存</span>
            </div>

            <div class="col-md-6">
                <div class="panel panel-info">
                    <div class="panel-heading">基本信息</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label>所属栏目</label>
                                <select class="form-control" name="category_id">
                                    @if (!$merchant->category_id)
                                        <option value="0">--- 请选择 ---</option>
                                    @endif
                                    @foreach ($cates as $cate)
                                        <option value="{{ $cate->id }}"{{ $merchant->category_id == $cate->id ? ' selected' : '' }}>{{ $cate->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-8 form-group" id="cate-tags" style="display: none;">
                                <label>标签选择</label>
                                <div id="tags"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>名称</label>
                                    <input type="text" class="form-control" name="name" value="{{ $merchant->name }}" placeholder="请填写商户名称" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>联系人</label>
                                    <input type="text" class="form-control" name="contacts" value="{{ $merchant->contacts }}" placeholder="请填写联系人名称" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>联系电话</label>
                                    <input type="text" class="form-control" name="telephone" value="{{ $merchant->telephone }}" placeholder="请填写联系电话" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>传真</label>
                                    <input type="text" class="form-control" name="fax" value="{{ $merchant->fax }}" placeholder="请填写传真" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>邮件地址</label>
                                    <input type="text" class="form-control" name="email" value="{{ $merchant->email }}" placeholder="请填写邮件地址" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>地址</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="address" value="{{ $merchant->address }}" placeholder="请填写商户地址" />
                                        <span class="input-group-btn">
                                            <span class="btn btn-primary">搜索地图</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>经度</label>
                                    <input type="text" class="form-control" name="long" value="{{ $merchant->long }}" placeholder="商户所在位置经度" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>纬度</label>
                                    <input type="text" class="form-control" name="lat" value="{{ $merchant->lat }}" placeholder="商户所在位置纬度" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>简介</label>
                                    <textarea class="form-control" name="summary" rows="3" value="{{ $merchant->summary }}"></textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>特别提醒</label>
                                    <textarea class="form-control" name="attention" rows="3" value="{{ $merchant->attention }}"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label>封面1</label>
                                <div class="clearfix">
                                    <div class="image-upload">
                                        <input class="cmd-cover" type="file" name="image" accept="image/png, image/jpg, image/jpeg" />
                                        <img src="{{ asset($merchant->cover(1)->uri) }}" class="img-thumbnail" />
                                        <input type="hidden" name="cover1" value="{{ $merchant->cover(1)->id }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>封面2</label>
                                <div class="clearfix">
                                    <div class="image-upload">
                                        <input class="cmd-cover" type="file" name="image" accept="image/png, image/jpg, image/jpeg" />
                                        <img src="{{ asset($merchant->cover(2)->uri) }}" class="img-thumbnail" />
                                        <input type="hidden" name="cover2" value="{{ $merchant->cover(2)->id }}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel panel-success">
                    <div class="panel-heading">详情</div>
                    <div class="panel-body">
                        <script id="editor" name="description" type="text/plain" style="width: 100%; height: 600px;">{!! $merchant->description !!}</script>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <span class="btn btn-success pull-right cmd-save">保存</span>
            </div>
        </form>
    </div>

    <div class="row tab-pane" id="tab-images">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-heading">图片管理</div>
                <div class="panel-body">
                    <div class="row" id="images">
                        <div class="col-md-2 thumb-box" id="add-file">
                            <div class="thumbnail">
                                <div class="thumb">
                                    <input id="uploader" type="file" name="image" accept="image/png, image/jpg, image/jpeg" multiple />
                                </div>
                                <div class="caption">上传新图片</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row tab-pane{{ $inProductTab ? ' active' : '' }}" id="tab-products">
        <div class="col-md-9">
            <div class="panel panel-success">
                <div class="panel-heading">产品列表</div>
                <div class="panel-body" style="padding: 0;">
                    <iframe id="iframe-product-list" src="{{ route('admin.merchant.product.list', ['merchant' => $merchant]) }}" frameborder="no" border="0" width="100%" height="0"></iframe>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-info">
                <div class="panel-heading">
                    产品分类
                    <span class="btn btn-success btn-xs pull-right" id="cmd-tag-create">新增</span>
                </div>
                <div class="list-group" id="product-tags"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-tag" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form class="form-horizontal" id="form-tag">
                        <input type="hidden" name="image_id" value="0" />
                        <div class="col-sm-10 col-sm-offset-1">
                            <div class="form-group row">
                                <label class="col-sm-4 control-label">分类名称：</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="name" placeholder="分类名称" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 control-label">分类排序：</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="sortord" placeholder="分类排序" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 control-label">分类图标</label>
                                <div class="col-sm-6">
                                    <div class="image-upload">
                                        <input id="uploader-tag" type="file" name="image" accept="image/png, image/jpg, image/jpeg" />
                                        <img class="img-thumbnail" src="" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" style="display: none;" id="action-tag-create">保存</button>
                <button type="button" class="btn btn-success" style="display: none;" id="action-tag-save">保存</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript" charset="utf-8" src="{{ asset('/plugins/ueditor/ueditor.config.js') }}"></script>
<script type="text/javascript" charset="utf-8" src="{{ asset('/plugins/ueditor/ueditor.all.min.js') }}"> </script>
<script type="text/javascript" src="{{ asset('/js/uploader.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAjWSvQMda-0sePlrP0qsbqUXkOY1AoCmY&libraries=geometry,places&callback=initMap"
         async defer></script>
<script>
//定义变量
var placeSearch, autocomplete, map, marker;
/*
* 搜索功能
*/
function geolocate() {
	// 定义搜索范围 这里是全球
	  var defaultBounds = new google.maps.LatLngBounds(
	  new google.maps.LatLng(-90, -180),
	  new google.maps.LatLng(90, 180));

	  var input = document.getElementById('autocomplete');
	  var options = {
	    bounds: defaultBounds,
	    types: ['geocode'] // 返回类型
	  };
	
	  autocomplete = new google.maps.places.Autocomplete(input, options);
	  //window.alert(JSON.stringify(autocomplete)); 
	  autocomplete.addListener('place_changed', fillInAddress);
	  
	}
	function fillInAddress() {
	  // 选择搜索出来的结果后
	  var address = autocomplete.getPlace()
	  // 地图跳转到搜索地方
	  map.setCenter({lat:address.geometry.location.lat(),lng:address.geometry.location.lng()})
	}
                                
function lngMap() {
	//点击确定关闭弹窗
	$("#modal-map").modal('hide');
}
                                
function initMap() {
	// 初始化地图
	  map = new google.maps.Map(document.getElementById('map'), {
	    center: {lat: -34.397, lng: 150.644},
	    zoom: 8
		});
	// 监听地图点击
	  google.maps.event.addListener(map, 'click', function(e) {
	    // 获取位置坐标
	    var lng = e.latLng.lng();
	    var lat = e.latLng.lat();
	    //添加到表单框里面
        $("input[name='long']").val(lng);
	    $("input[name='lat']").val(lat);
	 // 清除点击标记
	    if (marker) marker.setMap(null);
	 // 添加点击标记，注意外部变量marker
	    marker = new google.maps.Marker({
	          position: {lng: lng, lat: lat},
	          map: map
	        });
	    //console.log(e.latLng.lat(), e.latLng.lng())
        //根据坐标获取坐标名称
	    var latlng = {lat: parseFloat(lat), lng: parseFloat(lng)};
	    var geocoder = new google.maps.Geocoder;
	          geocoder.geocode({'location': latlng}, function(results, status) {
	        	// results 当status为ok 会输出地理信息数组
	            if (status === 'OK') {
	              
	              if (results[0]) {
	                // map.setZoom(11);
	                // var marker = new google.maps.Marker({
	                //   position: latlng,
	                //   map: map
	                // });
	                //讲地理位置名称填写到地址表单中
	                $("input[name='address']").val(results[0].formatted_address);
	                //console.log(results[1].formatted_address)
	              } else {
	            	  //window.alert(results[0].formatted_address);
	            	 // window.alert(JSON.stringify(results),status);
	                window.alert('No results found');
	              }
	            } 
	          });
	  })
	}
                                
$(function () {

    // 切换 tab 时改变地址栏
    $('.nav-tabs a').click(function () {
        if ($(this).attr('href') == '#tab-products') {
            history.replaceState('', '', location.href.split('?')[0] + '?tab=product');
        } else {
            history.replaceState('', '', location.href.split('?')[0]);
        }
    });

    // 基本信息
    var cateTags = {!! json_encode($cateTags) !!},
        merchantCategoryTags = {!! $merchant->beTaggeds->pluck('id') !!},
        ue = UE.getEditor('editor', {toolbars: [[
            'fullscreen', 'undo', 'redo', '|',
            'bold', 'italic', 'underline', '|', 'forecolor', 'backcolor', '|',
            'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|',
            'simpleupload', '|',
            'searchreplace', 'drafts'
        ]], autoHeightEnabled: false});

    // 设置标签
    function setTags(cateId) {
        var tags = cateTags[cateId];

        if (tags && tags.length) {
            var html = '', i;
            for (i = 0; i < tags.length; i++) {
                if ($.inArray(tags[i].id, merchantCategoryTags) == -1) {
                    html += '<span class="btn btn-default cmd-tag-set" data-id="' + tags[i].id + '">' + tags[i].name + '</span> ';
                } else {
                    html += '<span class="btn btn-success cmd-tag-unset" data-id="' + tags[i].id + '">' + tags[i].name + '</span> ';
                }
            }
            $('#tags').html(html);
            $('#cate-tags').show();
        } else {
            $('#cate-tags').hide();
        }
    }

    setTags({{ $merchant->category_id }});

    // 栏目变动, 更换 tags
    $('[name=category_id]').change(function () {
        merchantCategoryTags = []; // 清空当前的标签选择
        setTags($(this).val());
    });

    // 设置栏目分类
    $('#cate-tags').on('click', '.cmd-tag-set', function () {
        var $this = $(this);
        merchantCategoryTags.push($this.data('id'));
        $this.removeClass('btn-default cmd-tag-set').addClass('btn-success cmd-tag-unset');
    });

    // 取消栏目分类
    $('#cate-tags').on('click', '.cmd-tag-unset', function () {
        var $this = $(this), index;
        if (-1 != (index = $.inArray($this.data('id'), merchantCategoryTags))) {
            merchantCategoryTags.splice(index, 1);
        }
        $this.addClass('btn-default cmd-tag-set').removeClass('btn-success cmd-tag-unset');
    });

    // 保存栏目
    $('.cmd-save').click(function () {
        var $form = $('#form-info'), data;

        if ($form.find('[name=category_id]').val() == 0) {
            layer.alert('请选择商户所属栏目', function (index) {
                $form.find('[name=category_id]').focus();
                layer.close(index);
            });
            return false;
        }

        if ($form.find('[name=name]').val() == 0) {
            layer.alert('请填写商户名称', function (index) {
                $form.find('[name=name]').focus();
                layer.close(index);
            });
            return false;
        }

        $.post(
            '{{ $action == 'create' ? route('admin.merchant.store', ['merchant' => $merchant]) :  route('admin.merchant.update', ['merchant' => $merchant]) }}',
            $form.serialize() + encodeURI('&tag_id[]=' + merchantCategoryTags.join('&tag_id[]=')){!! $action == 'create' ? '' : ' + \'&_method=PUT\'' !!},
            function (response) {
                if (response.status) {
                    window.location.href = '{{ route('admin.merchant.index') }}';
                }
            },
            'json'
        );
    });

    // 更换封面
    $('.cmd-cover').uploader({
        url: '{{ route('upload.image') }}',
        onAdd: function (elementId) {
            $(this).next('img').addClass('loading').attr('src', '/images/loading.gif');
        },
        onImageLoad: function (uri, elementId) {
            $(this).next('img').removeClass('loading').attr('src', uri)
                .after('<div class="progress"></div>');
        },
        onProgress: function (e) {
            var percent = parseInt(100 - (e.loaded / e.total) * 100) + '%';
            $(e.target.element).nextAll('.progress').css({height: percent});
        },
        done: function (response, elementId) {
            $(this).nextAll(':hidden').val(response.id);
        }
    });

    // 图片功能
    var thumbHeight = 100;

    // 渲染图片选项卡
    function renderImages(images) {
        var i, html = '';
        for (i = 0; i < images.length; i++) {
            html += '<div class="col-md-2 thumb-box image">';
            html +=     '<div class="thumbnail">';
            html +=         '<a href="/' + images[i].uri + '" target="_blank">';
            html +=             '<div class="thumb" style="background-image: url(/' + images[i].uri + '); height: ' + thumbHeight + 'px">';
            html +=                 '<span class="btn btn-danger glyphicon glyphicon-remove cmd-image-delete" data-id="' + images[i].id + '"></span>';
            html +=             '</div>';
            html +=         '</a>';
            html +=         '<div class="caption input-group" title="排序">';
            html +=             '<input type="text" class="form-control" value="' + images[i].sortord + '" />';
            html +=             '<span class="input-group-btn cmd-set-sortord" data-id="' + images[i].id + '">';
            html +=                 '<span class="btn btn-success">保存</span>';
            html +=             '</span>';
            html +=         '</div>';
            html +=     '</div>';
            html += '</div>';
        }

        $('#images .image').remove();
        $('#images').append(html);
    }

    renderImages({!! $merchant->rollImages()->toJson() !!});

    // 设置图片高度
    $('a[href="#tab-images"]').on('shown.bs.tab', function () {
        thumbHeight = $('.thumb').first().width();
        $('.thumb').height(thumbHeight);
    });

    // 上传图片
    $('#uploader').uploader({
        url: '{{ route('admin.merchant.image.upload', ['merchant' => $merchant]) }}',
        onAdd: function (elementId) {
            var html = '';
            html += '<div class="col-md-2 thumb-box image">';
            html +=     '<div class="thumbnail">';
            html +=         '<a href="javascript:void(0);" target="_blank">';
            html +=             '<div id="' + elementId + '" class="thumb" style="height: ' + thumbHeight + 'px">loading...</div>';
            html +=         '</a>';
            html +=         '<div class="caption">图片上传中...</div>';
            html +=     '</div>';
            html += '</div>';
            $('#images').append(html);
        },
        onImageLoad: function (uri, elementId) {
            $('#' + elementId).html('').css({backgroundImage: 'url(' + uri + ')'})
                .append('<div class="progress"></div>');
        },
        onProgress: function (e) {
            var percent = parseInt(100 - (e.loaded / e.total) * 100) + '%';
            $('#' + e.target.jqXHR.uploadElementId + ' .progress').css({height: percent});
        },
        allDone: function (response, elementId) {
            renderImages(response.images);
        }
    });

    // 删除图片
    $('#images').on('click', '.cmd-image-delete', function () {
        var $this = $(this), id = $this.data('id');
        layer.confirm('确认删除该图片？', {icon: 3, title: '提示'}, function (index) {
            $.post(
                '{{ route('admin.image.delete', ['image' => '###']) }}'.replace('###', id),
                {_method: 'DELETE'},
                function (response) {
                    if (response.status) {
                        $this.closest('.thumb-box').remove();
                        layer.close(index);
                    }
                },
                'json'
            );
        });
        return false;
    });

    // 设置图片排序
    $('#images').on('click', '.cmd-set-sortord', function () {
        var $this = $(this),
            sortord = $this.prev().val();

        if (!sortord.match(/^-?\d+$/)) {
            layer.msg('必须输入整数', {icon: 5, time: 1000});
            $this.prev().focus();
            return false;
        }

        $.post(
            '{{ route('admin.merchant.image.sortord', ['merchant' => $merchant, 'image' => '###']) }}'.replace('###', $this.data('id')),
            {_method: 'PATCH', sortord:sortord},
            function (response) {
                renderImages(response.images);
            },
            'json'
        );

        return false;
    });

    // 产品功能
    // 渲染产品分类
    function renderProductTags(tags) {
        var i, html = '';
        for (i = 0; i < tags.length; i++) {
            html += '<div class="list-group-item" data-id="' + tags[i].id + '">';
            html +=     tags[i].name;
            html +=     '<span class="btn btn-xs btn-danger pull-right cmd-product-tag-delete" title="删除"><span class="glyphicon glyphicon-remove"></span></span>';
            html +=     '<span class="btn btn-xs btn-success pull-right cmd-product-tag-show" title="显示"' + (tags[i].display ? ' style="display: none;"' : '') + '><span class="glyphicon glyphicon-eye-open"></span></span>';
            html +=     '<span class="btn btn-xs btn-warning pull-right cmd-product-tag-hide" title="隐藏"' + (tags[i].display ? '' : ' style="display: none;"') + '><span class="glyphicon glyphicon-eye-close"></span></span>';
            html +=     '<span class="btn btn-xs btn-primary pull-right cmd-product-tag-edit" title="编辑"><span class="glyphicon glyphicon-edit"></span></span>';
            html += '</div>';
        }

        if (!html) {
            html = '<div class="list-group-item">没有产品分类</div>';
        }

        $('#product-tags').empty().append(html);
    }

    renderProductTags({!! $merchant->tags()->with('images')->get()->toJson() !!});

    // 更换分类 icon
    $('#uploader-tag').uploader({
        url: '{{ route('upload.image') }}',
        imageClientProcess: true,
        targetWidth: 200,
        targetHeight: 200,
        imageRatio: 'target',
        onAdd: function (elementId) {
            $(this).next('img').addClass('loading').attr('src', '/images/loading.gif');
        },
        onImageProcess: function (uri, elementId) {
            $(this).next('img').removeClass('loading').attr('src', uri)
                .after('<div class="progress"></div>');
        },
        onProgress: function (e) {
            var percent = parseInt(100 - (e.loaded / e.total) * 100) + '%';
            $(e.target.element).nextAll('.progress').css({height: percent});
        },
        done: function (response, elementId) {
            $('#form-tag [name=image_id]').val(response.id);
        }
    });

    // 点击新建分类弹出对话框
    $('#cmd-tag-create').click(function () {
        $('#modal-tag')
            .find('.modal-title').text('添加产品分类').end()
            .find('img').attr('src', '{{ asset(config('misc.default-image')) }}').end()
            .find('[name=image_id]').val(0).end()
            .find('[name=name]').val('').end()
            .find('[name=sortord]').val(0).end()
            .find('#action-tag-create').show().end()
            .find('#action-tag-save').hide().end()
        .modal('show');
    });

    // 创建新的 tag
    $('#action-tag-create').click(function () {
        var $form = $('#form-tag');

        if (!$form.find('[name=name]').val().trim().length) {
            layer.alert('分类名称不能为空', function (index) {
                $form.find('[name=name]').focus();
                layer.close(index);
            });
            return false;
        }

        if (!$form.find('[name=sortord]').val().match(/^-?\d+$/)) {
            layer.alert('排序必须填写整数', function (index) {
                $form.find('[name=sortord]').focus();
                layer.close(index);
            });
            return false;
        }

        $.post(
            '{{ route('admin.merchant.tag.create', ['merchant' => $merchant]) }}',
            $form.serialize(),
            function (response) {
                if (response.status) {
                    $('#modal-tag').modal('hide');
                    renderProductTags(response.tags);
                }
            },
            'json'
        );
    });

    // 点击编辑按钮
    $('#product-tags').on('click', '.cmd-product-tag-edit', function () {
        var $this = $(this);

        $.get(
            '{{ route('admin.tag.detail', ['tag' => '###']) }}'.replace('###', $this.parent().data('id')),
            function (response) {
                $('#modal-tag')
                    .find('.modal-title').text('编辑产品分类').end()
                    .find('img').attr('src', response.icon).end()
                    .find('[name=image_id]').val(0).end()
                    .find('[name=name]').val(response.name).end()
                    .find('[name=sortord]').val(response.sortord).end()
                    .find('#action-tag-create').hide().end()
                    .find('#action-tag-save').show().data('id', response.id).end()
                .modal('show');
            },
            'json'
        );
    });

    // 点击保存按钮
    $('#action-tag-save').click(function () {
        var $this = $(this),
            $form = $('#form-tag');

        if (!$form.find('[name=name]').val().trim().length) {
            layer.alert('分类名称不能为空', function (index) {
                $form.find('[name=name]').focus();
                layer.close(index);
            });
            return false;
        }

        if (!$form.find('[name=sortord]').val().match(/^-?\d+$/)) {
            layer.alert('排序必须填写整数', function (index) {
                $form.find('[name=sortord]').focus();
                layer.close(index);
            });
            return false;
        }

        $.post(
            '{{ route('admin.merchant.tag.update', ['merchant' => $merchant, 'tag' => '###']) }}'.replace('###', $this.data('id')),
            $form.serialize() + '&_method=PUT',
            function (response) {
                if (response.status) {
                    renderProductTags(response.tags);
                    $('#modal-tag').modal('hide');
                }
            },
            'json'
        );
    });

    // 隐藏标签
    $('#product-tags').on('click', '.cmd-product-tag-hide', function () {
        var $this = $(this);

        $.post(
            '{{ route('admin.tag.hide', ['tag' => '###']) }}'.replace('###', $this.parent().data('id')),
            {_method: 'PATCH'},
            function (response) {
                if (response.status) {
                    $this.hide().prev().show();
                }
            },
            'json'
        );
    });

    // 显示标签
    $('#product-tags').on('click', '.cmd-product-tag-show', function () {
        var $this = $(this);

        $.post(
            '{{ route('admin.tag.show', ['tag' => '###']) }}'.replace('###', $this.parent().data('id')),
            {_method: 'PATCH'},
            function (response) {
                if (response.status) {
                    $this.hide().next().show();
                }
            },
            'json'
        );
    });

    // 删除标签
    $('#product-tags').on('click', '.cmd-product-tag-delete', function () {
        var $this = $(this);
        layer.confirm('确认删除？', {icon: 3, title: '提示'}, function (index) {
            $.post(
                '{{ route('admin.tag.destory', ['tag' => '###']) }}'.replace('###', $this.parent().data('id')),
                {_method: 'delete'},
                function (response) {
                    if (response.status) {
                        if ($('#product-tags .list-group-item').length == 1) {
                            $('#product-tags').empty().append('<div class="list-group-item">没有产品分类</div>');
                        } else {
                            $this.closest('.list-group-time').remove();
                        }
                        layer.close(index);
                    }
                },
                'json'
            );
        });
    });

    // 设置 iframe 高度
    var iframeProductList = document.getElementById('iframe-product-list');
    iframeProductList.onload = function() {
        $(this).height(this.contentDocument.body.clientHeight + 20);
    }
});
</script>
@endsection
