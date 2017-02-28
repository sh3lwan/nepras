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
        },
        query: {
            isArray: true,
            transformResponse: function (data, headers) {
                var jsonData = JSON.parse(data);
                headers()['Page-Count'] = jsonData.last_page;
                return jsonData.data;
            }
        }
    });
});