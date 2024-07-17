var MathGlobal = function() {

        var getNearestPowerValue = function (number, power = 2) {
            if(number > 0) {

                return Math.pow(power, Math.floor(Math.log(number) / Math.log(power)));
            }

            return 0;
        }

        var getLogValue = function (number, base = 2) {
            if(number > 0) {

                return Math.ceil(Math.log(number) / Math.log(base));
            }

            return 0;
        }

    return {
        init: function () {
        },
        getNearestPowerValue: getNearestPowerValue,
        getLogValue: getLogValue,
    };

}();

// Initialize when page loads
jQuery(function() {
    MathGlobal.init();
});
