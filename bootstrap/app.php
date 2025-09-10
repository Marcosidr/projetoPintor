<?php
// bootstrap/app.php

session_start();

// Carrega configurações
require ROOT_PATH . 'app/Core/Config.php';

// Carrega rotas
require ROOT_PATH . 'routes/web.php';
