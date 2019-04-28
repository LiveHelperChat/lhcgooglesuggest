<?php if (erLhcoreClassUser::instance()->hasAccessTo('lhcgooglesuggest','use_admin')) : ?>
<li class="nav-item"><a class="nav-link" href="<?php echo erLhcoreClassDesign::baseurl('googlesuggest/index')?>"><i class="material-icons">comment</i><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/googlesuggest','Google Suggest');?></a></li>
<?php endif; ?>