@extends('admin.public.layouts')

@section('css')
<style type="text/css">
.form-control[readonly] {background-color: #fff; cursor: pointer;}
.image-upload {float: left; overflow: hidden; position: relative;}
.image-upload input {font-size: 999px; position: absolute; top: 0; left: 0; opacity: 0;}
.image-upload img.loading {width: auto; height: auto; margin-top: 84px;}
.image-upload .progress {height: 100%; width: 100%; background: #000; bottom: 0; left: 0; opacity: 0.3; position: absolute; margin: 0;}
.data {max-height: 429px; overflow-y: auto;}
#merchant-tags li {margin-bottom: 3px;}
</style>
@endsection

@section('content')
<div class="row">
    <form id="form-product" class="form-horizontal">
        <div class="col-md-12" style="margin-bottom: 22px;">
            <span class="btn btn-success cmd-save">保存</span>
        </div>

        <div class="col-md-4">
            <div class="panel panel-info">
                <div class="panel-heading">基本信息</div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-xs-3 control-label">商户</label>
                        @if (isset($merchant))
                            <div class="col-xs-9 form-control-static">
                                <a href="{{ route('admin.merchant.edit', ['merchant' => $merchant]) }}">{{ $merchant->name }}</a>
                            </div>
                        @else
                            <div class="col-xs-9">
                                <input id="input-merchant" type="text" class="form-control" readonly placeholder="点击搜索" value="{{ $product->merchant ? $product->merchant->name : '' }}"  data-toggle="modal" data-target="#modal-search-merchant" />
                            </div>
                       @endif
                        <input type="hidden" name="merchant_id" value="{{ $action == 'create' ? (isset($merchant) ? $merchant->id : 0) : ($product->merchant ? $product->merchant->id : 0) }}" />
                    </div>
                    <div id="merchant-tags" class="form-group"{!! (isset($merchant) && $merchant->tags->count()) || ($product->merchant && $product->merchant->tags->count()) ? '' : ' style="display: none;"' !!}>
                        <label class="col-xs-3 control-label">产品分类</label>
                        <ul class="col-xs-9 list-inline form-control-static" style="margin: 0;"></ul>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">产品名称</label>
                        <div class="col-xs-9">
                            <input type="text" name="name" class="form-control" value="{{ $product->name }}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">封面1</label>
                        <div class="clearfix col-xs-9">
                            <div class="image-upload">
                                <input class="cmd-cover" type="file" name="image" accept="image/png, image/jpg, image/jpeg" />
                                <img src="{{ asset($product->cover(1)->uri) }}" class="img-thumbnail" />
                                <input type="hidden" name="cover1" value="{{ $product->cover(1)->id }}" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">封面2</label>
                        <div class="clearfix col-xs-9">
                            <div class="image-upload">
                                <input class="cmd-cover" type="file" name="image" accept="image/png, image/jpg, image/jpeg" />
                                <img src="{{ asset($product->cover(2)->uri) }}" class="img-thumbnail" />
                                <input type="hidden" name="cover2" value="{{ $product->cover(2)->id }}" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="panel panel-success">
                <div class="panel-heading">基本信息</div>
                <div class="panel-body">
                    <script id="editor-infomation" name="information" type="text/plain" style="width: 100%; height: 300px;">{!! $product->information !!}</script>
                </div>
            </div>
            <div class="panel panel-success">
                <div class="panel-heading">产品简介</div>
                <div class="panel-body">
                    <script id="editor-introduction" name="introduction" type="text/plain" style="width: 100%; height: 300px;">{!! $product->information !!}</script>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <span class="btn btn-success cmd-save pull-right">保存</span>
        </div>
    </form>
</div>

<div class="modal fade" id="modal-search-merchant" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">搜索商户</h4>
            </div>
            <div class="modal-body">
                <div class="row" style="margin-bottom: 20px;">
                    <div class="col-xs-5">
                        <div class="input-group">
                            <span class="input-group-addon">栏目</span>
                            <select class="form-control" name="category">
                                <option value="0">所有栏目</option>
                                @foreach ($cates as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-7">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="搜索商户名称、联系人、电话" />
                            <span class="input-group-btn">
                                <span class="btn btn-primary" id="cmd-search-merchant">搜索</span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-xs-8 col-xs-offset-2">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped active" style="width: 100%">加载中……</div>
                            </div>
                        </div>
                        <div class="data" style="display: none"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script type="text/javascript" charset="utf-8" src="{{ asset('/plugins/ueditor/ueditor.config.js') }}"></script>
<script type="text/javascript" charset="utf-8" src="{{ asset('/plugins/ueditor/ueditor.all.min.js') }}"> </script>
<script type="text/javascript" src="{{ asset('/js/uploader.js') }}"></script>
<script type="text/javascript">
$(function (){
    var ueInfo = UE.getEditor('editor-infomation', {toolbars: [[
            'fullscreen', 'undo', 'redo', '|',
            'bold', 'italic', 'underline', '|', 'forecolor', 'backcolor', '|',
            'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|',
            'simpleupload', '|',
            'searchreplace', 'drafts'
        ]], autoHeightEnabled: false}),
        ueIntro = UE.getEditor('editor-introduction', {toolbars: [[
            'fullscreen', 'undo', 'redo', '|',
            'bold', 'italic', 'underline', '|', 'forecolor', 'backcolor', '|',
            'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|',
            'simpleupload', '|',
            'searchreplace', 'drafts'
        ]], autoHeightEnabled: false}),
        merchantTags = {!! $action == 'create' ? ($merchant->tags->toJson()) : $product->merchant->tags->toJson() !!},
        productBeTaggeds = {!! $product->beTaggeds->pluck('id') !!};

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

    function renderTags() {
        var html = '', i;
        for (i = 0; i < merchantTags.length; i++) {
            if ($.inArray(merchantTags[i].id, productBeTaggeds) == -1) {
                html += '<li class="btn btn-sm btn-default cmd-tag-set" data-id="' + merchantTags[i].id + '">' + merchantTags[i].name + '</li> ';
            } else {
                html += '<li class="btn btn-sm btn-success cmd-tag-unset" data-id="' + merchantTags[i].id + '">' + merchantTags[i].name + '</li> ';
            }
        }

        if (html) {
            $('#merchant-tags').show().find('ul').html(html);
        } else {
            $('#merchant-tags').hide();
        }
    }

    renderTags();

    $('#merchant-tags ul').on('click', '.cmd-tag-set', function () {
        var $this = $(this);
        productBeTaggeds.push($this.data('id'));
        $this.removeClass('btn-default cmd-tag-set').addClass('btn-success cmd-tag-unset');
    });

    $('#merchant-tags ul').on('click', '.cmd-tag-unset', function () {
        var $this = $(this), index;
        if (-1 != (index = $.inArray($this.data('id'), productBeTaggeds))) {
            productBeTaggeds.splice(index, 1);
        }
        $this.addClass('btn-default cmd-tag-set').removeClass('btn-success cmd-tag-unset');
    });

    $('.cmd-save').click(function () {
        var $form = $('#form-product'), data;

        if ($form.find('[name=merchant_id]').val() == 0) {
            layer.alert('请选择商户', function (index) {
                layer.close(index);
            });
            return false;
        }

        if ($form.find('[name=name]').val() == 0) {
            layer.alert('请填写产品名称', function (index) {
                $form.find('[name=name]').focus();
                layer.close(index);
            });
            return false;
        }

        $.post(
            '{{ $action == 'create' ? route('admin.product.store', ['product' => $product]) :  route('admin.product.update', ['product' => $product]) }}',
            $form.serialize() + encodeURI('&tag_id[]=' + productBeTaggeds.join('&tag_id[]=')){!! $action == 'create' ? '' : ' + \'&_method=PUT\'' !!},
            function (response) {
                if (response.status) {
                    window.location.href = '{{ $redirect }}';
                }
            },
            'json'
        );
    });

    function renderMerchants (merchants) {
        var html = '';
        for (i = 0; i < merchants.length; i++) {
            html += '<tr>';
            html +=     '<td><a href="javascript:void(0);" class="cmd-choose-merchant" data-id="' + merchants[i].id + '">' + merchants[i].name + '</a></td>';
            html +=     '<td>' + merchants[i].category.name + '</td>';
            html +=     '<td>' + merchants[i].contacts + '</td>';
            html +=     '<td>' + merchants[i].telephone + '</td>';
            html += '</tr>';
        }

        if (html) {
            html = '\
                <table class="table table-striped table-hover merchants">\
                    <thead>\
                        <tr>\
                            <th>商户</th>\
                            <th>所属栏目</th>\
                            <th>联系人</th>\
                            <th>电话</th>\
                        </tr>\
                    </thead>\
                    <tbody>' +
                        html + '\
                    </tbody>\
                </table>';
        } else {
            html = '<p class="text-center">没有查询到数据</p>';
        }

        $('#modal-search-merchant').find('.data').html(html).show().prev().hide();

        $('table.merchants').data('merchants', merchants);
    }

    $('#modal-search-merchant').on('show.bs.modal', function () {
        $(this).find('.data').hide().prev().show();
        $.get(
            '{{ route('admin.merchant.search') }}',
            function (response) {
                renderMerchants(response);
            },
            'json'
        );
    });

    $('#modal-search-merchant').on('click', 'a', function () {
        var $this = $(this),
            merchants = $('table.merchants').data('merchants'),
            merchantId = $this.data('id'),
            $merchantId = $('[name=merchant_id]'),
            i;

        if (merchantId != $merchantId.val()) {
            $('#input-merchant').val($this.text());
            $merchantId.val(merchantId);
            productBeTaggeds = [];

            for (i = 0; i < merchants.length; i++) {
                if (merchants[i].id == merchantId) {
                    merchantTags = merchants[i].tags;
                    renderTags();
                    break;
                }
            }
        }

        $('#modal-search-merchant').modal('hide');
    });

    $('#cmd-search-merchant').click(function () {
        $('#modal-search-merchant').find('.data').hide().prev().show();
        $.get(
            '{{ route('admin.merchant.search') }}',
            {search: $('[name=search]').val(), category: $('[name=category]').val()},
            function (response) {
                renderMerchants(response);
            },
            'json'
        );
    });

});
</script>
@endsection
