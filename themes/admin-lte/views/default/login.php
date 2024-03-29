<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use dektrium\user\models\LoginForm;
use dektrium\user\Module;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View                   $this
 * @var LoginForm $model
 * @var Module           $module
 */

$this->title = Yii::t('user', 'Sign in');
$this->params['breadcrumbs'][] = $this->title;

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>

<div class="row">
    <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
				<?php $form = ActiveForm::begin([
					'id'                     => 'login-form',
					'enableAjaxValidation'   => true,
					'enableClientValidation' => false,
					'validateOnBlur'         => false,
					'validateOnType'         => false,
					'validateOnChange'       => false,
				]) ?>

				<?= $form
						->field($model, 'login', $fieldOptions1)
						->textInput(['placeholder' => $model->getAttributeLabel('login')])
				?>

				<?= $form
						->field($model, 'password', $fieldOptions2)
						->passwordInput(['placeholder' => $model->getAttributeLabel('password')])
						 ?>

				<?= $form->field($model, 'rememberMe')->checkbox(['tabindex' => '4']) ?>

				<?= Html::submitButton(
					Yii::t('user', 'Sign in'),
					['class' => 'btn btn-skin btn-block', 'tabindex' => '3']
				) ?>

				<?php ActiveForm::end(); ?>
			
			</div>
			<div class="box-footer">
			</div>
        </div>
	</div>
</div>
