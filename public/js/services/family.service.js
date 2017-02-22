/**
 * Created by shabon on 2/22/2017.
 */

app.factory('Family', function ($resource) {
    return $resource('api/family/:id', {id: '@id'});
});