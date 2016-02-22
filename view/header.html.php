<?php
/*
 *  Copyright (C) 2012 Platoniq y Fundación Fuentes Abiertas (see README for details)
 *	This file is part of Goteo.
 *
 *  Goteo is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  Goteo is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Affero General Public License for more details.
 *
 *  You should have received a copy of the GNU Affero General Public License
 *  along with Goteo.  If not, see <http://www.gnu.org/licenses/agpl.txt>.
 *
 */

use Goteo\Library\Text,
    Goteo\Library\i18n\Lang;
//@NODESYS
?>

<script>
    $(function(){
        $(window).resize(function(){
            var width = $(window).width();
            if (width <= 1140) {
                $('#header').children('.logo_wrapper').children('a').css('display','none');
            } else {
                $('#header').children('.logo_wrapper').children('a').css('display','block');
            }
        });
        $(window).resize();

    })
</script>

<div id="header" class="header">
    <h1 style="display: none;"><?php echo Text::get('regular-main-header'); ?></h1>
    <div class="head_bar_wrapper">
        <div class="head_bar_inner">
            <span>横浜の地域課題プラットフォーム</span>
<?
            if($_SERVER['REQUEST_URI']=="/"):
?>
            <div id="social_bookmark">
                <div id="twitter">
                    <a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>
                    <script>
                        !function(d,s,id){
                            var js,fjs=d.getElementsByTagName(s)[0];
                            if(!d.getElementById(id)){
                                js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";
                                fjs.parentNode.insertBefore(js,fjs);
                            }
                        }(document,"script","twitter-wjs");
                    </script>
                </div>
                <div id="facebook">
                    <?/*<div class="fb-like" data-href="<?= SITE_URL; ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>*/?>
                    <div class="fb-like" data-href="<?= $ogmeta['url']; ?>" data-layout="button_count" data-action="recommend" data-show-faces="false" data-share="true"></div>
                </div>

                <div class="g-plusone" data-size="medium" data-width="60"></div>
                <script type="text/javascript">
                    window.___gcfg = {lang: 'ja'};

                    (function() {
                        var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                        po.src = 'https://apis.google.com/js/platform.js';
                        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                    })();
                </script>

                <div style="clear:both"></div>
            </div><!-- #social_bookmark -->
            <?
            endif;
            ?>
        </div><!--.head_bar_inner-->
    </div>
    <div class="logo_wrapper">
        <div class="inner">
            <h1><a href="<?= LOCALGOOD_WP_BASE_URL ?>"><img src="/view/css/header/logo.png" alt="LOCAL GOOD YOKOHAMA"/></a></h1>
            <div class="catchcopy">
                このまち、わたしから未来を創る
            </div>
            <p class="to_integration_site"><a href="<?= LG_INTEGRATION_URL ?>">LOCAL GOOD全国版トップページ</a></p>
        </div>
        <a class="earth_view" href="<? if(defined('LG_EARTHVIEW')){echo LG_EARTHVIEW;} ?>" target="_blank"><img src="/view/css/header/earth_view_icon.png" alt="Earth View" /></a>
    </div>
    <div class="nav_wrapper">
        <div class="nav_inner">
            <ul>
                <li><a href="<?= LOCALGOOD_WP_BASE_URL ?>">ホーム</a></li>
                <li><a href="<?= LOCALGOOD_WP_BASE_URL ?>/earth_view/">課題を知る</a>
                    <ul class="sub">
                        <li><a href="<?= LOCALGOOD_WP_BASE_URL ?>/submit_subject/">課題を投稿する</a></li>
                        <li><a href="<?= LOCALGOOD_WP_BASE_URL ?>/subject/">課題を見る</a></li>
                    </ul>
                </li>
                <li><a href="<?= LOCALGOOD_WP_BASE_URL ?>/data/">データを見る</a></li>
                <li><a href="<?= LOCALGOOD_WP_BASE_URL ?>/posts_archive/">活動を知る</a></li>

                <li><a href="/user/login/">支援する</a>
                    <ul class="sub">
                        <li><a href="/">プロジェクト</a></li>
                        <li><a href="<?= LOCALGOOD_WP_BASE_URL ?>/skills/">スキルを活かす</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>

    <?php include 'view/header/menu.html.php' ?>

</div>
