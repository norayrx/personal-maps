<?php
Yii::app()->clientScript->registerScriptFile('js/angular.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('js/app.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('js/services/places.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('js/controllers/list.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('js/controllers/form.js', CClientScript::POS_END);
//Yii::app()->clientScript->registerScriptFile('js/require.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScript(
    'requiredScript'
    , 'angular.bootstrap(document, ["personalmaps"]);'
    , CClientScript::POS_END
);
?>
<div class="row-fluid">

    <div class="span9">

    </div>

    <div class="span3" ng-view></div>
</div>
