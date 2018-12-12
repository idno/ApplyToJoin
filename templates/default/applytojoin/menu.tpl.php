<li <?php if (preg_match('/\/admin\/applytojoin\/$/', $_SERVER['REQUEST_URI'])) echo 'class="active"'; ?>>
    <a href="<?php echo \Idno\Core\Idno::site()->config()->url?>admin/applytojoin/">
    <?php echo \Idno\Core\Idno::site()->language()->_('Membership Applications'); ?>
    </a>
</li>
