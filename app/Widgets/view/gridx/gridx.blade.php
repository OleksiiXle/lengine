<link href="{{ asset('css/gridx.css') }}" rel="stylesheet" />

<script>
    var _modelClass = '<?Php echo $modelClass;?>' ;
    var _gridxId = '<?Php echo $gridxId;?>' ;
    var _pagination = <?Php echo $pagination;?> ;
    var _rowOptions = {!! json_encode($rowOptions) !!};
    var _colOptions = {!! json_encode($colOptions) !!};
    var _columns = {!! json_encode($columns) !!};
    var _header = {!! json_encode($header) !!};
    var _tableBody = {!! json_encode($tableBody) !!};
    var _sort = {!! json_encode($sort) !!};
    var _sortOptions = {!! json_encode($sortOptions) !!};
    var _paginationInfo = '<?Php echo $paginationInfo;?>' ;
    var _paginationButtons = {!! json_encode($paginationButtons) !!};
    var _filterContent = '<?Php echo $filterContent;?>' ;

</script>
<div class="xCard">
    <div class="row">
        <div class="col-md-11">
            <span id="{{$gridxId}}_paginationInfo">
                            {{ $paginationInfo }}
            </span>
            <span id="{{$gridxId}}_filterContent">
                            {{ $filterContent }}
            </span>
        </div>
        <div class="col-md-1" align="right">
            <a onclick="filterShowHide(this)" title="Фильтр" style="cursor: pointer;">
                <span class="glyphicon glyphicon-chevron-down"></span>
            </a>
        </div>

    </div>
    <div class="row">
        <div class="col-md-12" style="display: none" id="filterZone">
            @include( $filterView )
        </div>
    </div>
</div>
<div class="xCard">
    <table id="{{ $gridxId . '_table'}}" class="{{$tableClass}}" style="{{$tableStyle}}">
        <thead id="{{ $gridxId . '_tableHeader'}}" class="{{$headerClass}}" style="{{$headerStyle}}" >

        </thead>
        <tbody id="{{ $gridxId . '_tableBody'}}">

        </tbody>
    </table>
    <div id={{ $gridxId . '_paginationButtons'}}></div>

    <div id={{ $gridxId }}></div>
</div>

<script src="{{ asset('js/gridx.js') }}"></script>
