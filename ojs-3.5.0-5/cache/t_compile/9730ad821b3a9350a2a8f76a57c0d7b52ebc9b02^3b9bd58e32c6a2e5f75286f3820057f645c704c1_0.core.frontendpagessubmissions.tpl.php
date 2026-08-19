<?php
/* Smarty version 4.5.5, created on 2026-08-19 16:38:58
  from 'core:frontendpagessubmissions.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.5.5',
  'unifunc' => 'content_6a8587c2c301a2_49791622',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3b9bd58e32c6a2e5f75286f3820057f645c704c1' => 
    array (
      0 => 'core:frontendpagessubmissions.tpl',
      1 => 1782879935,
      2 => 'core',
    ),
  ),
  'includes' => 
  array (
    'app:frontend/components/header.tpl' => 1,
    'app:frontend/components/breadcrumbs.tpl' => 1,
    'app:frontend/components/editLink.tpl' => 4,
    'app:frontend/components/footer.tpl' => 1,
  ),
),false)) {
function content_6a8587c2c301a2_49791622 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("app:frontend/components/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('pageTitle'=>"about.submissions"), 0, false);
?>

<div class="page page_submissions">
	<?php $_smarty_tpl->_subTemplateRender("app:frontend/components/breadcrumbs.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('currentTitleKey'=>"about.submissions"), 0, false);
?>
	<h1>
		<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"about.submissions"),$_smarty_tpl ) );?>

	</h1>

	<div class="cmp_notification">
		<?php if (call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'count' ][ 0 ], array( $_smarty_tpl->tpl_vars['sections']->value )) == 0 || $_smarty_tpl->tpl_vars['currentContext']->value->getData('disableSubmissions')) {?>
			<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"author.submit.notAccepting"),$_smarty_tpl ) );?>

		<?php } else { ?>
			<?php if ($_smarty_tpl->tpl_vars['isUserLoggedIn']->value) {?>
				<?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', "newSubmission", null);?><a href="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('page'=>"submission"),$_smarty_tpl ) );?>
"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"about.onlineSubmissions.newSubmission"),$_smarty_tpl ) );?>
</a><?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
				<?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', "viewSubmissions", null);?><a href="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('page'=>"submissions"),$_smarty_tpl ) );?>
"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"about.onlineSubmissions.viewSubmissions"),$_smarty_tpl ) );?>
</a><?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
				<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"about.onlineSubmissions.submissionActions",'newSubmission'=>$_smarty_tpl->tpl_vars['newSubmission']->value,'viewSubmissions'=>$_smarty_tpl->tpl_vars['viewSubmissions']->value),$_smarty_tpl ) );?>

			<?php } else { ?>
				<?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', "login", null);?><a href="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('page'=>"login"),$_smarty_tpl ) );?>
"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"about.onlineSubmissions.login"),$_smarty_tpl ) );?>
</a><?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
				<?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', "register", null);?><a href="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('page'=>"user",'op'=>"register"),$_smarty_tpl ) );?>
"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"about.onlineSubmissions.register"),$_smarty_tpl ) );?>
</a><?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
				<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"about.onlineSubmissions.registrationRequired",'login'=>$_smarty_tpl->tpl_vars['login']->value,'register'=>$_smarty_tpl->tpl_vars['register']->value),$_smarty_tpl ) );?>

			<?php }?>
		<?php }?>
	</div>

	<?php if ($_smarty_tpl->tpl_vars['currentContext']->value->getLocalizedData('authorGuidelines')) {?>
	<div class="author_guidelines" id="authorGuidelines">
		<h2>
			<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"about.authorGuidelines"),$_smarty_tpl ) );?>

			<?php $_smarty_tpl->_subTemplateRender("app:frontend/components/editLink.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('page'=>"management",'op'=>"settings",'path'=>"workflow",'anchor'=>"submission/instructions",'sectionTitleKey'=>"about.authorGuidelines"), 0, false);
?>
		</h2>
		<?php echo $_smarty_tpl->tpl_vars['currentContext']->value->getLocalizedData('authorGuidelines');?>

	</div>
	<?php }?>

	<?php if ($_smarty_tpl->tpl_vars['submissionChecklist']->value) {?>
		<div class="submission_checklist">
			<h2>
				<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"about.submissionPreparationChecklist"),$_smarty_tpl ) );?>

				<?php $_smarty_tpl->_subTemplateRender("app:frontend/components/editLink.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('page'=>"management",'op'=>"settings",'path'=>"workflow",'anchor'=>"submission/instructions",'sectionTitleKey'=>"about.submissionPreparationChecklist"), 0, true);
?>
			</h2>
			<?php echo $_smarty_tpl->tpl_vars['submissionChecklist']->value;?>

		</div>
	<?php }?>

	<?php if ((isset($_smarty_tpl->tpl_vars['submissionChecklistAfterContent']->value))) {?>
		<?php echo $_smarty_tpl->tpl_vars['submissionChecklistAfterContent']->value;?>

	<?php }?>

	<?php if ($_smarty_tpl->tpl_vars['currentContext']->value->getLocalizedData('copyrightNotice')) {?>
		<div class="copyright_notice">
			<h2>
				<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"about.copyrightNotice"),$_smarty_tpl ) );?>

				<?php $_smarty_tpl->_subTemplateRender("app:frontend/components/editLink.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('page'=>"management",'op'=>"settings",'path'=>"workflow",'anchor'=>"submission/instructions",'sectionTitleKey'=>"about.copyrightNotice"), 0, true);
?>
			</h2>
			<?php echo $_smarty_tpl->tpl_vars['currentContext']->value->getLocalizedData('copyrightNotice');?>

		</div>
	<?php }?>

	<?php if ($_smarty_tpl->tpl_vars['currentContext']->value->getLocalizedData('privacyStatement')) {?>
	<div class="privacy_statement" id="privacyStatement">
		<h2>
			<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['translate'][0], array( array('key'=>"about.privacyStatement"),$_smarty_tpl ) );?>

			<?php $_smarty_tpl->_subTemplateRender("app:frontend/components/editLink.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('page'=>"management",'op'=>"settings",'path'=>"website",'anchor'=>"setup/privacy",'sectionTitleKey'=>"about.privacyStatement"), 0, true);
?>
		</h2>
		<?php echo $_smarty_tpl->tpl_vars['currentContext']->value->getLocalizedData('privacyStatement');?>

	</div>
	<?php }?>

</div><!-- .page -->

<?php $_smarty_tpl->_subTemplateRender("app:frontend/components/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
