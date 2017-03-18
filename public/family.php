<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-cogs"></i>Responsive Flip Scroll Tables
        </div>
    </div>
    <div class="portlet-body flip-scroll">
        <table class="table table-bordered table-striped table-condensed flip-content">
            <thead class="flip-content">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Birth Date</th>
                <th width="20%">Address</th>
                <th>Contract</th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="employee in employees | orderBy:'identity'">
                <td>{{employee.identity}}</td>
                <td>{{employee.name}}</td>
                <td>{{employee.birth_date | data:'dd-MM-yyyy'}}</td>
                <td>{{employee.address}}</td>
                <td>{{employee.contract_id}}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>