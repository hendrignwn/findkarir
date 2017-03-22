<?php

use app\models\Company;
use app\models\Currency;
use app\models\Offer;
use app\models\Order;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model Order */
/* @var $form ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->widget(Select2::className(), [
        'theme'=>Select2::THEME_DEFAULT,
        'initValueText' => isset($model->user_id) ? Company::findOne($model->user_id)->getName() : '',
        'pluginOptions'=>[
            'allowClear'=>true,
            'minimumInputLength' => 3,
            'language' => [
                'errorLoading' => new JsExpression("function () { return 'Waiting for results...';}"),
            ],
            'ajax' => [
                'url' => Url::to(['ajax/list-user'], true),
                'dataType' => 'json',
                'data' => new JsExpression("function (params) { return {username:params.term};}")
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(user) { return user.text; }'),
            'templateSelection' => new JsExpression('function (user) { return user.text; }'),
        ],
    ]) ?>

    <?= $form->field($model, 'offer_id')->widget(Select2::className(), [
        'theme' => Select2::THEME_DEFAULT,
        'data' => ArrayHelper::map(Offer::find()->actived()->orderBy(['offer_type_id'=>SORT_ASC])->all(), 'id', 'offerTypeWithNameWithAmount'),
        'options' => [
            'prompt' => 'Choose One',
        ],
        'pluginOptions'=>[
            'allowClear'=>true,
        ]
    ]) ?>

    <?= $form->field($model, 'offer_expired_at')->textInput() ?>

    <?= $form->field($model, 'currency_id')->widget(Select2::className(), [
        'theme' => Select2::THEME_DEFAULT,
        'data' => ArrayHelper::map(Currency::find()->ordered()->all(), 'id', 'name'),
        'options' => [
            'prompt' => 'Choose one',
        ]
    ]) ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'admin_fee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'final_amount')->textInput(['maxlength' => true, 'readonly' => true]) ?>
    
    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>

<?php
$this->registerJs("
 
    var offerExpiredAt = $('#order-offer_expired_at'),
        currencyId = $('#order-currency_id'),
        amount = $('#order-amount'),
        adminFee = $('#order-admin_fee'),
        finalAmount = $('#order-final_amount');
        
    $('#order-offer_id').change(function() {
        $.ajax({
			dataType: 'json',
			url: '".Url::to(['ajax/get-offer'], true)."',
			data: {
				id: $(this).val()
			},
			success: function(result) {
                if (result) {
                    amount.val(result.amount);
                    adminFee.val(result.admin_fee);
                    var final = Number(result.amount) + Number(result.admin_fee);
                    finalAmount.val(final);
                } else {
                    amount.val('');
                    adminFee.val('');
                    finalAmount.val('');
                }
			},
		});
    });
    
    adminFee.keyup(function() {
        finalAmount.val(Number(amount.val()) + Number($(this).val()));
    });
    
    amount.keyup(function() {
        finalAmount.val(Number(adminFee.val()) + Number($(this).val()));
    });

", View::POS_READY, 'order');