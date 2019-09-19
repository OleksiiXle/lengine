let headerArea;
let tableBodyArea;
let paginationButtons;
let columnOptions = {};

let queryParams = {
    '_token' : $('meta[name="csrf-token"]').attr('content'),
    'page' : 0,
    'offset' : 0,
    'filter' : {},
    'sort' : {}
};



function init() {
  //  alert('init');
    columnOptions = getColumnOptions(_columns);
    headerArea = getHeader(_headerOptions, _columns);
    tableBodyArea = getTableBody(_rowOptions, _colOptions, _tableBody, columnOptions);
    paginationButtons = getPaginationButtons(_paginationButtons);
    drawGrid(_gridxId, headerArea, tableBodyArea, paginationButtons, _tableOptions);
  //  console.log($("#" + _gridxId));
}

//----------------------------------------------------------------------------------- init functions
function getHeader(headerOptions, columns) {
    let ret = hText = hClass = hStyle = draw = "";
    hClass = (typeof(headerOptions) != "undefined" && typeof(headerOptions.class) != "undefined" )
        ? "class='" + headerOptions.class + "'" : "";
    hStyle = (typeof(headerOptions) != "undefined" && typeof(headerOptions.style) != "undefined" )
        ? "style='" + headerOptions.style + ";'" : "";

    ret = "<thead " + hClass + ' ' + hStyle + "><tr>";
    $(columns).each(function (i, v) {
        //---------------------------
        hClass = (typeof(v.contentOptions) != "undefined" && typeof(v.contentOptions.class) != "undefined" )
            ? "class='" + v.contentOptions.class + "'" : "";
        hStyle = (typeof(v.headerOptions) != "undefined" && typeof(v.contentOptions.style) != "undefined" )
            ? "style='" + v.contentOptions.style + ";'" : "";
        if (typeof(v.draw) != "undefined"){

        }

        //---------------------------
        if (draw == 'yes'){
            hText = (typeof(v.label) != 'undefined' ) ? v.label : v.attribute;
            hClass = (typeof(v.headerOptions) != "undefined" && typeof(v.headerOptions.class) != "undefined" )
                ? "class='" + v.headerOptions.class + "'" : "";
            hStyle = (typeof(v.headerOptions) != "undefined" && typeof(v.headerOptions.style) != "undefined" )
                ? "style='" + v.headerOptions.style + ";'" : "";

            ret += "<td " + hClass + ' ' + hStyle + ">" + hText + "</td>";
        }
    });
    ret += "</tr></thead>";
    return ret;
   // console.log(headerArea);
   // console.log(colOptions);
}

function getColumnOptions(columns) {
    let ret ={};
    let draw = "";
    let hClass = "";
    let hStyle = "";
    $(columns).each(function (i, v) {
        hClass = (typeof(v.contentOptions) != "undefined" && typeof(v.contentOptions.class) != "undefined" )
            ? "class='" + v.contentOptions.class + "'" : "";
        hStyle = (typeof(v.headerOptions) != "undefined" && typeof(v.contentOptions.style) != "undefined" )
            ? "style='" + v.contentOptions.style + ";'" : "";
        if (typeof(v.draw) != "undefined"){

        }
        draw = (typeof(v.draw) != "undefined" && v.draw == "no" )
            ? "no" : "yes";

        ret[v.attribute] = {
            'class' : hClass,
            'style' : hStyle,
            'draw' : draw,
        };
    });

    return ret;
}

function getTableBody(rowOptions, colOptions, tableBody, columnOptions ) {
    let ret = "";
    let rowClass = "";
    let rowStyle = "";
    let colClass = "";
    let colStyle = "";
    let ownClass = "";
    let ownStyle = "";

    ret = "<tbody>";
    rowClass = (typeof(rowOptions) != "undefined" && typeof(rowOptions.class) != "undefined" )
        ? "class='" + rowOptions.class + "'" : "";
    rowStyle = (typeof(rowOptions) != "undefined" && typeof(rowOptions.style) != "undefined" )
        ? "style='" + rowOptions.style + ";'" : "";


    colClass = (typeof(colOptions) != "undefined" && typeof(colOptions.class) != "undefined" )
        ? "class='" + colOptions.class + "'" : "";
    colStyle = (typeof(colOptions) != "undefined" && typeof(colOptions.style) != "undefined" )
        ? "style='" + colOptions.style + ";'" : "";

    $(tableBody).each(function (i, row) {
        ret += "<tr " + rowClass + ' ' + rowStyle + ">";
        $.each(row, function (attr, value) {
            if (columnOptions[attr].draw == 'yes'){
                ownClass = (columnOptions[attr].class.length > 0)
                    ? columnOptions[attr].class : colClass;
                ownStyle = (columnOptions[attr].style.length > 0 )
                    ? columnOptions[attr].style : colStyle;
                ret += "<td " + ownClass + " " + ownStyle + ">" + value + "</td>";
                //  console.log(col);
            }
        });
        ret += "</tr>";
    });

    ret += "</tbody>";
    return ret;
}

function getPaginationButtons(paginationButtons) {
    let btns = '';
    $.each(paginationButtons, function (i, attribute) {
        btns += "<button"
            + " data-page = " + attribute['page']
            + " data-offset = " + attribute['offset']
            + ((attribute['active']) ? ' class="activeButton"' : '')
            + ((attribute['disabled']) ? ' disabled' : '')
            + " onclick = 'changePage(" + attribute['page'] + ", " + attribute['offset'] + ")'"
            + '>'
            + attribute['label']
            + '</button>';
        console.log(attribute);
    });
    return '<span>' + btns + '</span>';
}

//------------------------------------------------------------------------------------ draw functions
function drawGrid(gridxId, headerArea, tableBodyArea, paginationButtons, tableOptions) {
    let tClass = (typeof(tableOptions) != "undefined" && typeof(tableOptions.class) != "undefined" )
        ? "class='" + tableOptions.class + "'" : "";
    let tStyle = (typeof(tableOptions) != "undefined" && typeof(tableOptions.style) != "undefined" )
        ? "style='" + tableOptions.style + ";'" : "";

    let grid  = "<table " + tClass + ' ' + tStyle + ">"
            + headerArea
            + tableBodyArea
            + "</table>"
            + paginationButtons;
    $("#" + gridxId).html(grid);
}

//------------------------------------------------------------------------------------ action functions
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

function changePage(page, offset ) {
    console.log( page + ' ' + offset);
    queryParams.page = page;
    queryParams.offset = offset;
    refreshGrid();
}

function refreshGrid() {
    console.log(queryParams);

    return $.ajax({
        type: 'POST',
        dataType: 'json',
        url: _url,
        data: queryParams,
        success: function (response) {
         //   alert('ok');
            console.log(response);
            tableBodyArea = getTableBody(_rowOptions, _colOptions, response['tableBody'], columnOptions);
            paginationButtons = getPaginationButtons(response['paginationButtons']);
            drawGrid(_gridxId, headerArea, tableBodyArea, paginationButtons, _tableOptions);
            $("#" + _gridxId + '_paginationInfo').html(response['paginationInfo']);

        },
        error: function (jqXHR, error, errorThrown) {
            console.log(jqXHR);
        }
    });


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

