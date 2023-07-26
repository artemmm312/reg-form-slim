<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Modules\MainPage\MainPage;
use App\Modules\RegistrationPage\RegistrationPage;
use App\Modules\RegistrationPage\RegistrationForm;
use App\Modules\AuthorizationPage\AuthorizationPage;
use App\Modules\AuthorizationPage\AuthorizationForm;
use App\Modules\LogOut\LogOut;


$app->get('/', MainPage::class);

$app->get('/registration', RegistrationPage::class)->setName('registration');
$app->post('/registration', RegistrationForm::class);

$app->get('/authorization', AuthorizationPage::class)->setName('authorization');
$app->post('/authorization', AuthorizationForm::class);

$app->get('/account', function (Request $request, Response $response) {
	$session = $this->get('session');
	$user = $session->get('user');
	if ($user && $user['authenticated']) {
		return $this->get('view')->render($response, 'account.twig', ['title' => 'Личный кабинет', 'Username' => $user['username']]);
	}
	return $response->withHeader('Location', SLIM_APP_BASEPATH . '/authorization')->withStatus(302);
});
$app->post('/account', LogOut::class);
