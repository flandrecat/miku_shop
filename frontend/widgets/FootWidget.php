<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/4/11
 * Time: 21:51
 */

namespace frontend\widgets;


use frontend\models\ActicleCategory;
use yii\base\Widget;

class FootWidget extends Widget
{
    public function run()
    {
        /*
    <div class="bottomnav w1210 bc mt10">
            <div class="bnav1">
                <h3><b></b> <em>购物指南</em></h3>
                <ul>
                    <li><a href="">购物流程</a></li>
                    <li><a href="">会员介绍</a></li>
                    <li><a href="">团购/机票/充值/点卡</a></li>
                    <li><a href="">常见问题</a></li>
                    <li><a href="">大家电</a></li>
                    <li><a href="">联系客服</a></li>
                </ul>
            </div>
        </div>
*/
        $html = '';
        foreach (ActicleCategory::getActicleCategory() as $k => $row) {
            $html .= '<div class="bnav'.($k + 1).'">
                      <h3><b></b><em>'.$row->name.'</em></h3>';
            foreach ($row->acticle as $acticle) {

                $html .= '<ul>
                                <li><a href="">'.$acticle->name.'</a></li>
                          </ul>
                        </div>';
            }
        }
        $html = <<<EOT
                <div class="bottomnav w1210 bc mt10">
                       {$html}
	            </div>
EOT;
        return $html;
    }
}

