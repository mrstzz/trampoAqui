<?php
// routes.php

/**
 * ROTAS DA APLICAÇÃO TrampoAqui
 * @author Matheus Montovaneli
 * @since 27/10/2025
 */

// A variável $router é definida em public/index.php antes de incluir este arquivo.
// Use $router->get() e $router->post() para definir as rotas.

// Rotas Gerais / Home
$router->get('', 'HomeController@index'); // Rota para a página inicial

// Rotas de Autenticação (Cliente)
$router->get('login', 'AuthController@showLoginForm'); // Exibe form de login
$router->post('login', 'AuthController@processLogin'); // Processa o login
$router->get('signup', 'AuthController@showSignupForm'); // Exibe form de cadastro
$router->post('signup', 'AuthController@processSignup'); // Processa o cadastro
$router->get('logout', 'AuthController@logout'); // Rota para deslogar

// Rotas do Painel do Cliente (EM DESENVOLVIMENTO)
$router->get('painel-cliente', 'ClienteController@dashboard'); // Exemplo, criar ClienteController


// Rotas do Comerciante (EM DESENVOLVIMENTO)

$router->get('painel-comerciante', 'ComercianteController@dashboard');
$router->get('comerciante/perfil/editar', 'ComercianteController@editProfileForm');
$router->post('comerciante/perfil/salvar', 'ComercianteController@saveProfile');



// Rotas de Pesquisa (EM DESENVOLVIMENTO)

$router->post('pesquisar', 'PesquisaController@buscar'); // Usando POST



// Rota para ver perfil público (Com parâmetro ID)

$router->get('perfil/(\d+)', 'HomeController@verPerfil');


?>