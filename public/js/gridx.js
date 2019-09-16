/*
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

 */
let headerArea;
let tableBodyArea;
let colOptions = {};

function init() {
    let gTable = tClass = tStyle =  "";
   // alert('init');
  //  tableBody = JSON.parse(_tableBody);
   // console.log(_gridxId);
   // console.log(_pagination);
   // console.log(_tableOptions);
   // console.log(_columns);
   // console.log(_tableBody);
  //  console.log(_columns);
    getHeader();
    getTableBody();
   // console.log(tableBodyArea);

  //  console.log(_gridxId);
  //  console.log($("#" + _gridxId));
    tClass = (typeof(_tableOptions) != "undefined" && typeof(_tableOptions.class) != "undefined" )
        ? "class='" + _tableOptions.class + "'" : "";
    tStyle = (typeof(_tableOptions) != "undefined" && typeof(_tableOptions.style) != "undefined" )
        ? "style='" + _tableOptions.style + ";'" : "";

    gTable = "<table " + tClass + ' ' + tStyle + ">"
        + headerArea
        + tableBodyArea
        + "</table>";

    $("#" + _gridxId).html(gTable);
}

function getHeader() {
    let hText = hClass = hStyle = draw = "";
    hClass = (typeof(_headerOptions) != "undefined" && typeof(_headerOptions.class) != "undefined" )
        ? "class='" + _headerOptions.class + "'" : "";
    hStyle = (typeof(_headerOptions) != "undefined" && typeof(_headerOptions.style) != "undefined" )
        ? "style='" + _headerOptions.style + ";'" : "";

    headerArea = "<thead " + hClass + ' ' + hStyle + "><tr>";
    $(_columns).each(function (i, v) {
        //---------------------------
        hClass = (typeof(v.contentOptions) != "undefined" && typeof(v.contentOptions.class) != "undefined" )
            ? "class='" + v.contentOptions.class + "'" : "";
        hStyle = (typeof(v.headerOptions) != "undefined" && typeof(v.contentOptions.style) != "undefined" )
            ? "style='" + v.contentOptions.style + ";'" : "";
        if (typeof(v.draw) != "undefined"){

        }

        draw = (typeof(v.draw) != "undefined" && v.draw == "no" )
            ? "no" : "yes";
        colOptions[v.attribute] = {
            'class' : hClass,
            'style' : hStyle,
            'draw' : draw,
        };

        //---------------------------
        if (draw == 'yes'){
            hText = (typeof(v.label) != 'undefined' ) ? v.label : v.attribute;
            hClass = (typeof(v.headerOptions) != "undefined" && typeof(v.headerOptions.class) != "undefined" )
                ? "class='" + v.headerOptions.class + "'" : "";
            hStyle = (typeof(v.headerOptions) != "undefined" && typeof(v.headerOptions.style) != "undefined" )
                ? "style='" + v.headerOptions.style + ";'" : "";

            headerArea += "<td " + hClass + ' ' + hStyle + ">" + hText + "</td>";
        }
    });
    headerArea += "</tr></thead>";
   // console.log(headerArea);
   // console.log(colOptions);
}

function getTableBody() {
    let  rowClass = "";
    let  rowStyle = "";
    let  colClass = "";
    let  colStyle = "";
    let  ownClass = "";
    let  ownStyle = "";

    tableBodyArea = "<tbody>";
    rowClass = (typeof(_rowOptions) != "undefined" && typeof(_rowOptions.class) != "undefined" )
        ? "class='" + _rowOptions.class + "'" : "";
    rowStyle = (typeof(_rowOptions) != "undefined" && typeof(_rowOptions.style) != "undefined" )
        ? "style='" + _rowOptions.style + ";'" : "";


    colClass = (typeof(_colOptions) != "undefined" && typeof(_colOptions.class) != "undefined" )
        ? "class='" + _colOptions.class + "'" : "";
    colStyle = (typeof(_colOptions) != "undefined" && typeof(_colOptions.style) != "undefined" )
        ? "style='" + _colOptions.style + ";'" : "";

    $(_tableBody).each(function (i, row) {
        tableBodyArea += "<tr " + rowClass + ' ' + rowStyle + ">";
        $.each(row, function (attr, value) {
            if (colOptions[attr].draw == 'yes'){
                ownClass = (colOptions[attr].class.length > 0)
                    ? colOptions[attr].class : colClass;
                ownStyle = (colOptions[attr].style.length > 0 )
                    ? colOptions[attr].style : colStyle;
                tableBodyArea += "<td " + ownClass + " " + ownStyle + ">" + value + "</td>";
                //  console.log(col);
            }
        });
        tableBodyArea += "</tr>";
    });

    tableBodyArea += "</tbody>";

   //console.log(tableBodyArea);
}

function filterShowHide(button) {

    if ($("#filterZone").is(":hidden")) {
        $("#filterZone").show("slow");
        $(button).css("color", "#daa520");
        if (typeof clickButtonFilterShowFunction == 'function'){
            clickButtonFilterShowFunction();
        }
    } else {
        $("#filterZone").hide("slow");
        $(button).css("color", "#00008b");
        if (typeof clickButtonFilterHideFunction == 'function'){
            clickButtonFilterHideFunction();
        }

    };
}


function testt() {
    var _csrf = $('meta[name="csrf-token"]').attr('content');
    console.log(_tableBody);
    console.log(_tableBody);
    alert(_tableBody);
    console.log(_csrf);
    return true;
    jQuery.ajax({
        type: 'POST',
        //  dataType: 'json',
        url: '/gridx/get_header',
        data: {
            '_token' : _csrf,
            'id' : 12,
            'type' : 'type12'},
        success: function (response) {
            console.log(response);
        },
        error: function (jqXHR, error, errorThrown) {
            console.log(jqXHR);
        }
    });


}

init();

