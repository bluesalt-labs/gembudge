(function(window){
    'use strict';
    function define_gembudge() {
        var Gembudge = {};

        // Require the Vue library
        if(typeof Vue === "undefined") {
            console.warn("Gembuge requires the Vue library, but Vue could not be found.");
            return Gembudge;
        }

        // Require the Moment Library
        if(typeof moment === "undefined") {
            console.warn("Gembuge requires the moment library, moment could not be found.");
            return Gembudge;
        }

        Gembudge.config = {
            helperUrl: "https://gembudge.bluesaltlabs.com/gembudge-helper.php",
            dateFormat: ""
        };

        Gembudge.data = {
            'app': null,
            'data-list': {
                'money': [],
                'time': []
            }
        };

        /*
        Gembudge.componentTypes = {
            0: 'data-list'
        };
        */

        Gembudge.init = function() {

        };

        Gembudge.getHostName = function() {
            return window.location.protocol + "//" + window.location.hostname + (window.location.port ? ':' + window.location.port : '');
        };

        /*
        Gembudge.formatDateString = function(dateString) {
            // if the moment library is available, use that to format the string.
            if(!!window.moment) {
                var date = moment(dateString);
                var dateFormat = Gembudge.dateFormat; // todo: change this if I add a 'defaults' array like ledj
                return date.format(dateFormat);
            } else {
                var d = new Date(dateString);
                return (d.getMonth() + 1) + '/' + d.getDate() + '/' + d.getFullYear();
            }
        };
        */

        /*
        Ledj.loadAndAttachTo = function(jsonUrl, elementID) {
            loadConfigFromUrl(jsonUrl, function(cacheID) {
                sortAndAttachCallback(cacheID, elementID);
            });
        };
         */

        function reloadComponentData(callback) {

        }

        function getJsonData (params, callback){
            var xhr = new XMLHttpRequest();

            // todo: build Url based on params['type'].
            var url = Gembudge.config.helperUrl;

            xhr.open('GET', url, true);
            xhr.responseType = 'json';
            xhr.onload = function() {
                var status = xhr.status;
                if (status === 2000) { callback(null, xhr.response); }
                else { callback(status); }
            };
            xhr.send();
        }

        Gembudge.loadDataAndCreateComponent = function(type, settings = null) {
            reloadComponentData();
        };

        Gembudge.addTimeBudgetList = function(elementID, settings = null) {
            Gembudge.loadDataAndCreateComponent(elementID, 'time-data-list', settings);
        };

        Gembudge.addMoneyBudgetList = function(elementID, settings = null) {
            Gembudge.loadDataAndCreateComponent(elementID, 'money-data-list', settings);
        };
        // Final Statement
        return Gembudge;
    }

    if(typeof(Gembudge) === 'undefined') { window.Gembudge = define_gembudge(); }
    else { console.log("Gembudge is already defined."); }
})(window);
