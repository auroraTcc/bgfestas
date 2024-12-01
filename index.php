<?php
    session_start();
    $rootPath = __DIR__;
    $isLocal = strpos($_SERVER['HTTP_HOST'], 'localhost') !== false;

    require_once "$rootPath/app/config/conexao.php";

    $routes = [
        "" => "$rootPath/app/view/index.php",
        "fazerpedido" => "$rootPath/app/view/fazerpedido/index.php",
    
        "admin" => "$rootPath/app/view/admin/index.php",
        "admin/clientes" => "$rootPath/app/view/admin/clientes/index.php",
        "admin/funcionarios" => "$rootPath/app/view/admin/funcionarios/index.php",
        "admin/login" => "$rootPath/app/view/admin/login/index.php",
        "admin/tarefas" => "$rootPath/app/view/admin/tarefas/index.php",
        "admin/tarefas/finalizadas" => "$rootPath/app/view/admin/tarefas/finalizadas/index.php",
    
        "controllers/processLogin" => "$rootPath/app/controllers/processLogin.php",
        "controllers/processPedido" => "$rootPath/app/controllers/processPedido.php",
        "controllers/processDesconectar" => "$rootPath/app/controllers/processDesconectar.php",
        "controllers/processAlterarFuncResponsavel" => "$rootPath/app/controllers/processAlterarFuncResponsavel.php",
        "controllers/processAlterarSenha" => "$rootPath/app/controllers/processAlterarSenha.php",
        "controllers/processAtualizarCadastro" => "$rootPath/app/controllers/processAtualizarCadastro.php",
        "controllers/processAtualizarStatusDoPedido" => "$rootPath/app/controllers/processAtualizarStatusDoPedido.php",
        "controllers/processDeleteFunc" => "$rootPath/app/controllers/processDeleteFunc.php",
        "controllers/processDeletePedido" => "$rootPath/app/controllers/processDeletePedido.php",
        "controllers/processForgotPassword" => "$rootPath/app/controllers/processForgotPassword.php",
        "controllers/processGetAllBairros" => "$rootPath/app/controllers/processGetAllBairros.php",
        "controllers/processGetAllClients" => "$rootPath/app/controllers/processGetAllClients.php",
        "controllers/processGetAllFuncs" => "$rootPath/app/controllers/processGetAllFuncs.php",
        "controllers/processInserirFunc" => "$rootPath/app/controllers/processInserirFunc.php",
        
        "404" => "$rootPath/app/view/errors/404.html"
    ];

    

    function adminRouteVerification($requestUri, $isLocal, $routes, $conn) {
        $isLogged = isset($_SESSION["funcionario"]);
    
        if (!$isLogged) {
            $_SESSION["goTo"] = $requestUri;
            $redirectKey = $isLocal ? "bgfestas/admin/login" : "admin/login";
            include_once $routes[$redirectKey];
            exit;
        }
    
        if ($requestUri === ($isLocal ? "bgfestas/admin/login" : "admin/login")) {
            header("Location: " . ($isLocal ? "/bgfestas/admin" : "/admin"));
            exit;
        }
    }

    if ($isLocal) {
        $newRoutes = [];
        foreach ($routes as $key => $value) {
            if($key === "") {
                $newKey = "bgfestas$key"; 
                $newRoutes[$newKey] = $value; 
            }

            $newKey = "bgfestas/$key"; 
            $newRoutes[$newKey] = $value; 
        }
        $routes = $newRoutes; 
    }

   
    
    spl_autoload_register(
        function ($class) use ($rootPath) { 
            
                $iterator = new RecursiveIteratorIterator(  new RecursiveDirectoryIterator($rootPath), RecursiveIteratorIterator::SELF_FIRST );
                foreach ($iterator as $file) {
                if ($file->isFile() && $file->getExtension() === 'php') {
                    if (pathinfo($file->getFilename(), PATHINFO_FILENAME) === strtolower($class)) {
                        
                        require_once $file->getPathname();
                        return;

                    }
                }
            }
            http_response_code(500);
            echo json_encode([
                'error' => true,
                'message' => "Classe '{$class}' não encontrada!"
            ]);
            exit;
        }
    );
    $requestUri = trim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH), '/');
    
    if (preg_match($isLocal ? "/^bgfestas\/admin\/tarefas\/(\d+)$/" : '/^admin\/tarefas\/(\d+)$/', $requestUri, $matches)) {
        adminRouteVerification($requestUri, $isLocal, $routes, $conn);
        $_GET['id'] = $matches[1];

        $user = new Funcionario($conn);
        $user->populate($_SESSION["funcionario"]);

        include_once "$rootPath/app/view/admin/tarefas/detalhes/index.php";
        exit;
    }
    
    if (preg_match($isLocal ? "/^bgfestas\/recibo\/(\d+)$/" : '/^recibo\/(\d+)$/', $requestUri, $matches)) {
        adminRouteVerification($requestUri, $isLocal, $routes, $conn);
        $_GET['id'] = $matches[1];

        $user = new Funcionario($conn);
        $user->populate($_SESSION["funcionario"]);

        include_once "$rootPath/app/controllers/processGerarRecibo.php";
        exit;
    }

    if (array_key_exists($requestUri, $routes)) {
        if (str_starts_with($requestUri, $isLocal ? "bgfestas/admin" : "admin")) {
            adminRouteVerification($requestUri, $isLocal, $routes, $conn);
            $user = new Funcionario($conn);
            $user->populate($_SESSION["funcionario"]);
        }
        include_once $routes[$requestUri];
    } else {
        http_response_code(404);
        include_once $routes[$isLocal ? "bgfestas/404" : "404"];
    }




    

