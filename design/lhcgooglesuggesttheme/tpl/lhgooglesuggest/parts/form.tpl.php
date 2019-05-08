<div class="form-group">
    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/googlesuggest','Name');?></label>
    <input type="text" maxlength="250" class="form-control" name="name" value="<?php echo htmlspecialchars($item->name)?>" />
</div>

<div class="form-group">
    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/googlesuggest','Identifier');?></label>
    <input type="text" maxlength="250" class="form-control" name="identifier" value="<?php echo htmlspecialchars($item->identifier)?>" />
</div>

<div class="form-group">
    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/googlesuggest','Key');?></label>
    <input class="form-control" type="text" name="key" value="<?php (isset($item->configuration_array['key'])) ? print htmlspecialchars($item->configuration_array['key']) : print ''?>" />
    <p><i><small><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/googlesuggest','Google Search API Key (key)');?></small></i></p>
</div>

<div class="form-group">
    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/googlesuggest','Search ID');?></label>
    <input type="text" maxlength="250" class="form-control" name="search_id" value="<?php echo htmlspecialchars($item->search_id)?>" />
    <p><i><small><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/googlesuggest','Google Search ID (cx)');?></small></i></p>
</div>

<div class="form-group">
    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/googlesuggest','Field');?></label>
    <input type="text" maxlength="250" class="form-control" name="field" value="<?php echo htmlspecialchars($item->field)?>" />
</div>

<div class="form-group">
    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/googlesuggest','Referrer');?></label>
    <input type="text" maxlength="250" class="form-control" name="referrer" value="<?php echo htmlspecialchars($item->referrer)?>" />
    <p><i><small><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/googlesuggest','For security reason you can set Referrer for API Key');?></small></i></p>
</div>

<div class="form-group">
    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/googlesuggest','Custom arguments');?></label>
    <textarea class="form-control" name="custom_arguments" placeholder="Argument Key==Arguments Value"><?php echo htmlspecialchars($item->custom_arguments)?></textarea>
    <p>
        <i><small><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/googlesuggest','Each argument should go on new line');?> E.g siteSearch==example.com</small></i>
        <br/><small>See <a href="https://developers.google.com/custom-search/v1/cse/list">here</a> for possible arguments</small>
    </p>
</div>


