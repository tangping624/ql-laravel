@extends('admin.public.layouts', ['title' => '管理员列表'])

@section('content')
<div class="row">
    <div class="col-md-3">
        <span class="btn btn-success" id="cmd-create"><span class="glyphicon glyphicon-plus"></span> 新增</span>
    </div>
    <div class="col-md-3 col-md-offset-6">
        <form method="GET" action="{{ route('admin.admin.index') }}">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="登陆名称" value="{{ $search }}">
                <span class="input-group-btn">
                    <input class="btn btn-primary" type="submit" value="搜索" />
                </span>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>登陆名称</th>
                    <th>创建时间</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($admins as $admin)
                    <tr>
                        <td>{{ $admin->name }}{{ $admin->id == Auth::user()->id ? ' (登陆)' : '' }}</td>
                        <td>{{ $admin->created_at->format('Y-m-d') }}</td>
                        <td>{{ $admin->status == 1 ? '正常' : '停用' }}</td>
                        <td data-id="{{ $admin->id }}">
                            {{ $admin->id == 1 ? ' (超级管理员)' : '' }}
                            @if ($admin->id != 1 && $admin->id != Auth::user()->id)
                                @if ($admin->status == 1)
                                    <span class="btn btn-info btn-xs cmd-rest-password">重置密码</span>
                                    <span class="btn btn-warning btn-xs cmd-disable">停用</span>
                                @elseif ($admin->status == 2)
                                    <span class="btn btn-success btn-xs cmd-enable">启用</span>
                                @endif
                                <span class="btn btn-danger btn-xs cmd-delete">删除</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {!! $admins->links() !!}
    </div>
</div>

<div class="modal fade" id="modal-create" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">创建新管理员</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form class="form-horizontal" id="form-create">
                        <div class="col-sm-10 col-sm-offset-1">
                            <div class="form-group row" id="name">
                                <label class="col-sm-4 control-label">登陆名称</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="name" />
                                    <p><span class="help-block"></span></p>
                                </div>
                            </div>
                            <div class="form-group row" id="password">
                                <label class="col-sm-4 control-label">密码：</label>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control" name="password" autocomplete="off" />
                                    <p><span class="help-block"></span></p>
                                </div>
                            </div>
                            <div class="form-group row" id="confirm-password">
                                <label class="col-sm-4 control-label">确认密码：</label>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control" name="confirm" autocomplete="off" />
                                    <p><span class="help-block"></span></p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" id="action-create">确定</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
$(function () {
    // 创建密码
    $('#cmd-create').click(function () {
        $('#modal-create').modal('show');
    });

    $('#action-create').click(function () {
        var $form = $('#form-create');
        $.post(
            '{{ route('admin.admin.create') }}',
            $form.serialize(),
            function (response) {
                if (response.status) {
                    window.location.href = '{{ route('admin.admin.index') }}';
                } else {
                    var $input = $form.find('[name=' + response.field + ']');
                    $input.focus()
                        .closest('.form-group').addClass('has-error')
                        .find('.help-block').text(response.msg);
                }
            },
            'json'
        );
    });

    $('#modal-create').on('keydown', '.has-error input', function () {
        $(this).closest('.has-error').removeClass('has-error');
    });

    // 重置密码
    $('.cmd-rest-password').click(function () {
        var $this = $(this);
        layer.confirm('确认重置密码？', {icon: 3, title: '提示'}, function () {
            $.post(
                '{{ route('admin.admin.password.reset', ['admin' => '###']) }}'.replace('###', $this.parent().data('id')),
                {_method: 'PATCH'},
                function (response) {
                    if (response.status) {
                        layer.alert('已经将密码重置为 00000000');
                    }
                }
            );
        });
    });

    // 启用
    $('.cmd-enable').click(function () {
        var $this = $(this);
        layer.confirm('确认启用？', {icon: 3, title: '提示'}, function () {
            $.post(
                '{{ route('admin.admin.enable', ['admin' => '###']) }}'.replace('###', $this.parent().data('id')),
                {_method: 'PATCH'},
                function (response) {
                    if (response.status) {
                        window.location.reload();
                    }
                }
            );
        });
    });

    // 停用
    $('.cmd-disable').click(function () {
        var $this = $(this);
        layer.confirm('确认停用？', {icon: 3, title: '提示'}, function () {
            $.post(
                '{{ route('admin.admin.disable', ['admin' => '###']) }}'.replace('###', $this.parent().data('id')),
                {_method: 'PATCH'},
                function (response) {
                    if (response.status) {
                        window.location.reload();
                    }
                }
            );
        });
    });

    // 删除
    $('.cmd-delete').click(function () {
        var $this = $(this);
        layer.confirm('确认删除？', {icon: 3, title: '提示'}, function () {
            $.post(
                '{{ route('admin.admin.destory', ['admin' => '###']) }}'.replace('###', $this.parent().data('id')),
                {_method: 'DELETE'},
                function (response) {
                    if (response.status) {
                        window.location.reload();
                    }
                }
            );
        });
    });
});
</script>
@endsection
