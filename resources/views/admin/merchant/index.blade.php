@extends('admin.public.layouts', ['title' => '商户管理'])

@section('content')
<div class="row">
    <div class="col-md-3">
        <a class="btn btn-success" href="{{ route('admin.merchant.create') }}"><span class="glyphicon glyphicon-plus"></span> 新增</a>
    </div>
    <div class="col-md-3 col-md-offset-3">
        <div class="input-group">
            <span class="input-group-addon">栏目筛选</span>
            <select class="form-control" id="category-filter">
                <option value="">{{ $categoryId ? '取消筛选' : '选择栏目'}}</option>
                @foreach ($cates as $cate)
                    <option value="{{ $cate->id }}"{{ $cate->id == $categoryId ? ' selected' : '' }}>{{ $cate->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="根据名称、联系人、电话搜索" value="{{ $search }}">
            <span class="input-group-btn">
                <span class="btn btn-primary" id="cmd-search">搜索</span>
            </span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>商户名称</th>
                    <th>所属栏目</th>
                    <th>联系人</th>
                    <th>电话</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($merchants as $merchant)
                    <tr>
                        <td>{{ $merchant->name }}</td>
                        <td><a href="javascript:filter('category', {{ $merchant->category_id }});" title="根据{{$merchant->category->name}}栏目筛选">{{ $merchant->category->name }}</a></td>
                        <td>{{ $merchant->contacts }}</td>
                        <td>{{ $merchant->telephone }}</td>
                        <td><a href="{{ route('admin.merchant.edit',['merchant' => $merchant]) }}" class="btn btn-xs btn-primary">编辑</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {!! $merchants->appends($linkParams)->links() !!}
        @if (!$merchants->count())
            <p class="text-center" style="margin-top: 20px;">没有相应的数据……</p>
        @endif
    </div>
</div>
@endsection

@section('js')
<script>
// 查询筛选器
function filter(key, value) {
    var queryParams = _utils.parseQueryString(window.location.href),
        url = window.location.href.split('?')[0],
        queryString = '';

    if (queryParams.page) {
        delete queryParams.page;
    }

    queryParams[key] = value;

    for (key in queryParams) {
        if (queryParams.hasOwnProperty(key)) {
            if (queryString.length) {
                queryString += '&' + key + '=' + queryParams[key];
            } else {
                queryString += '?' + key + '=' + queryParams[key];
            }
        }
    }

    window.location.href = url + queryString;
}

$(function () {
    // 点击搜索
    $('#cmd-search').click(function () {
        filter('search', $('[name=search]').val());
    });

    // 更改栏目
    $('#category-filter').change(function () {
        filter('category', $(this).val());
    });
});
</script>
@endsection
