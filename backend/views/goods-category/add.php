<?php
/**
 * @var $this \yii\web\View  //告诉页面$this是个VIEW类
 */
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'parent_id')->hiddenInput();
echo '<div>
        <ul id="treeDemo" class="ztree"></ul>
       </div>';
echo $form->field($model,'intro');
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();

//注册JS文件
$this->registerJsFile('@web/zTree/js/jquery.ztree.core.js',
    //当前的Js文件需要依赖该文件
    ['depends'=>\yii\web\JqueryAsset::className()]);
//注册JS代码
$JS = <<<JS
            var zTreeObj;
    // zTree 的参数配置，深入使用请参考 API 文档（setting 配置详解）
    var setting = {
        data: {
            simpleData: {
                enable: true,
                idKey: "id",
                pIdKey: "parent_id",
                rootPId: 0
            }
         },
                 callback: {
		               onClick: function(event, treeId, treeNode) {
		                   $('#goodscategory-parent_id').val(treeNode.id);	
		                   console.debug(treeNode.id);
		               }
	                }
    };
    // zTree 的数据属性，深入使用请参考 API 文档（zTreeNode 节点数据详解）
    var zNodes = {$models}

        //console.log(zNodes);
        zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
        //展开节点
        zTreeObj.expandAll(true); 
        //选中节点
        zTreeObj.selectNode(zTreeObj.getNodeByParam("id", "{$model->parent_id}", null));
       
JS;
//默认jQuery(document).ready().
$this->registerJs($JS);
?>
<link rel="stylesheet" href="/zTree/css/zTreeStyle/zTreeStyle.css" type="text/css">



