<?php
/**
 * Created by PhpStorm.
 * User: tungmangvien
 * Date: 10/19/15
 * Time: 9:00 AM
 */

namespace eff\components;


class ListView extends \yii\widgets\ListView
{

    /**
     * @var string the layout that determines how different sections of the list view should be organized.
     * The following tokens will be replaced with the corresponding section contents:
     *
     * - `{summary}`: the summary section. See [[renderSummary()]].
     * - `{items}`: the list items. See [[renderItems()]].
     * - `{sorter}`: the sorter. See [[renderSorter()]].
     * - `{pager}`: the pager. See [[renderPager()]].
     */
    public $layout = "{items}";

}