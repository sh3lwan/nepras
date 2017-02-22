/**
 * Created by shabon on 2/22/2017.
 */


app.service('popupService', function ($window) {
    this.showPopup = function (message) {
        return $window.confirm(message);
    }
});