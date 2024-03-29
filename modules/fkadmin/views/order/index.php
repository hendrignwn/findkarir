<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\fkadmin\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Orders');
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="order-index">
    <?= $this->render('_menu') ?>
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;Create new Order', ['create'],
                    ['role'=>'modal-remote','title'=> 'Create new Orders','class'=>'btn btn-default']).
                    Html::a('<i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;Create new for Partner', ['create-for-partner'],
                    ['role'=>'modal-remote','title'=> 'Create new for Partner','class'=>'btn btn-default']).
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Reset Grid']).
                    '{toggleData}'.
                    '{export}'
                ],
            ],          
            'striped' => true,
            'condensed' => true,
            'responsive' => true,          
            'panel' => [
                'type' => 'primary', 
                'heading' => '<i class="glyphicon glyphicon-list"></i> Orders listing for Users',
                'before'=>'<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
                'after'=>BulkButtonWidget::widget([
                            'buttons'=>Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp; Delete All',
                                ["bulk-delete"] ,
                                [
                                    "class"=>"btn btn-danger btn-xs",
                                    'role'=>'modal-remote-bulk',
                                    'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                                    'data-request-method'=>'post',
                                    'data-confirm-title'=>'Are you sure?',
                                    'data-confirm-message'=>'Are you sure want to delete this item'
                                ]),
                        ]).                        
                        '<div class="clearfix"></div><br/>'.
                        Html::a(Yii::t('app.button', 'Run Console Change Order Status to Expired'), ['order/run-console-order-change-to-expired'], ['role'=>'modal-remote', 'class' => 'btn btn-primary btn-xs'])
            ]
        ])?>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
	'size'=> Modal::SIZE_LARGE,
    "footer"=>"",
	'clientOptions' => [
		'keyboard'=>false,
		'backdrop'=> 'static',
	],
	'options' => [
		'tabindex' => false,
	]
])?>
<?php Modal::end(); ?>

