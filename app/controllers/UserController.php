<?php
class UserController extends ControllerBase
{
    public function facebookAction()
    {
        $facebook_id = $this->facebook->getUser();

        if (!$facebook_id) {
            $this->flash->error("Invalid Facebook Call.");

            return $this->response->redirect('login');
        }
        try {
            $facebook_user = $this->facebook->api('/me');
        } catch (\FacebookApiException $e) {
            $this->flash->error("Could not fetch your facebook user.");
        }
        $user = Users::findByKey($facebook_user['email']);
        if (!$user) {
            $user = new Users();
            $user->assign([
                    'fbid'         =>$facebook_user['id'],
                    'display_name' => $facebook_user['name'],
                    'username'     => $facebook_user['email'],
                    'email'        => $facebook_user['email'],
                    'password'     => $this->security->hash(Phalcon\Text::random(Phalcon\Text::RANDOM_ALNUM, 8)),
                ]
            );
            if ($user->save()) {
                $this->authUserById($user->id);

                return $this->response->redirect('index/cart');
            } else {
                $this->flash->error('There was an error connecting your facebook user.');
            }
        } else {
            $this->authUserById($user->id);
            return $this->response->redirect('index/cart');
        }
    }

    /**
     * Auths the user by his/her id
     *
     * @param int $id
     * @throws Phalcon\Exception
     */
    public function authUserById($id)
    {
        $user = Users::findFirst($id);
        if ($user == false) {
            throw new Exception('The user does not exist');
        }

        $this->session->set('auth-identity', [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
        ]);
    }
}