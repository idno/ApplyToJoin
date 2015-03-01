<?php

    namespace IdnoPlugins\ApplyToJoin {

        use Idno\Common\Entity;

        class Application extends Entity {

            /**
             * Sets the built-in password property to a safe hash (if the
             * password is acceptable)
             *
             * @param string $password
             * @return true|false
             */
            function setPassword($password)
            {
                if (!empty($password)) {
                    $this->password = \password_hash($password, PASSWORD_BCRYPT);

                    return true;
                }

                return false;
            }

        }

    }