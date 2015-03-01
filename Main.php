<?php

    namespace IdnoPlugins\ApplyToJoin {

        use Idno\Common\Plugin;

        class Main extends Plugin {

            function registerPages() {

                // Hijack the registration page to create an "apply to register" page
                \Idno\Core\site()->addPageHandler('account/join/?','IdnoPlugins\ApplyToJoin\Pages\Join', true);

                // Application confirmation page
                \Idno\Core\site()->addPageHandler('account/join/thanks/?','IdnoPlugins\ApplyToJoin\Pages\Thanks', true);

                // Create an admin panel
                \Idno\Core\site()->addPageHandler('admin/applytojoin/?','IdnoPlugins\ApplyToJoin\Pages\Admin');

                // Now extend the toolbar when we're logged out, if we need to
                if (!\Idno\Core\site()->session()->isLoggedIn() && empty(\Idno\Core\site()->config()->open_registration)) {
                    \Idno\Core\site()->template()->extendTemplate('shell/toolbar/logged-out/items','applytojoin/toolbar');
                }

                // Extend the admin menu
                \Idno\Core\site()->template()->extendTemplate('admin/menu/items','applytojoin/menu');

                // Extend the login page
                \Idno\Core\site()->template()->extendTemplate('session/login','applytojoin/login');

            }

        }

    }