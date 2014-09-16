<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">

    <!-- BEGIN HEAD -->
    <head profile="http://gmpg.org/xfn/11">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
        <title><?php echo Yii::app()->name ?></title>
        <link rel="icon" type="image/png" href="<?php echo Yii::app()->theme->baseUrl ?>/images/favicon.png" />
        <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/jquery.mobile-1.4.3.min.css" />
        <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/css/snail.css" />
        <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/mobile.css" />
        <meta name='robots' content='noindex,nofollow' />
        <script type='text/javascript' src='<?php echo Yii::app()->baseUrl ?>/js/jquery-1.11.1.min.js'></script>
<!--        <script type='text/javascript' src='<?php //echo Yii::app()->baseUrl    ?>/js/jquery-ui.min.js'></script> -->

        <script type='text/javascript' src="<?php echo Yii::app()->baseUrl ?>/js/jquery.mobile-1.4.3.min.js"></script>
        <script type='text/javascript' src="<?php echo Yii::app()->baseUrl ?>/js/snail.js"></script>
        <script>
            window.BASEURL="<?php echo Yii::app()->getBaseUrl(true);?>";
            window.LOGINUSER_ID="<?php echo (Yii::app()->user->isGuest ? '':Yii::app()->user->id);?>";
        </script>
    </head>

    <body>
        <div data-role="page" id="home">
            <div id="header" data-role="header">
                <?php if (!Yii::app()->user->isGuest): ?>
                    <ul id="menu-left" data-role="menu">
                        <li>
                            <span data-role="button" data-icon="arrow-d" data-iconpos="left">Operation</span>
                            <ul data-role="listview" data-inset="true">
                                <?php foreach ($this->menu as $menu): ?>
                                    <?php if (Yii::app()->user->checkaccess('manager') || (isset($menu['access']) && Yii::app()->user->checkaccess($menu['access']))): ?>
                                        <li data-icon="false"><?php echo CHtml::link($menu['label'], $menu['url']); ?></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>

                            </ul>
                        </li>
                    </ul>
                <?php endif; ?>
                <h2><?php echo $this->pagename; ?> </h2>
                <ul id="menu-right" data-role="menu">
                    <li>
                        <span data-role="button" data-iconpos="left"><img width="35px" src="<?php echo Yii::app()->theme->baseUrl."/images/menu.png"; ?>"/></span>
                        <ul data-role="listview" data-inset="true">
                            <li data-icon="false"><?php echo CHtml::link('Appointments', array('appointments/index')); ?></li>

                            <?php if (Yii::app()->user->checkaccess('manager')): ?>
                                <li data-icon="false"><?php echo CHtml::link('Salons', array('providers/index')); ?></li>
                                <li data-icon="false"><?php echo CHtml::link('Technicians', array('workers/admin')); ?></li>
                                <li data-icon="false"><?php echo CHtml::link('Services', array('services/index')); ?></li>
                                <li data-icon="false"><?php echo CHtml::link('Users', array('users/admin')); ?></li>
                            <?php endif; ?>
                            <?php //if (Yii::app()->user->checkaccess('technician')): ?>
<!--                                <li data-icon="false"><?php //echo CHtml::link('Technician Services', array('workers/admin'));  ?></li>-->
                            <?php //endif; ?>
                            <?php if (Yii::app()->user->checkaccess('admin_technician')): ?>
                                <li data-icon="false"><?php echo CHtml::link('Technicians', array('workers/admin')); ?></li>
                            <?php endif; ?>
                            <?php if (Yii::app()->user->isGuest): ?>
                                <li data-icon="false"><?php echo CHtml::link('Login', array('site/login')); ?></li>
                            <?php else: ?>
                                <li data-icon="false"><?php echo CHtml::link('Profile', array('users/view/' . Yii::app()->user->id)); ?></li>
                                <li data-icon="false"><?php echo CHtml::link('Logout', array('site/logout')); ?></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                </ul>

            </div>
            <div style="clear:both;"></div>
            <div data-role="content">
                <div id="content">
                    <?php echo $content ?>
                </div>
            </div>
        </div>

        <script>
            $('body').bind('hideOpenMenus', function () {
                $("ul:jqmData(role='menu')").find('li > ul').hide();
            });
            var menuHandler = function (e) {
                $('body').trigger('hideOpenMenus');
                $(this).find('li > ul').show();
                e.stopPropagation();
            };
            $("ul:jqmData(role='menu') li > ul li").click(function (e) {
                $('body').trigger('hideOpenMenus');
                e.stopPropagation();
            });
            $('body').delegate("ul:jqmData(role='menu')", 'click', menuHandler);
            $('body').click(function (e) {
                $('body').trigger('hideOpenMenus');
            });
        </script>
    </body>


</html>
