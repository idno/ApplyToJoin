<?php

    namespace IdnoPlugins\ApplyToJoin\Pages {

        use Idno\Common\Page;
        use Idno\Core\Email;
        use Idno\Core\Idno;
        use IdnoPlugins\ApplyToJoin\Application;

        class Admin extends Page {

            function getContent() {

                $this->adminGatekeeper();

                $applications = Application::get([],[],9999,0);

                \Idno\Core\site()->template()->__([

                    'title' => 'Membership applications',
                    'body' => \Idno\Core\site()->template()->__([
                        'applications' => $applications
                    ])->draw('applytojoin/admin')

                ])->drawPage();

            }

            function postContent() {

                $this->adminGatekeeper();

                $user_uuid = $this->getInput('user');
                $action = $this->getInput('action');

                $user = Application::getByUUID($user_uuid);

                if ($user instanceof Application) {

                    $name = $user->getTitle();
                    $handle = $user->handle;
                    $email = $user->email;

                    switch($action) {

                        case 'approve':
                            if (
                                !($emailuser = \Idno\Entities\User::getByEmail($email)) &&
                                !($handleuser = \Idno\Entities\User::getByHandle($handle)) &&
                                !empty($handle) && strlen($handle) <= 32 &&
                                !substr_count($handle, '/')
                            ) {
                                $real_user = new \Idno\Entities\User();
                                $real_user->setHandle($user->handle);
                                $real_user->email = $user->email;
                                $real_user->password = $user->password;
                                $real_user->setTitle($user->getTitle());
                                if ($real_user->save()) {
                                    $user->delete();

                                    $email_message = new Email();
                                    $email_message->setSubject("Your membership was approved!");
                                    $email_message->addTo($real_user->email);
                                    $email_message->setHTMLBodyFromTemplate('applytojoin/approved',['user' => $real_user]);
                                    $email_message->send();

                                    \Idno\Core\site()->session()->addMessage("{$name}'s membership application was approved. They can now log into the site.");
                                } else {
                                    \Idno\Core\site()->session()->addMessage("Something went wrong and we weren't able to approve {$name}'s membership application.");
                                }
                            } else {
                                \Idno\Core\site()->session()->addMessage("We couldn't approve {$name}'s application. Either their handle or their email was invalid or in use.");
                            }
                            break;
                        case 'delete':
                            $user->delete();
                            \Idno\Core\site()->session()->addMessage("{$name}'s membership application was deleted.");
                            break;

                    }

                }

                $this->forward(\Idno\Core\site()->config()->getDisplayURL() . 'admin/applytojoin/');

            }

        }

    }