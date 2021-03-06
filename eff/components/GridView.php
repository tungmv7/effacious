<?php
/**
 * Created by PhpStorm.
 * User: tungmangvien
 * Date: 10/8/15
 * Time: 10:50 AM
 */

namespace eff\components;


class GridView extends \yii\grid\GridView
{

    public $tableOptions = ['class' => 'table table-hover'];

    /**
     * @var string the layout that determines how different sections of the list view should be organized.
     * The following tokens will be replaced with the corresponding section contents:
     *
     * - `{summary}`: the summary section. See [[renderSummary()]].
     * - `{errors}`: the filter model error summary. See [[renderErrors()]].
     * - `{items}`: the list items. See [[renderItems()]].
     * - `{sorter}`: the sorter. See [[renderSorter()]].
     * - `{pager}`: the pager. See [[renderPager()]].
     */
    public $layout = "{items}\n{pager}";

//    public function run()
//    {
//        parent::run();

//        $view = $this->getView();
//        $view->registerJs(new JsExpression('
//            $("#'.$this->options['id'].' table").DataTable();
//        '), View::POS_READY);
//    }

}