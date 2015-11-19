<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-6">
                <uib-alert template-url="/site/template/alert" ng-repeat="alert in alerts" >{{alert.msg}}</uib-alert>
                <h1 class="page-header">Создание триггера</h1>
                <?php echo $this->render('_form'); ?>
            </div>
            <div class="col-lg-6"></div>
        </div>
    </div>
</div>