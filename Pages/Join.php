<?php

    namespace IdnoPlugins\ApplyToJoin\Pages {

        use Idno\Common\Page;
        use Idno\Core\Email;
        use IdnoPlugins\ApplyToJoin\Application;

        class Join extends Page {

            function getContent() {

                $this->reverseGatekeeper();

                \Idno\Core\site()->template()->__(
                    [
                        'title' => 'Apply to join',
                        'body' => \Idno\Core\site()->template()->draw('applytojoin/account/join')
                    ]
                )->drawPage();

            }

            function postContent() {

                $this->reverseGatekeeper();

                $name       = $this->getInput('name');
                $handle     = trim($this->getInput('handle'));
                $password   = trim($this->getInput('password'));
                $email      = trim($this->getInput('email'));

                if (empty($handle) && empty($email)) {
                    \Idno\Core\site()->session()->addErrorMessage("Please enter a username and email address.");
                } else if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    if (
                        !($emailuser = \Idno\Entities\User::getByEmail($email)) &&
                        !($handleuser = \Idno\Entities\User::getByHandle($handle)) &&
                        !empty($handle) && strlen($handle) <= 32 &&
                        !substr_count($handle, '/') &&
                        \Idno\Entities\User::checkNewPasswordStrength($password)
                    ) {
                        $user         = new Application();
                        $user->email  = $email;
                        $user->handle = strtolower(trim($handle)); // Trim the handle and set it to lowercase
                        $user->setPassword($password);
                        $user->notifications['email'] = 'all';
                        if (empty($name)) {
                            $name = $user->handle;
                        }
                        $user->setTitle($name);

                        if ($user->save()) {

                            $t = clone \Idno\Core\site()->template();
                            $t->setTemplateType('email');

                            foreach(\Idno\Core\site()->getAdmins() as $admin) {
                                $email_message = new Email();
                                $email_message->setSubject("You have a new membership application!");
                                $email_message->addTo($admin->email);
                                $email_message->setHTMLBodyFromTemplate('applytojoin/new',['user' => $user]);
                                $email_message->send();
                            }

                            $this->forward(\Idno\Core\site()->config()->getDisplayURL() . 'account/join/thanks/');
                        } else {
                            var_export(\Idno\Core\site()->session()->messages);
                        }

                    } else {
                        if (empty($handle)) {
                            \Idno\Core\site()->session()->addErrorMessage("Please create a username.");
                        }
                        if (strlen($handle) > 32) {
                            \Idno\Core\site()->session()->addErrorMessage("Your username is too long.");
                        }
                        if (substr_count($handle, '/')) {
                            \Idno\Core\site()->session()->addErrorMessage("Usernames can't contain a slash ('/') character.");
                        }
                        if (!empty($handleuser)) {
                            \Idno\Core\site()->session()->addErrorMessage("Unfortunately, someone is already using that username. Please choose another.");
                        }
                        if (!empty($emailuser)) {
                            \Idno\Core\site()->session()->addErrorMessage("Hey, it looks like there's already an account with that email address. Did you forget your login?");
                        }
                        if (!\Idno\Entities\User::checkNewPasswordStrength($password)) {
                            \Idno\Core\site()->session()->addErrorMessage("Please check that your password is at least 7 characters long.");
                        }
                    }
                }

                $this->forward(\Idno\Core\site()->config()->getDisplayURL() . 'account/join/');

            }

        }

    }