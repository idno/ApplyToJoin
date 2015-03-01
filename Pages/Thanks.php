<?php

    namespace IdnoPlugins\ApplyToJoin\Pages {

        use Idno\Common\Page;

        class Thanks extends Page {

            function getContent() {

                $this->reverseGatekeeper();

                \Idno\Core\site()->template()->__([

                    'title' => 'Thank you!',
                    'body' => \Idno\Core\site()->template()->draw('applytojoin/account/thanks')

                ])->drawPage();

            }

        }

    }