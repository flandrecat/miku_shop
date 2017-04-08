<?php
/**
 * @var $this \yii\web\View
 */
echo yii\bootstrap\Html::a('添加分类',['goods-category/add'],['class'=>'btn btn-info']);
?>
<table class="table table-hover table-bordered">
    <tr>
        <th>ID</th>
        <th>名称</th>
        <th>简介</th>
        <th>操作</th>
    </tr>
    <tbody id="tbodybox">
    <?php foreach ($models as $model):?>
        <tr lft = "<?=$model->lft?>" rgt = "<?=$model->rgt?>"  tree = "<?=$model->tree?>">
            <td><?=$model->id?></td>
            <td><?=str_repeat('— ',$model->depth).$model->name?><span class="expand glyphicon glyphicon-menu-down " style="float: right"></span></td>
            <td><?=$model->intro?></td>
            <td>
                <?= yii\bootstrap\Html::a('编辑',['goods-category/edit','id'=>$model->id],['class'=>'btn btn-success'])?>
                <?= yii\bootstrap\Html::a('删除',['goods-category/delete','id'=>$model->id],['class'=>'btn btn-danger'])?>
            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>
<?php
echo \yii\widgets\LinkPager::widget([
    'pagination' => $pages,
    'nextPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页',
]);

/*$js = <<<EOT
    $('.expand').click(function() {
        //切换图标样式,如果存在就删除,否则添加
        $(this).toggleClass('glyphicon-menu-down');
        $(this).toggleClass('glyphicon-menu-up');
        //找到当前tr的树值,左右值
        var old_tr = $(this).closest('tr');
        var old_lft = old_tr.attr('lft');
        var old_rgt = old_tr.attr('rgt');
        var old_tree = old_tr.attr('tree');
        //排序
         $('#tbodybox tr').each(function() {
            var lft = $(this).attr('lft');
            var rgt = $(this).attr('rgt');
            var tree = $(this).attr('terr');
            //判断
            if (tree == old_tree && lft > old_lft && rgt < old_rgt){
                 //当前分类的子孙分类隐藏或显示
                $(this).fadeToggle();
            }
         });
    });
EOT;*/

$js = <<<EOT
    $(".expand").click(function(){
        //切换图标样式
        $(this).toggleClass("glyphicon-menu-down");
        $(this).toggleClass("glyphicon-menu-up");
        //找出当前分类同一棵树下的子孙分类   同一颗树左值大于当前分类左值并且右值小于当前分类右值
        var current_tr = $(this).closest("tr");//获取当前点击图标所在tr
        var current_lft = current_tr.attr("lft");//当前分类左值
        var current_rgt = current_tr.attr("rgt");//当前分类右值
        var current_tree = current_tr.attr("tree");//当前分类tree值
        $("#tbodybox tr").each(function(){

            var lft = $(this).attr("lft");//分类的左值
            var rgt = $(this).attr("rgt");//分类的右值
            var tree = $(this).attr("tree");//分类的tree值
            if(tree == current_tree && lft > current_lft && rgt < current_rgt){
                //当前分类的子孙分类隐藏或显示
                $(this).fadeToggle();
            }
        });

    });
EOT;
//注册JS
$this->registerJs($js);

