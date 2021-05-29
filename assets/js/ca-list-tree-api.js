const $ = require('jquery');
require('jstree');
require('jquery-confirm');


// global.$ = $; // hack if you need a global $

const routes = require('../../public/js/fos_js_routes.json');
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';
Routing.setRoutingData(routes);

const swal = require('sweetalert');

import {LocationManagerApp} from './LocationManagerApp';

// pass in the jQuery element
const $locationManager = $('#js-ca-list');
const url = $locationManager.data('apiBase');
console.log(url);
let buildingId = $locationManager.data('buildingId');
const locationManager = new LocationManagerApp(
    $locationManager, {
        // https://ac.wip/api/object_types.json?page=1
        url: url + '/object_types?page=1', // the base for all api platform calls
        // dataWrapper: {
        //     building: "/list_items?page=1",
        // },
    }, {
        // map: { parent: 'parentId', text: 'name' }
        changed: (data) => {}
});
//
// console.log(url)

// locationManager.render(); // first time

/*
let $element = $('#demo');
let idx = 0;
$element.jstree({core: {data: ['Root Node 1']}})
    .on('changed.jstree', (e, data) => {
        idx++;
        console.log('changed.jstree ' + idx);
        console.log(data);
    })
    .on('ready.jstree', (e, data) => {
        idx++;
        console.log('ready.jstree ' + idx);
        console.log(data);
    });

$element.jstree(true).settings.core.data = ['New Data'];
$element.jstree(true).refresh();
*/
