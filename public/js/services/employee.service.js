/**
 * Created by shabon on 2/22/2017.
 */


app.factory('Employee', function ($resource) {
    return $resource('/api/employees/:id', {id: '@id'}, {
        update: {
            method: 'PUT'
        },
        delete: {
            method: 'DELETE'
        }
    });
});