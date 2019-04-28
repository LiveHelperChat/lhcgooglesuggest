<h1 class="attr-header"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/googlesuggest','Google Suggest Options');?></h1>

<form action="" method="post">

    <?php include(erLhcoreClassDesign::designtpl('lhkernel/csfr_token.tpl.php'));?>

    <?php if (isset($errors)) : ?>
        <?php include(erLhcoreClassDesign::designtpl('lhkernel/validation_error.tpl.php'));?>
    <?php endif; ?>

    <?php if (isset($updated) && $updated == 'done') : $msg = erTranslationClassLhTranslation::getInstance()->getTranslation('chat/onlineusers','Settings updated'); ?>
        <?php include(erLhcoreClassDesign::designtpl('lhkernel/alert_success.tpl.php'));?>
    <?php endif; ?>

    <div class="form-group">
        <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/googlesuggest','Key');?></label>
        <input class="form-control" type="text" name="key" value="<?php (isset($gs_options['key'])) ? print htmlspecialchars($gs_options['key']) : print ''?>" />
        <p><i><small><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/googlesuggest','Google Search API Key (key)');?></small></i></p>
    </div>

    <div class="form-group">
        <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/googlesuggest','Search ID')?></label>
        <input class="form-control" type="text" name="cx" value="<?php (isset($gs_options['cx'])) ? print htmlspecialchars($gs_options['cx']) : print ''?>" />
        <p><i><small><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/googlesuggest','Google Search ID (cx)');?></small></i></p>
    </div>

    <div class="form-group">
        <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/googlesuggest','Field')?></label>
        <input class="form-control" type="text" name="fields" value="<?php (isset($gs_options['fields'])) ? print htmlspecialchars($gs_options['fields']) : print 'items(title,link)'?>" />
        <p><i><small><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/googlesuggest','If you are modifying extension and want to tweak what is shown. You can change fetched fields from google search');?></small></i></p>
    </div>

    <div class="form-group">
        <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/googlesuggest','Referrer')?></label>
        <input class="form-control" type="text" name="referrer" value="<?php (isset($gs_options['referrer'])) ? print htmlspecialchars($gs_options['referrer']) : print ''?>" />
        <p><i><small><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/googlesuggest','For security reason you can set Referrer for API Key');?></small></i></p>
    </div>

    <input type="submit" class="btn btn-secondary" name="StoreOptions" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('system/buttons','Save'); ?>" />

</form>
