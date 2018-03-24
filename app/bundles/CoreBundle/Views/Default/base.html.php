<?php

/*
 * @copyright   2014 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
?>
<!DOCTYPE html>
<html>
<?php echo $view->render('MauticCoreBundle:Default:head.html.php'); ?>
<body class="header-fixed">
<!-- start: app-wrapper -->
<section id="app-wrapper">
    <?php $view['assets']->outputScripts('bodyOpen'); ?>

    <!-- start: app-sidebar(left) -->
    <aside class="app-sidebar sidebar-left">
        <?php echo $view->render('MauticCoreBundle:LeftPanel:index.html.php'); ?>
    </aside>
    <!--/ end: app-sidebar(left) -->

    <!-- start: app-sidebar(right) -->
    <aside class="app-sidebar sidebar-right">
        <?php echo $view->render('MauticCoreBundle:RightPanel:index.html.php'); ?>
    </aside>
    <!--/ end: app-sidebar(right) -->

    <!-- start: app-header -->
   <header id="app-header" class="navbar">

       <?php if (!empty($licenseRemCount)) : ?>
           <?php if ($licenseRemCount <= 7) : ?>
               <?php $message = $view['translator']->trans('leadsengage.license.expired', ['%licenseRemDate%' => $licenseRemDate]); ?>
           <?php endif; ?>
       <?php endif; ?>

       <?php $emailUssage    = false; ?>
       <?php $bouceUsage     = false; ?>
       <?php $emailsValidity = false; ?>
       <?php $recordUsage    = false; ?>

       <?php if (isset($emailUsageCount) && $emailUsageCount > 85): ?>
           <?php $emailUssage=true; ?>
       <?php endif; ?>
       <?php if (isset($bounceUsageCount) && $bounceUsageCount > 3): ?>
           <?php $bouceUsage=true; ?>
       <?php endif; ?>
       <?php if (isset($emailValidity) && $emailValidity < 7): ?>
           <?php $emailsValidity=true; ?>
       <?php endif; ?>
       <?php if (isset($totalRecordUsage) && $totalRecordUsage > 85): ?>
           <?php $recordUsage=true; ?>
       <?php endif; ?>

       <?php if ($emailUssage && $bouceUsage && $emailsValidity && $recordUsage): ?>
           <?php $usageMsg = $view['translator']->trans('leadsengage.email.bounce.validity.record.expired', ['%bounceUsageCount%' => $bounceUsageCount, '%emailValidityEndDate%' => $emailValidityEndDate]); ?>
       <?php elseif ($emailUssage && $bouceUsage && $emailsValidity): ?>
           <?php $usageMsg = $view['translator']->trans('leadsengage.email.bounce.validity.expired', ['%bounceUsageCount%' => $bounceUsageCount, '%emailValidityEndDate%' => $emailValidityEndDate]); ?>
       <?php elseif ($bouceUsage && $emailsValidity && $recordUsage): ?>
          <?php $usageMsg = $view['translator']->trans('leadsengage.bounce.validity.record.expired', ['%bounceUsageCount%' => $bounceUsageCount, '%emailValidityEndDate%' => $emailValidityEndDate]); ?>
       <?php elseif ($recordUsage && $emailUssage && $bouceUsage): ?>
          <?php $usageMsg = $view['translator']->trans('leadsengage.record.email.bounce.expired', ['%bounceUsageCount%' => $bounceUsageCount, '%emailValidityEndDate%' => $emailValidityEndDate]); ?>
       <?php elseif ($emailsValidity && $recordUsage && $emailUssage): ?>
           <?php $usageMsg = $view['translator']->trans('leadsengage.record.validity.email.expired', ['%bounceUsageCount%' => $bounceUsageCount, '%emailValidityEndDate%' => $emailValidityEndDate]); ?>

       <?php elseif ($emailUssage && $bouceUsage): ?>
           <?php $usageMsg = $view['translator']->trans('leadsengage.bounce.email.usage.exceeds', ['%bounceUsageCount%' => $bounceUsageCount]); ?>
       <?php elseif ($bouceUsage && $emailsValidity): ?>
           <?php $usageMsg = $view['translator']->trans('leadsengage.bounce.validity.expired', ['%bounceUsageCount%' => $bounceUsageCount, '%emailValidityEndDate%' => $emailValidityEndDate]); ?>
       <?php elseif ($emailsValidity && $recordUsage): ?>
           <?php $usageMsg = $view['translator']->trans('leadsengage.record.validity.expired', ['%emailValidityEndDate%' => $emailValidityEndDate]); ?>
       <?php elseif ($emailUssage && $recordUsage): ?>
           <?php $usageMsg = $view['translator']->trans('leadsengage.email.record.expired'); ?>
       <?php elseif ($bouceUsage && $recordUsage): ?>
           <?php $usageMsg = $view['translator']->trans('leadsengage.bounce.record.expired', ['%emailValidityEndDate%' => $emailValidityEndDate]); ?>
       <?php elseif ($emailUssage && $emailsValidity): ?>
           <?php $usageMsg = $view['translator']->trans('leadsengage.email.validity.exceeds', ['%emailValidityEndDate%' => $emailValidityEndDate]); ?>

       <?php elseif ($emailUssage): ?>
           <?php $usageMsg = $view['translator']->trans('leadsengage.email.usage.exceeds'); ?>
       <?php elseif ($bouceUsage): ?>
           <?php $usageMsg = $view['translator']->trans('leadsengage.bounce.usage.exceeds', ['%bounceUsageCount%' => $bounceUsageCount]); ?>
       <?php elseif ($emailsValidity): ?>
           <?php $usageMsg = $view['translator']->trans('leadsengage.email.validity.expired', ['%emailValidityEndDate%' => $emailValidityEndDate]); ?>
       <?php elseif ($recordUsage): ?>
           <?php $recordUsage = $view['translator']->trans('leadsengage.record.usage.exceeds'); ?>
       <?php endif; ?>

       <?php  if (!empty($message)) : ?>
           <?php if (!empty($usageMsg)) : ?>
               <?php  $message = "$message $usageMsg" ?>
           <?php else : ?>
               <?php  $message = $message  ?>
           <?php endif; ?>
           <span class="license-notifiation" id="licenseclosebutton"><?php echo $message ?> <img style="cursor: pointer" class="button-notification" src="<?php echo $view['assets']->getUrl('media/images/button.png') ?>" onclick="licenseCloseButton()" width="10" height="10"> </span>
       <?php else: ?>
           <?php if (!empty($usageMsg)) : ?>
               <span class="license-notifiation" id="licenseclosebutton"><?php echo $usageMsg ?> <img style="cursor: pointer" class="button-notification" src="<?php echo $view['assets']->getUrl('media/images/button.png') ?>" onclick="licenseCloseButton()" width="10" height="10"> </span>
           <?php endif; ?>
       <?php endif; ?>

        <?php echo $view->render('MauticCoreBundle:Default:navbar.html.php'); ?>
        <?php echo $view->render('MauticCoreBundle:Notification:flashes.html.php'); ?>
    </header>
    <!--/ end: app-header -->

    <!-- start: app-footer(need to put on top of #app-content)-->
    <footer id="app-footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-6 text-muted"><?php echo $view['translator']->trans('mautic.core.copyright', ['%date%' => date('Y')]); ?></div>
                <!--<div class="col-xs-6 text-muted text-right small">v<?php
                /** @var \Mautic\CoreBundle\Templating\Helper\VersionHelper $version */
                $version = $view['version'];
                echo $version->getVersion(); ?>
                        </div>-->
            </div>
        </div>
    </footer>
    <!--/ end: app-content -->

    <!-- start: app-content -->
    <section id="app-content">
        <?php $view['slots']->output('_content'); ?>
    </section>
    <!--/ end: app-content -->

</section>
<!--/ end: app-wrapper -->

<script>

    Mautic.onPageLoad('body');
    <?php if ($app->getEnvironment() === 'dev'): ?>
    mQuery( document ).ajaxComplete(function(event, XMLHttpRequest, ajaxOption){
        if(XMLHttpRequest.responseJSON && typeof XMLHttpRequest.responseJSON.ignore_wdt == 'undefined' && XMLHttpRequest.getResponseHeader('x-debug-token')) {
            if (mQuery('[class*="sf-tool"]').length) {
                mQuery('[class*="sf-tool"]').remove();
            }

            mQuery.get(mauticBaseUrl + '_wdt/'+XMLHttpRequest.getResponseHeader('x-debug-token'),function(data){
                mQuery('body').append('<div class="sf-toolbar-reload">'+data+'</div>');
            });
        }
    });
    <?php endif; ?>
    function licenseCloseButton() {
        var x = document.getElementById("licenseclosebutton");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
</script>
<?php $view['assets']->outputScripts('bodyClose'); ?>
<?php echo $view->render('MauticCoreBundle:Helper:modal.html.php', [
    'id'            => 'MauticSharedModal',
    'footerButtons' => true,
]); ?>
</body>
</html>
