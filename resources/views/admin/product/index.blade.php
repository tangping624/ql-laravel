@extends('admin.public.layouts', ['title' => '产品管理'])

@section('content')
<div class="row">
    <div class="col-md-3 col-xs-3">
        <a class="btn btn-success" href="{{ $merchant ? route('admin.merchant.product.create', ['merchant' => $merchant]) : route('admin.product.create') }}"{!! $merchant ? ' target="_top"' : '' !!}><span class="glyphicon glyphicon-plus"></span> 新增</a>
    </div>
    @if (!$merchant)
        <div class="col-md-3 col-md-offset-3 col-xs-4 col-xs-offset-2">
            <div class="input-group">
                <span class="input-group-addon">栏目筛选</span>
                <select class="form-control" id="category-filter">
                    <option value="">{{ $categoryId ? '取消筛选' : '选择栏目'}}</option>
                    @foreach ($cates as $id => $name)
                        <option value="{{ $id }}"{{ $id == $categoryId ? ' selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif
    <div class="{{ $merchant ? 'col-md-5 col-xs-5' :'col-md-3 col-xs-3'}} pull-right">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="根据产品名称{{ $merchant ? "": '、商户名称' }}搜索" value="{{ $search }}">
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
                        <th>产品名称</th>
                        @if (!$merchant)
                            <th>所属栏目</th>
                            <th>所属商户</th>
                        @endif
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            @if (!$merchant)
                                <td><a href="javascript:filter('category', {{ $product->merchant->category_id }});" title="根据{{ $cates[$product->merchant->category_id] }}栏目筛选">{{ $cates[$product->merchant->category_id] }}</a></td>
                                <td>{{ $product->merchant->name }}</td>
                            @endif
                            <td><a href="{{ $merchant ? route('admin.merchant.product.edit', ['merchant' => $merchant, 'product' => $product]) : route('admin.product.edit', ['product' => $product]) }}" class="btn btn-xs btn-primary"{!! $merchant ? 'target="_top"' : '' !!}>编辑</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $products->appends($linkParams)->links() !!}
            @if (!$products->count())
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
