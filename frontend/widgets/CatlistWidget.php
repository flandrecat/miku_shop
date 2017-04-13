<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/4/12
 * Time: 10:03
 */

namespace frontend\widgets;


use backend\models\GoodsCategory;
use yii\base\Widget;

class CatlistWidget extends Widget
{
    public $category_id = 1;

    public function run()
    {
        $html = '';
        $i = <<<EOT
		<div class="list_left fl mt10">
			<!-- 分类列表 start -->
			<div class="catlist">
				<h2>电脑、办公</h2>
				<div class="catlist_wrap">
					<div class="child">
						<h3 class="on"><b></b>电脑整机</h3>
						<ul>
							<li><a href="">笔记本</a></li>
							<li><a href="">超极本</a></li>
							<li><a href="">平板电脑</a></li>
						</ul>
					</div>
					<div class="child">
						<h3><b></b>外设产品</h3>
						<ul class="none">
							<li><a href="">鼠标</a></li>
							<li><a href="">键盘</a></li>
							<li><a href="">U盘</a></li>
						</ul>
					</div>
				</div>
				<div style="clear:both; height:1px;"></div>
			</div>
EOT;
    }
    public function getGoodsCategory()
    {


    }
}