const SORT_NONE = ' *';
const SORT_ASC = ' &#8593';
const SORT_DESC = ' &#8595';

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
   // console.log(_sortOptions);

   // alert('init');

    columnOptions = getColumnOptions(_columns);
    headerArea = getHeader(_columns);
    tableBodyArea = getTableBody(_rowOptions, _colOptions, _tableBody, columnOptions);
    paginationButtons = getPaginationButtons(_paginationButtons);
    drawGrid(_gridxId, headerArea, tableBodyArea, paginationButtons);
  //  console.log($("#" + _gridxId));
}

//----------------------------------------------------------------------------------- init functions
function getHeader(columns) {
    let ret = hText = hcClass = ownClass = ownStyle = hcStyle = draw = "";
    let attr = '';
    let sortOptions = {};
    let sortClass = '';
    let tdStr = '';

    let colHeaderClass = colHeaderStyle = "";
    colHeaderClass = (typeof(_colOptions.headerOptions) != "undefined" && typeof(_colOptions.headerOptions.class) != "undefined" )
        ? "class='" + _colOptions.headerOptions.class + "'" : "";
    colHeaderStyle = (typeof(_colOptions.headerOptions) != "undefined" && typeof(_colOptions.headerOptions.style) != "undefined" )
        ? "style='" + _colOptions.headerOptions.style + ";'" : "";

    $(columns).each(function (i, v) {
        //---------------------------
        attr = v.attribute;

        draw = "yes";
        hcClass = (typeof(v.headerOptions) != "undefined" && typeof(v.headerOptions.class) != "undefined" )
            ? "class='" + v.contentOptions.class + "'" : colHeaderClass;
        hcStyle = (typeof(v.headerOptions) != "undefined" && typeof(v.headerOptions.style) != "undefined" )
            ? "style='" + v.contentOptions.style + ";'" : colHeaderStyle;

        if (typeof(v.draw) != "undefined"){
            draw = v.draw;
        }
        //---------------------------
        if (draw != 'no'){
            hText = (typeof(v.label) != 'undefined' ) ? v.label : v.attribute;
            ownClass = (typeof(v.headerOptions) != "undefined" && typeof(v.headerOptions.class) != "undefined" )
                ? "class='" + v.headerOptions.class + "'" : hcClass;
            ownStyle = (typeof(v.headerOptions) != "undefined" && typeof(v.headerOptions.style) != "undefined" )
                ? "style='" + v.headerOptions.style + ";'" : hcStyle;

            if (typeof(_sortOptions[attr]) != 'undefined'){
            //    console.log(_sortOptions[attr]);
                sortOptions = {};
                $.each(_sortOptions[attr], function (index, value) {
                    sortOptions[index] = value;
                });
              //  console.log(sortOptions);
                sortClass = (ownClass.length > 0) ? ownClass.substring(0, ownClass.length - 1) + " sortable'" : 'class="sortable"';
                tdStr= "<td " + sortClass + ' ' + ownStyle
                    + ' data-status="nosort"'
                    + ' data-asc="' + sortOptions['asc'] + '"'
                    + ' data-desc="' + sortOptions['desc'] + '"'
                    + ' onclick="changeSort(this);"'
                    + ">" + hText + SORT_NONE + "</td>";

            } else {
                tdStr= "<td " + ownClass + ' ' + ownStyle
                    + ">" + hText + "</td>";
            }
            ret +=tdStr;
        }
    });
    return ret;
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

   // ret = "<tbody>";
    rowClass = (typeof(rowOptions) != "undefined" && typeof(rowOptions.class) != "undefined" )
        ? "class='" + rowOptions.class + "'" : "";
    rowStyle = (typeof(rowOptions) != "undefined" && typeof(rowOptions.style) != "undefined" )
        ? "style='" + rowOptions.style + ";'" : "";


    colClass = (typeof(_colOptions.contentOptions) != "undefined" && typeof(_colOptions.contentOptions.class) != "undefined" )
        ? "class='" + _colOptions.contentOptions.class + "'" : "";
    colStyle = (typeof(_colOptions.contentOptions) != "undefined" && typeof(_colOptions.contentOptions.style) != "undefined" )
        ? "style='" + _colOptions.contentOptions.style + ";'" : "";

    $(tableBody).each(function (i, row) {
        ret += "<tr " + rowClass + ' ' + rowStyle + ">";
        $.each(row, function (attr, value) {
            if (columnOptions[attr].draw == 'yes'){
                ownClass = (columnOptions[attr].class.length > 0)
                    ? columnOptions[attr].class : colClass;
                ownStyle = (columnOptions[attr].style.length > 0 )
                    ? columnOptions[attr].style : colStyle;
                ret += "<td " + ownClass + " " + ownStyle + ">" + value + "</td>";
            }
        });
        ret += "</tr>";
    });

   // ret += "</tbody>";
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
    });
    return '<span>' + btns + '</span>';
}

