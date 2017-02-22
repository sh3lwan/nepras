/**
 * Created by shabon on 2/22/2017.
 */


app.factory('Contract', function ($resource) {
    return $resource('api/contracts/:id', {id: '@id'});
});