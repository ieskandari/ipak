<label class="<?php echo $ViewData["LabelClass"]; ?>"><?php echo $ViewData["TitleLabel"]; ?></label>
<?php if (isset($ViewData["InputHelp"]) && strlen($ViewData["InputHelp"]) > 0) {
?> <i data-help="<?php echo $ViewData["InputHelp"]; ?>" class="fa fa-question-circle help-tooltip" aria-hidden="true"></i>
<?php } ?>