//------------------------------------------------------------------------------------ draw functions
function drawGrid(gridxId, headerArea, tableBodyArea, paginationButtons ) {
    $("#" + gridxId + "_tableHeader").html(headerArea);
    $("#" + gridxId + "_tableBody").html(tableBodyArea);
    $("#" + gridxId + "_paginationButtons").html(paginationButtons);
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
    refreshGrid();
}

function refreshGrid() {
 //   console.log(queryParams);
  //  var t = getQueryParamsStr();
  //  console.log(t);
  //  return true;

    return $.ajax({
        type: 'GET',
        dataType: 'json',
        url: baseUrl,
        data: queryParams,
        success: function (response) {
            console.log(response);
            if (response['status']){
                console.log('ok');
                tableBodyArea = getTableBody(_rowOptions, _colOptions, response['data']['tableBody'], columnOptions);
                paginationButtons = getPaginationButtons(response['data']['paginationButtons']);
                $("#" + _gridxId + "_tableBody").html(tableBodyArea);
                $("#" + _gridxId + "_paginationButtons").html(paginationButtons);
                $("#" + _gridxId + '_paginationInfo').html(response['data']['paginationInfo']);
                $("#" + _gridxId + '_filterContent').html(response['data']['filterContent']);
                $("#" + _gridxId + "_errors").html('');

                window.history.pushState(null, null, getQueryParamsStr());
            } else {
                let errMessage = '';
                $.each(response['data'], function (i,v) {
                    $.each(v, function (v, message) {
                        errMessage += '<b>' + message + '</b><br>' ;

                    });

                });
                $("#" + _gridxId + "_errors").html(errMessage);

                console.log(response['data']);
            }
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
    $.each(fields, function () {
        switch (typeof this.value) {
            case 'string':
                empty = this.value.length == 0;
                break;
            case 'number':
                empty = toString(this.value).length == 0;
                break;
        }
        if (!empty){
            queryParams.filter[this.name] = this.value;
        }
    });
    refreshGrid();
}

function resetFilter() {
    $(".filterData").val(null);
    queryParams.filter = {};
    queryParams.page = 1;
    queryParams.offset = 0;
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

function changeSort(item) {
    //console.log(queryParams);
    queryParams.page = 1;
    queryParams.offset = 0;

    let buf = $(item).html();
    switch (item.dataset.status) {
        case 'nosort':
            item.dataset.status = 'asc';
            $(item).html(buf.substring(0, buf.length - 1) + SORT_ASC );
            queryParams.sort[item.dataset.asc] = 'asc';
            break;
        case 'asc':
            item.dataset.status = 'desc';
            $(item).html(buf.substring(0, buf.length - 1) + SORT_DESC );
            queryParams.sort[item.dataset.desc] = 'desc';
            break;
        case 'desc':
            item.dataset.status = 'nosort';
            $(item).html(buf.substring(0, buf.length - 1) + SORT_NONE );
            delete queryParams.sort[item.dataset.desc];
            break;
    }
  //  console.log(queryParams);
    refreshGrid();

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

