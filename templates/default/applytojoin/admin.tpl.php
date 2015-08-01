<div class="row">

    <div class="col-md-10 col-md-offset-1">
        <?= $this->draw('admin/menu') ?>
        <h1>
            Membership Applications
        </h1>
    </div>
    <div class="col-md-10 col-md-offset-1">

        <p class="explanation">
            <?php

                if (empty($vars['applications'])) {
                    ?>
                    You have no outstanding membership applications.
                    <?php
                } else {
                    ?>
                    The following people have applied to join <?=\Idno\Core\site()->config()->getTitle()?>:
                    <?php
                }

            ?>
        </p>

    </div>
    <?php

        if (!empty($vars['applications'])) {

?>
    <div class="row">
        <div class="pane col-md-10 col-md-offset-1">
    <?php

            foreach($vars['applications'] as $user) {

                if ($user instanceof \IdnoPlugins\ApplyToJoin\Application) {

                    ?>

                    <div class="row <?= strtolower(str_replace('\\', '-', get_class($user))); ?>">
                        <div class="col-md-3">
                            <p>
                                <?= htmlentities($user->getTitle()) ?></a> (<a href="<?= $user->getDisplayURL() ?>"><?=$user->handle?></a>)<br>
                                <small><?= $user->email ?></small>
                            </p>
                        </div>
                        <div class="col-md-2">
                            <p>
                                <small><strong>Applied</strong><br><time datetime="<?= date('r', $user->created) ?>" class="dt-published"><?= date('r', $user->created) ?></time></small>
                            </p>
                        </div>
                        <div class="col-md-1">
                            <p style="padding-top: 20px;"><small>
                                    <?php
                                        echo \Idno\Core\site()->actions()->createLink(\Idno\Core\site()->config()->getDisplayURL() . 'admin/applytojoin/', '<i class="icon-plus"></i> Approve', array('user' => $user->getUUID(), 'action' => 'approve'), array('class' => '', 'confirm' => true, 'confirm-text' => 'Are you sure? This will approve this user and allow them to access the site.'));
                                    ?>
                                </small></p>
                        </div>
                        <div class="col-md-1">
                            <p style="padding-top: 20px;"><small>
                                    <?php
                                        echo \Idno\Core\site()->actions()->createLink(\Idno\Core\site()->config()->getDisplayURL() . 'admin/applytojoin/', '<i class="icon-minus"></i> Delete', array('user' => $user->getUUID(), 'action' => 'delete'), array('class' => '', 'confirm' => true, 'confirm-text' => 'Are you sure? This will remove this application. The user will not be emailed.'));
                                    ?>
                                </small></p>
                        </div>
                    </div>

                    <?php

                }

            }

        ?>
        </div>
    </div>
    <?php

        }

    ?>

</div>