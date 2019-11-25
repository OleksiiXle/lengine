<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>AdminPanel Layout</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/adminx.css') }}" rel="stylesheet" />

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/adminxCommon.js') }}"></script>

</head>
<body id="app-layout">
<div id="mainContainer" class="container-fluid">
    <!--************************************************************************************************************* HEADER-->
    <div class="xLayoutHeader">
        <!--************************************************************************************************************* MENU BTN-->
        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" align="left" style="padding-left: 2px; padding-right: 0">
            <b>adminx</b>
            <!--  <button id="open-menu-btn" onclick="showModal(500,600, 'lokoko the best');" class="xMenuBtn" >-->
            <!--
            <a href="/adminxx" title="На гоговну сторінку">
                 <span class ="img-rounded">
                        <img  src="" height="40px" width="40px;">
                 </span>
            </a>
            <button id="open-menu-btn" onclick="showMenu();" class="xMenuBtn" >
                <span class="glyphicon glyphicon-list" ></span>
            </button>
            -->
        </div>
        <!--************************************************************************************************************* CENTER-->
        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 " >
            <h3 style="margin-top: 15px;margin-bottom: 15px; white-space: nowrap; overflow: hidden;">Admin Panel</h3>
        </div>
        <!--************************************************************************************************************* LOGIN/LOGOUT-->
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" align="center" style="padding-left: 1px">
            <b>logout</b>
        </div>
    </div>
    <!--************************************************************************************************************* CONTENT-->
    @include('Adminx::layouts.flash_message')
    {{ csrf_field() }}
    @yield('content')
</div>
</body>
</html>