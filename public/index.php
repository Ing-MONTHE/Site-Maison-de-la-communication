case 'auth':
    $ctrl = new AuthController();
    if ($action === 'login') $ctrl->login();
    elseif ($action === 'logout') $ctrl->logout();
    elseif ($action === 'registerForm') $ctrl->registerForm();
    elseif ($action === 'register') $ctrl->register();
    else $ctrl->showLogin();
    break;
