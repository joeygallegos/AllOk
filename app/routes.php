<?php
use App\Controllers\DeepLinkController;
$app->get('/deeplink/{token}', DeepLinkController::class . ':getDeepLink');