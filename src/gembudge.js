(function(window){
    'use strict';
    function define_gembudge() {
        var Gembudge = {};

        if(typeof Vue === "undefined") {
            console.warn("Gembuge requires the Vue library, but Vue could not be found.");
            return Gembudge;
        }
        // Final Statement
        return Gembudge;
    }

    if(typeof(Gembudge) === 'undefined') {
        //export default 'Gembudge';
        window.Gembudge = define_gembudge();
    } else {
        console.log("Gembudge is already defined.");
    }
})(window);
