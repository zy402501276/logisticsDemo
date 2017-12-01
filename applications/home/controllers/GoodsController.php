<?php

/**
 * 货物模块控制器
 * @time 2017年11月2日17:19:38
 * @author zhangye
 */
class GoodsController extends Controller{
    public function init() {
        parent::init();
        if(!user()->getId()) {
            $this->redirect("/index/index");
        }
        if(!User::checkFirst()){
            $this->redirect("/manage/declare");
        }
    }

    /**
     * 货物列表页
     * @time 2017年11月2日17:28:02
     */
    public function actionList(){
        $model = new GoodsForm();
        if(!empty($_GET['GoodsForm'])){
            $model->attributes = $_GET['GoodsForm'];
        }
        $model->page = request('page', 1);
        $data = $model->search();
        $vo = $data['datas'];
        $pager = $data['pager'];
        $this->setPageTitle('货物列表');
        $this->render('list',compact(array('model','vo','pager')));
    }

    /**
     * 新增，修改货物
     * @time 2017年11月2日18:45:56
     */
    public function actionEdit(){
        $id = request('id');
        $goods = Goods::model()->findByPk($id);
        $model = new GoodsForm();
        $model->attributes = $goods;
        if($_POST){
            $service = GoodsService::getInstance();
            $result = $service->addGoods($_REQUEST,$model);
            if($result['state'] == 1){
                //todo返回列表页
                user()->setFlash('message', '修改成功');
                $this->redirect('/goods/list');
            }
        }
        $this->render('edit',compact(array('model')));
    }

    /**
     * 删除货物
     * @time 2017年11月8日15:10:59
     */
    public function actionGoodsDel(){
        $id = request('id');
        if(empty($id)){
            $this->redirect('/goods/list');
        }
        Goods::model()->updateByPk($id,array('state'=>Goods::STATE_OFF,'updateTime'=>date('Y-m-d H:i:s')));
        $this->redirect('/goods/list');
    }
}