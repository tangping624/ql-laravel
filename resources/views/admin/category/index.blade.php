@extends('admin.public.layouts', ['title' => '栏目管理'])

@section('css')
<style type="text/css">
#cate-detail {right: 0;}
.icon {overflow: hidden; width: 200px; height: 200px; position: relative; cursor: pointer;}
.icon input {font-size: 999px; position: absolute; top: 0; left: 0; cursor: pointer; opacity: 0;}
.icon img {width: 200px; height: 200px;}
.icon img.loading {width: auto; height: auto; margin-top: 84px;}
.icon .progress {height: 100%; width: 100%; background: #000; bottom: 0; left: 0; opacity: 0.3; position: absolute; margin: 0;}
#cate-tags li {border: 1px solid #ccc; margin-right: 5px; border-radius: 4px;}
#cate-tags li>* {display: block; float: left; margin-right: 5px;}
#cate-tags a {line-height: 30px; height: 30px;}
#cate-tags .btn {margin-top: 3px;}
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4" id="cate-list">
        <div class="panel panel-info">
            <div class="panel-heading">栏目列表</div>
            <div class="list-group">
                @foreach ($cates as $cate)
                    <a href="javascript:void(0);" class="list-group-item cate"  data-id="{{ $cate->id }}">
                        {{ $cate->name }}
                        @if ($cate->display)
                            <span class="btn btn-xs btn-success pull-right cmd-cate-show" style="display: none;">显示</span>
                            <span class="btn btn-xs btn-warning pull-right cmd-cate-hide">隐藏</span>
                        @else
                            <span class="btn btn-xs btn-success pull-right cmd-cate-show">显示</span>
                            <span class="btn btn-xs btn-warning pull-right cmd-cate-hide" style="display: none;">隐藏</span>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    <div class="affix" id="cate-detail" data-spy="affix" style="display: none;">
        <div class="panel panel-success">
            <div class="panel-heading"><strong class="cate-name"></strong> 栏目详情</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-6">
                        <form id="form-cate">
                            <input type="hidden" name="image_id" value="0" />
                            <div class="form-group">
                                <label>栏目名称</label>
                                <input type="text" class="form-control" name="name" value="" placeholder="栏目的显示名称" />
                            </div>
                            <div class="form-group">
                                <label>排序</label>
                                <input type="text" class="form-control" name="sortord" value="" placeholder="排序" />
                            </div>
                            <span class="btn btn-success" id="cmd-cate-save">保存</span>
                        </form>
                    </div>
                    <div class="col-xs-6">
                        <label>栏目图标 (点击更换)</label>
                        <div class="icon" id="cate-icon">
                            <input id="uploader-cate" type="file" name="image" accept="image/png, image/jpg, image/jpeg" data-cate-id="0" />
                            <img class="img-thumbnail" src="" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-info">
            <div class="panel-heading">
                栏目分类
                <span class="btn btn-success btn-xs pull-right" id="cmd-tag-create">新增</span>
            </div>
            <div class="panel-body">
                <ul class="list-inline" id="cate-tags"></ul>
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
                <h4 class="modal-title">添加栏目分类</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form class="form-horizontal" id="form-tag">
                        <input type="hidden" name="id" value="0" />
                        <input type="hidden" name="image_id" value="0" />
                        <div class="col-sm-10 col-sm-offset-1">
                            <div class="form-group row">
                                <label class="col-sm-4 control-label">分类名称：</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="name" placeholder="栏目分类名称" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 control-label">分类排序：</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="sortord" placeholder="栏目分类排序" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 control-label">分类图标</label>
                                <div class="col-sm-6">
                                    <div class="icon" id="tag-icon">
                                        <input id="uploader-tag" type="file" name="image" accept="image/png, image/jpg, image/jpeg" data-cate-id="0" />
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
<script src="{{ asset('js/uploader.js') }}"></script>
<script type="text/javascript">
$(function () {
    // 设置栏目详情宽度
    $('#cate-detail').css({width: ($('.main-content>.row').width() - $('#cate-list').width() - 15) + 'px', padding: '0 15px'});

    // 隐藏
    $('.cmd-cate-hide').click(function () {
        var $this = $(this);
        $.post(
            '{{ route('admin.category.display.hide', ['category' => '###']) }}'.replace('###', $this.parent().data('id')),
            {_method: 'PATCH'},
            function (response) {
                if (response.status) {
                    $this.hide().prev().show();
                }
            },
            'json'
        );
        return false;
    });

    // 显示
    $('.cmd-cate-show').click(function () {
        var $this = $(this);
        $.post(
            '{{ route('admin.category.display.show', ['category' => '###']) }}'.replace('###', $this.parent().data('id')),
            {_method: 'PATCH'},
            function (response) {
                if (response.status) {
                    $this.hide().next().show();
                }
            },
            'json'
        );
        return false;
    });

    // 查看栏目详情
    $('.list-group-item.cate').click(function () {
        var $this = $(this);
        $.get(
            '{{ route('admin.category.detail', ['category' => '###']) }}'.replace('###', $this.data('id')),
            function (response) {
                $('#cate-list .cate').removeClass('active');
                $this.addClass('active');

                $('#form-cate [name=image_id]').val(response.images.length ? response.images[0].id : 0);

                $('#cate-detail').data('id', response.id)
                    .find('.cate-name').text(response.name).end()
                    .find('[name=name]').val(response.name).end()
                    .find('[name=path]').val(response.path).end()
                    .find('[name=sortord]').val(response.sortord).end()
                    .find('img').attr('src', response.icon).end()
                .show();

                renderCategoryTags(response.tags);
            },
            'json'
        );
    });

    // 更换栏目 icon
    $('#uploader-cate').uploader({
        url: '{{ route('upload.image') }}',
        imageClientProcess: true,
        targetWidth: 200,
        targetHeight: 200,
        imageRatio: 'target',
        onAdd: function (elementId) {
            $('#cate-icon img').addClass('loading').attr('src', '/images/loading.gif');
        },
        onImageProcess: function (uri, elementId) {
            $('#cate-icon img').removeClass('loading').attr('src', uri);
            $('#cate-icon').append('<div class="progress"></div>');
        },
        onProgress: function (e) {
            var percent = parseInt(100 - (e.loaded / e.total) * 100) + '%';
            $('#cate-icon .progress').css({height: percent});
        },
        done: function (response, elementId) {
            $('#form-cate [name=image_id]').val(response.id);
        }
    });

    // 保存栏目信息
    $('#cmd-cate-save').click(function () {
        var $form = $('#form-cate');
        if (!$form.find('[name=name]').val().trim().length) {
            layer.alert('栏目名称不能为空', function (index) {
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
            '{{ route('admin.category.update', ['category' => '###'])}}'.replace('###', $('#cate-detail').data('id')),
            $form.serialize() + '&_method=PUT',
            function (response) {
                if (response.status) {
                    window.location.reload();
                }
            },
            'json'
        );
    });

    // 栏目分类功能
    // 渲染栏目分类
    function renderCategoryTags(tags) {
        var i, html = '';

        for (i = 0; i < tags.length; i++) {
            html += '<li class="clearfix" data-id="' + tags[i].id + '">';
            html += '    <a href="javascript:void(0);">' + tags[i].name + '</a>';
            if (tags[i].display) {
                html += '    <span class="btn btn-warning btn-xs glyphicon glyphicon-eye-close cmd-tag-hide" title="隐藏"></span>';
                html += '    <span class="btn btn-success btn-xs glyphicon glyphicon-eye-open cmd-tag-show" style="display:none;" title="显示"></span>';
            } else {
                html += '    <span class="btn btn-warning btn-xs glyphicon glyphicon-eye-close cmd-tag-hide" style="display:none;" title="隐藏"></span>';
                html += '    <span class="btn btn-success btn-xs glyphicon glyphicon-eye-open cmd-tag-show" title="显示"></span>';
            }
            html += '    <span class="btn btn-danger btn-xs glyphicon glyphicon-remove cmd-tag-delete" title="删除"></span>';
            html += '</li>';
        }

        if (!html) {
            html = '<li style="border: none;">没有栏目分类</li>';
        }

        $('#cate-tags').html(html);
    }

    // 更换栏目分类 icon
    $('#uploader-tag').uploader({
        url: '{{ route('upload.image') }}',
        imageClientProcess: true,
        targetWidth: 200,
        targetHeight: 200,
        imageRatio: 'target',
        onAdd: function (elementId) {
            $('#tag-icon img').addClass('loading').attr('src', '/images/loading.gif');
        },
        onImageProcess: function (uri, elementId) {
            $('#tag-icon img').removeClass('loading').attr('src', uri);
            $('#tag-icon').append('<div class="progress"></div>');
        },
        onProgress: function (e) {
            var percent = parseInt(100 - (e.loaded / e.total) * 100) + '%';
            $('#tag-icon .progress').css({height: percent});
        },
        done: function (response, elementId) {
            $('#form-tag [name=image_id]').val(response.id);
        }
    });

    // 创建栏目分类
    $('#cmd-tag-create').click(function () {
        $('#modal-tag')
            .find('.modal-title').text('添加栏目分类').end()
            .find('img').attr('src', '{{ asset(config('misc.default-image')) }}').end()
            .find('[name=image_id]').val(0).end()
            .find('[name=id]').val(0).end()
            .find('[name=name]').val('').end()
            .find('[name=sortord]').val(0).end()
            .find('#action-tag-create').show().end()
            .find('#action-tag-save').hide().end()
        .modal('show');
    });

    // 点击创建栏目分类按钮
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
            '{{ route('admin.category.tag.create', ['category' => '###']) }}'.replace('###', $('#cate-detail').data('id')),
            $form.serialize(),
            function (response) {
                if (response.status) {
                    $('#modal-tag').modal('hide');
                    renderCategoryTags(response.tags);
                }
            },
            'json'
        );
    });

    // 显示栏目分类
    $('#cate-tags').on('click', 'a', function () {
        $.get(
            '{{ route('admin.tag.detail', ['tag' => '###']) }}'.replace('###', $(this).parent().data('id')),
            function (response) {
                $('#modal-tag')
                    .find('.modal-title').text('编辑栏目分类').end()
                    .find('img').attr('src', response.icon).end()
                    .find('[name=image_id]').val(0).end()
                    .find('[name=id]').val(response.id).end()
                    .find('[name=name]').val(response.name).end()
                    .find('[name=sortord]').val(response.sortord).end()
                    .find('#action-tag-create').hide().end()
                    .find('#action-tag-save').data('id', response.id).show().end()
                .modal('show');
            },
            'json'
        );
    });

    // 保存栏目分类
    $('#action-tag-save').click(function () {
        var $this = $(this),
            $form = $('#form-tag');

        if (!$form.find('[name=name]').val().trim().length) {
            layer.alert('分类名称不能为空', function (index) {
                $form.find('[name=path]').focus();
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
            '{{ route('admin.category.tag.update', ['category' => '###1', 'tag' => '###2']) }}'.replace('###1', $('#cate-detail').data('id')).replace('###2', $this.data('id')),
            $form.serialize() + '&_method=PUT',
            function (response) {
                if (response.status) {
                    renderCategoryTags(response.tags);
                    $('#modal-tag').modal('hide');
                }
            }
        );
    });

    // 分类删除
    $('#cate-tags').on('click', '.cmd-tag-delete', function () {
        var $this = $(this);

        layer.confirm('确认删除？', {icon: 3, title: '提示'}, function (index) {
            $.post(
                '{{ route('admin.tag.destory', ['tag' => '###']) }}'.replace('###', $this.parent().data('id')),
                {_method: 'DELETE'},
                function (response) {
                    if (response.status) {
                        $this.parent().remove();
                        layer.close(index);
                    }
                },
                'json'
            );
        });
    });

    // 分类隐藏
    $('#cate-tags').on('click', '.cmd-tag-hide', function () {
        var $this = $(this);

        $.post(
            '{{ route('admin.tag.hide', ['tag' => '###']) }}'.replace('###', $this.parent().data('id')),
            {_method: 'PATCH'},
            function (response) {
                if (response.status) {
                    $this.hide().next().show();
                }
            },
            'json'
        );
    });

    // 分类显示
    $('#cate-tags').on('click', '.cmd-tag-show', function () {
        var $this = $(this);

        $.post(
            '{{ route('admin.tag.show', ['tag' => '###']) }}'.replace('###', $this.parent().data('id')),
            {_method: 'PATCH'},
            function (response) {
                if (response.status) {
                    $this.hide().prev().show();
                }
            },
            'json'
        );
    });
});
</script>
@endsection
