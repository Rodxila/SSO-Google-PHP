# SSO con Google en PHP 🧠

Este proyecto permite iniciar sesión con Google usando PHP y Docker.

ES NECESARIO TENER INSTALADO DOCKER 

## 🚀 Cómo arrancarlo

1. Clona el repositorio:
   ```bash
   git clone https://github.com/Rodxila/sso-google-php.git
   cd sso-google-php

2. Cómo obtener el GOOGLE_CLIENT_ID y GOOGLE_CLIENT_SECRET

    Abrir Google Cloud Console: https://console.cloud.google.com/

    Crear o seleccionar un proyecto.

    Configurar la pantalla de consentimiento (OAuth Consent Screen):

    En el menú lateral selecciona "APIs y servicios" → "Pantalla de consentimiento OAuth".
    Elige tipo "Externa" (si el proyecto será usado por cualquier cuenta) o "Interna" (solo cuentas de la organización).
    Rellena el nombre de la aplicación, correo de soporte y dominios autorizados si se solicita.
    Añade los scopes básicos: openid, email, profile (suelen ser suficientes para este ejemplo).
    Crear credenciales OAuth 2.0:

    En el menú lateral selecciona "APIs y servicios" → "Credenciales" → "Crear credenciales" → "ID de cliente de OAuth".
    Tipo de aplicación: "Aplicación web".
    En "Orígenes de JavaScript autorizados" añade: http://localhost:9778
    En "URI de redireccionamiento autorizados" añade: http://localhost/sso-google-php/public/callback.php
    Crear y copia el Client ID y el Client secret que te proporcione la consola.
    Pegar las credenciales en tu .env local

    Crea el archivo .env en la raíz del proyecto y añade/actualiza:
    GOOGLE_CLIENT_ID=tu-client-id-aqui.apps.googleusercontent.com
    GOOGLE_CLIENT_SECRET=tu-client-secret-aqui

3. Arranca el proyecto:

    docker-compose up --build


4. Abre en el navegador:


    http://localhost/sso-google-php/public/index.php


🧰 Requisitos
Docker

Docker Compose

Credenciales OAuth2 de Google configuradas para http://localhost/sso-google-php/callback.php

📦 Dependencias
google/apiclient

vlucas/phpdotenv

🧼 Para cerrar sesión
Visita logout.php para destruir la sesión.
