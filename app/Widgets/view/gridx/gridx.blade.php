<script>
    var _modelClass = '<?Php echo $modelClass;?>' ;
    var _gridxId = '<?Php echo $gridxId;?>' ;
    var _pagination = <?Php echo $pagination;?> ;
    var _tableOptions = {!! json_encode($tableOptions) !!};
    var _headerOptions = {!! json_encode($headerOptions) !!};
    var _rowOptions = {!! json_encode($rowOptions) !!};
    var _colOptions = {!! json_encode($colOptions) !!};
    var _columns = {!! json_encode($columns) !!};
    var _header = {!! json_encode($header) !!};
    var _tableBody = {!! json_encode($tableBody) !!};

</script>
<div class="xCard">
    <div class="row">
        <div class="col-md-10">dfgdfg</div>
        <div class="col-md-2" >
            <a onclick="filterShowHide(this)" title="Фильтр">dfg
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
    <div id={{ $gridxId }}></div>
</div>

<script src="{{ asset('js/gridx.js') }}"></script>
