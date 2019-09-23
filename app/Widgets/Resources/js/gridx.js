let headerArea;
let tableBodyArea;
let paginationButtons;
let columnOptions = {};

let baseUrl = window.location.href.split('?')[0];

let queryParams = {
  //  '_token' : $('meta[name="csrf-token"]').attr('content'),
    'page' : '',
    'offset' : '',
    'filter' : {},
    'sort' : {}
};



function init() {

   // alert('init');
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
      //  console.log(attribute);
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
  //  console.log( page + ' ' + offset);
    queryParams.page = page;
    queryParams.offset = offset;
    queryParams.sort = {
      //  'name' : 'asc' ,
     //   'email' : 'desc'
    };
    refreshGrid();
}

function refreshGrid() {
 //   console.log(queryParams);
 //   var t = getQueryParamsStr();
  //  return true;

    return $.ajax({
        type: 'GET',
        dataType: 'json',
        url: baseUrl,
        data: queryParams,
        success: function (response) {
         //   alert('ok');
           // console.log(response);
            tableBodyArea = getTableBody(_rowOptions, _colOptions, response['tableBody'], columnOptions);
            paginationButtons = getPaginationButtons(response['paginationButtons']);
            drawGrid(_gridxId, headerArea, tableBodyArea, paginationButtons, _tableOptions);
            $("#" + _gridxId + '_paginationInfo').html(response['paginationInfo']);
            $("#" + _gridxId + '_filterContent').html(response['filterContent']);
           // window.location = "?page=" + queryParams.page + "&offset=" + queryParams.offset;
         //   console.log(baseUrl);

          //  var  u = encodeURI(_url + "?page=" + queryParams.page + "&offset=" + queryParams.offset);
            //    + '&sort[d1]=' + queryParams.sort['d1']  + '&sort[d2]=' + queryParams.sort['d2']);
            window.history.pushState(null, null, getQueryParamsStr());
            /*
                       window.history.pushState(null, null, _url + "?page=" + queryParams.page + "&offset=" + queryPar + queryParams.offset
                       + '&sort[d1]=' + queryParams.sort['d1']  + '&sort[d2]=' + queryParams.sort['d2']);
                       */

        },
        error: function (jqXHR, error, errorThrown) {
            console.log(jqXHR);
        }
    });


}

function applyFilter() {
    let fields = $(".filterData");
    let empty = true;
    queryParams.page = 1;
    queryParams.offset = 0;

    queryParams.filter = {};
   // console.log(fields);
    $.each(fields, function () {
        switch (typeof this.value) {
            case 'string':
                empty = this.value.length == 0;
                break;
            case 'number':
                empty = toString(this.value).length == 0;
                break;
        }
       // console.log(this.name + ' = ' + this.value);
        if (!empty){
            queryParams.filter[this.name] = this.value;
        }
    });
   // console.log(queryParams.filter);
    refreshGrid();
}

function resetFilter() {
    $(".filterData").val(null);
    queryParams.filter = {};
    refreshGrid();
}

function getQueryParamsStr() {
    var  u;

    let ret = retP = retF = retS = '';
 //   console.log(queryParams);
    if (typeof queryParams.page == 'number' && typeof queryParams.offset == 'number'){
        retP += 'page=' + queryParams.page + "&offset=" + queryParams.offset ;
    }

    if (typeof queryParams.filter === 'object'){
        /*
        if (ret.length > 0 && !$.isEmptyObject(queryParams.filter)){
            ret +=  '&';
        }
        */
        $.each(queryParams.filter, function(i, v) {
            if (retF.length > 0){
                retF += (retF[0] === '&') ? '' : '&';
            }
            retF += 'filter[' + i + ']=' + v;

        })
    }

    if (typeof queryParams.sort === 'object' ){
        $.each(queryParams.sort, function(i, v) {
            if (retS.length > 0){
                retS += (retS[0] === '&') ? '' : '&';
            }
            retS += 'sort[' + i + ']=' + v;
        })
    }

    if (retP.length > 0){
        ret = retP;
    }

    if (ret.length > 0 && retF.length > 0){
        ret += '&' + retF;
    } else {
        ret += retF;
    }

    if (ret.length > 0 && retS.length > 0){
        ret += '&' + retS;
    } else {
        ret += retS;
    }



    if (ret.length > 0){
        ret = '?' + ret;
    }

    u = encodeURI(baseUrl + ret);
//    console.log(ret);
//   console.log(u);
    return u;

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

