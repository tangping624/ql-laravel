<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="collapse navbar-collapse">
            <div class="navbar-header active">
                <a class="navbar-brand" href="{{ route('admin.index') }}">{{ config('app.name') }} 后台管理</a>
            </div>
            <ul class="nav navbar-nav">
                @foreach ($nav as $moduleKey => $module)
                    <li class="nav-sub{{ $moduleKey == $currentModule ? ' active' : '' }}">
                        <a href="{{ route($module['route']) }}" class="dropdown-toggle" data-hover="dropdown">{{ $module['name'] }} <span class="caret"></span></a>
                        @if (isset($module['functions']))
                            <ul class="dropdown-menu">
                                @foreach ($module['functions'] as $functionKey => $function)
                                    @if (isset($function['separator']))
                                        <li role="separator" class="divider"></li>
                                    @else
                                        @if ($function['display']) <li><a href="{{ route($function['route']) }}">{{ $function['name'] }}</a></li> @endif
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
            <ul class="nav  navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-hover="dropdown"><span class="glyphicon glyphicon-user"></span>&nbsp;{{ Auth::user()->name }}&nbsp;<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="javascript:void(0);" id="cmd-change-password">修改密码</a></li>
                        <li>
                            <a href="{{ route('admin.logout') }}"
                                onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                退出
                            </a>
                            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

@if (isset($nav[$currentModule]['functions']))
    <div class="sidenav">
        <ul class="menu">
            @foreach ($nav[$currentModule]['functions'] as $functionKey => $function)
                @if (isset($function['separator']))
                    <li class="divider"></li>
                @else
                    @if ($function['display'])
                        @if ($functionKey == $currentFunction)
                            <li class="active"><span>{{ $function['name'] }}</span></li>
                        @else
                            <li><a href="{{ route($function['route']) }}">{{ $function['name'] }}</a></li>
                        @endif
                    @endif
                @endif
            @endforeach
            @if (isset($nav[$currentModule]['functions'][$currentFunction]) && !$nav[$currentModule]['functions'][$currentFunction]['display'])
                <li class="divider"></li>
                @if (isset($nav[$currentModule]['functions'][$currentFunction]['actions']))
                    <li class="active"><a href="javascript:window.history.back();">{{ $nav[$currentModule]['functions'][$currentFunction]['name'] }}</a></li>
                    @foreach ($nav[$currentModule]['functions'][$currentFunction]['actions'] as $actionKey => $action)
                        @if ($actionKey == $currentAction)
                            <li class="active sub"><span>{{ $nav[$currentModule]['functions'][$currentFunction]['actions'][$currentAction]['name'] }}</span></li>
                        @endif
                    @endforeach
                @else
                    <li class="active"><span>{{ $nav[$currentModule]['functions'][$currentFunction]['name'] }}</span></li>
                @endif
            @endif
        </ul>
    </div>
@endif

<div class="modal fade" id="modal-change-password" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">修改密码</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form class="form-horizontal" id="form-change-password">
                        {{ method_field('PATCH') }}
                        <div class="col-sm-10 col-sm-offset-1">
                            <div class="form-group row" id="original-password">
                                <label class="col-sm-4 control-label">原始密码：</label>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control" name="original" />
                                    <p><span class="help-block"></span></p>
                                </div>
                            </div>
                            <div class="form-group row" id="new-password">
                                <label class="col-sm-4 control-label">新密码：</label>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control" name="new" autocomplete="off" />
                                    <p><span class="help-block"></span></p>
                                </div>
                            </div>
                            <div class="form-group row" id="confirm-password">
                                <label class="col-sm-4 control-label">确认新密码：</label>
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
                <button type="button" class="btn btn-primary" id="action-change-password">确定</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
// dropdown 的 hover 事件触发
;(function($, window, undefined) {
    // outside the scope of the jQuery plugin to
    // keep track of all dropdowns
    var $allDropdowns = $();
    // if instantlyCloseOthers is true, then it will instantly
    // shut other nav items when a new one is hovered over
    $.fn.dropdownHover = function(options) {
        // the element we really care about
        // is the dropdown-toggle's parent
        $allDropdowns = $allDropdowns.add(this.parent());
        return this.each(function() {
            var $this = $(this).parent(),
                defaults = {
                    delay: 100,
                    instantlyCloseOthers: true
                },
                data = {
                    delay: $(this).data('delay'),
                    instantlyCloseOthers: $(this).data('close-others')
                },
                options = $.extend(true, {}, defaults, options, data),
                timeout;
            $this.hover(
                function() {
                    if(options.instantlyCloseOthers === true)
                        $allDropdowns.removeClass('open');
                    window.clearTimeout(timeout);
                    $(this).addClass('open');
                },
                function() {
                    timeout = window.setTimeout(function() {
                        $this.removeClass('open');
                    }, options.delay);
            });
        });
    };
    $('[data-hover="dropdown"]').dropdownHover();
})(jQuery, this);

$(function () {
    $('#cmd-change-password').click(function () {
        $('#modal-change-password')
            .find(':password').val('').end()
            .find('.has-error').removeClass('has-error').end()
        .modal('show');
    });

    $('#action-change-password').click(function () {
        var $form = $('#form-change-password');
        $.post(
            '{{ route('admin.admin.password.change') }}',
            $form.serialize(),
            function (response) {
                if (response.status) {
                    $('#modal-change-password').modal('hide');
                    layer.alert('修改成功');
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

    $('#modal-change-password').on('keydown', '.has-error input', function () {
        $(this).closest('.has-error').removeClass('has-error');
    });
});
</script>
