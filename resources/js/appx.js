/*
import $ from 'jquery';
window.$ = window.jQuery = $;
*/

/*
import 'jquery-ui/ui/widgets/datepicker.js';
*/
/*
window.jQuery = window.$ = $ = require('jquery');
*/

try {

    window.$ = window.jQuery = require('jquery');

    window.Popper = require('popper.js').default;



    require('bootstrap');

} catch (e) {}

/*

require('bootstrap');
*/