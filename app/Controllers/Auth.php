<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\AuthModel;

class Auth extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function create()
    {
        $model = new AuthModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $login = $model->doLogin($username, $password);

        return $this->respond($login);
    }

}


?>