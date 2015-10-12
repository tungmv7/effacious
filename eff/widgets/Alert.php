<?php
namespace eff\widgets;

use Yii;
use yii\bootstrap\Widget;
use yii\helpers\Html;

class Alert extends Widget
{
    public $closeButton = [];

    public $types = [
        'error' => ['alert-danger', 'glyphicon glyphicon-exclamation-sign'],
        'success' => ['alert-success', 'glyphicon glyphicon-ok-circle'],
        'warning' => ['alert-warning', 'glyphicon glyphicon-alert'],
        'info' => ['alert-info', 'glyphicon glyphicon-info-sign'],
    ];

    public function init()
    {
        parent::init();

        $session = Yii::$app->session;
        $flashes = $session->getAllFlashes();

        foreach ($flashes as $type => $flash) {
            if (isset($this->types[$type])) {
                $flash = (array) $flash;
                foreach ($flash as $i => $message) {
                    $this->options['class'] = $this->types[$type][0];
                    $icon = Html::tag('i', '', ['class' => $this->types[$type][1]]);
                    echo \yii\bootstrap\Alert::widget([
                        'body' => $icon . ' ' . $message,
                        'closeButton' => $this->closeButton,
                        'options' => $this->options,
                    ]);
                }

                $session->removeFlash($type);
            }
        }
    }
}