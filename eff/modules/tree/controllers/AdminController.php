<?php

namespace eff\modules\tree\controllers;

use eff\components\ActiveForm;
use eff\components\Controller;
use eff\modules\tree\models\Tree;
use \Yii;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use yii\web\Response;

/**
 * AdminController implements the CRUD actions for Post model.
 */
class AdminController extends Controller
{
    public $modelClass = 'eff\modules\tree\models\Tree';
    public $modelSearchClass = 'eff\modules\tree\models\TreeSearch';

    public function actionAjax()
    {
        $modelClass = $this->modelClass;
        $result = [];
        if ($id = (int) Yii::$app->request->get('id', false)) {

            $depthItem = $modelClass::findOne(['id' => $id]);
            if ($depthItem) {
                $temp = [];
                foreach ($depthItem->children()->all() as $child) {
                    $temp[] = [
                        'id' => $child->id,
                        'text' => $child->name,
                        'children' => $child->hasChildren() ? true : false
                    ];
                }
                $result = $temp;
            }
        } else {

            $roots = $modelClass::find()->roots()->all();

            if ($roots) {
                foreach ($roots as $k => $root) {
                    $temp = [
                        'id' => $root->id,
                        'text' => $root->name,
                        'state' => ['opened' => true, 'selected' => $k == 0 ? true : false],
                        'icon' => $root->icon
                    ];
                    $children = $root->children(1)->all();
                    if ($children) {
                        foreach ($children as $child) {

                            $temp['children'][] = [
                                'id' => $child->id,
                                'text' => $child->name,
                                'children' => $child->hasChildren() ? true : false,
                                'icon' => $child->icon
                            ];
                        }
                    }
                    $result[] = $temp;
                }
            }
        }
        echo Json::encode($result);
    }

    public function actionTree()
    {
        $id = Yii::$app->request->get('id', false);
        // get model class
        $modelSearchClass = new $this->modelSearchClass();

        // get model
        if ($id === false) {
            $model = new $this->modelClass();
        } else {
            $modelClass = $this->modelClass;
            $model = $modelClass::findOne(['id' => $id]);
        }

        // load post values to model
        if ($model->load(Yii::$app->request->post())) {

            // save and redirect if successful
            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('eff', 'Updated successfully.'));
            }
        }

        // $this->initData();

        // query to db
        $searchModel = new $modelSearchClass();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }

    public static function initData()
    {

        $categories = new Tree(['name' => 'Categories', 'tree' => 'post_categories']);
        $categories->makeRoot();

        $sport = new Tree(['name' => 'Sport', 'tree' => 'post_categories']);
        $sport->appendTo($categories);

        $football = new Tree(['name' => 'Football', 'tree' => 'post_categories']);
        $football->appendTo($sport);

        $basketball = new Tree(['name' => 'Basketball', 'tree' => 'post_categories']);
        $basketball->appendTo($sport);

        $culture = new Tree(['name' => 'Culture', 'tree' => 'post_categories']);
        $culture->appendTo($categories);

        $business = new Tree(['name' => 'Business', 'tree' => 'post_categories']);
        $business->appendTo($categories);

        $international = new Tree(['name' => 'International', 'tree' => 'post_categories']);
        $international->appendTo($business);

        $america = new Tree(['name' => 'America', 'tree' => 'post_categories']);
        $america->appendTo($international);

        $eu = new Tree(['name' => 'EU', 'tree' => 'post_categories']);
        $eu->appendTo($international);

        $asia = new Tree(['name' => 'Asia', 'tree' => 'post_categories']);
        $asia->appendTo($international);

        $other = new Tree(['name' => 'Other', 'tree' => 'post_categories']);
        $other->appendTo($international);

        $dealBook = new Tree(['name' => 'DealBook', 'tree' => 'post_categories']);
        $dealBook->appendTo($business);

        $markets = new Tree(['name' => 'Markets', 'tree' => 'post_categories']);
        $markets->appendTo($business);

        $economy = new Tree(['name' => 'Economy', 'tree' => 'post_categories']);
        $economy->appendTo($business);

        $travel = new Tree(['name' => 'Travel', 'tree' => 'post_categories']);
        $travel->appendTo($categories);

        $social = new Tree(['name' => 'Social', 'tree' => 'post_categories']);
        $social->appendTo($categories);

        $natural = new Tree(['name' => 'Natural', 'tree' => 'post_categories']);
        $natural->appendTo($categories);

        $latest = new Tree(['name' => 'Latest', 'tree' => 'post_categories']);
        $latest->appendTo($categories);

        $local = new Tree(['name' => 'Local', 'tree' => 'post_categories']);
        $local->appendTo($categories);

        $story = new Tree(['name' => 'Story', 'tree' => 'post_categories']);
        $story->appendTo($categories);

        $artist = new Tree(['name' => 'Artist', 'tree' => 'post_categories']);
        $artist->appendTo($categories);

        $tech = new Tree(['name' => 'Tech', 'tree' => 'post_categories']);
        $tech->appendTo($categories);

        $health = new Tree(['name' => 'Health', 'tree' => 'post_categories']);
        $health->appendTo($categories);

        $science = new Tree(['name' => 'Science', 'tree' => 'post_categories']);
        $science->appendTo($categories);

        $style = new Tree(['name' => 'Style', 'tree' => 'post_categories']);
        $style->appendTo($categories);

        $food = new Tree(['name' => 'Food', 'tree' => 'post_categories']);
        $food->appendTo($categories);

        $politics = new Tree(['name' => 'Politics', 'tree' => 'post_categories']);
        $politics->appendTo($categories);

        $video = new Tree(['name' => 'Video', 'tree' => 'post_categories']);
        $video->appendTo($categories);

        $conference = new Tree(['name' => 'Conference', 'tree' => 'post_categories']);
        $conference->appendTo($categories);

        $events = new Tree(['name' => 'Events', 'tree' => 'post_categories']);
        $events->appendTo($categories);

        $photography = new Tree(['name' => 'Photography', 'tree' => 'post_categories']);
        $photography->appendTo($categories);
    }
}
