<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/app.css">
    </head>
    <body class="font-sans bg-grey-lighter">
        <div id="app">
            <div class="w-1/5 bg-white min-h-screen shadow">
                <nav class="main-menu">
                    <a href="#" class="main-menu__item main-menu__item-active">
                        <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-4 h-4 mr-2" viewBox="0 0 20 20"><path d="M10 20a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm-5.6-4.29a9.95 9.95 0 0 1 11.2 0 8 8 0 1 0-11.2 0zm6.12-7.64l3.02-3.02 1.41 1.41-3.02 3.02a2 2 0 1 1-1.41-1.41z"/></svg>
                        Dashboard
                    </a>
                    <a href="#" class="main-menu__item">
                        <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-4 h-4 mr-2" viewBox="0 0 20 20"><path d="M3.06 2.003h-.002a.713.713 0 0 0-.712.716v10.732c0 .393.321.714.716.715 1.666.004 4.457.351 6.382 2.366V5.302a.686.686 0 0 0-.098-.363C7.766 2.394 4.73 2.007 3.06 2.003zm14.594 11.448V2.719a.713.713 0 0 0-.712-.716h-.001c-1.67.004-4.707.39-6.287 2.936a.686.686 0 0 0-.098.362v11.231c1.925-2.015 4.716-2.362 6.382-2.366a.718.718 0 0 0 .716-.715z"/><path d="M19.284 4.478h-.519v8.973a1.831 1.831 0 0 1-1.825 1.826c-1.413.004-3.742.28-5.392 1.842 2.853-.7 5.862-.245 7.576.146a.714.714 0 0 0 .876-.698V5.194a.716.716 0 0 0-.716-.716zm-18.05 8.973V4.478H.716A.716.716 0 0 0 0 5.194v11.373a.714.714 0 0 0 .876.697c1.714-.39 4.723-.844 7.576-.146-1.65-1.561-3.98-1.837-5.393-1.84a1.83 1.83 0 0 1-1.825-1.827z"/></g></svg>
                        Courses
                    </a>
                    <a href="#" class="main-menu__item">
                        <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-4 h-4 mr-2" viewBox="0 0 20 20"><path d="M7 8a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0 1c2.15 0 4.2.4 6.1 1.09L12 16h-1.25L10 20H4l-.75-4H2L.9 10.09A17.93 17.93 0 0 1 7 9zm8.31.17c1.32.18 2.59.48 3.8.92L18 16h-1.25L16 20h-3.96l.37-2h1.25l1.65-8.83zM13 0a4 4 0 1 1-1.33 7.76 5.96 5.96 0 0 0 0-7.52C12.1.1 12.53 0 13 0z"/></svg>
                        Users
                    </a>
                    <a href="#" class="main-menu__item">
                        <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-4 h-4 mr-2" viewBox="0 0 20 20"><path d="M3.94 6.5L2.22 3.64l1.42-1.42L6.5 3.94c.52-.3 1.1-.54 1.7-.7L9 0h2l.8 3.24c.6.16 1.18.4 1.7.7l2.86-1.72 1.42 1.42-1.72 2.86c.3.52.54 1.1.7 1.7L20 9v2l-3.24.8c-.16.6-.4 1.18-.7 1.7l1.72 2.86-1.42 1.42-2.86-1.72c-.52.3-1.1.54-1.7.7L11 20H9l-.8-3.24c-.6-.16-1.18-.4-1.7-.7l-2.86 1.72-1.42-1.42 1.72-2.86c-.3-.52-.54-1.1-.7-1.7L0 11V9l3.24-.8c.16-.6.4-1.18.7-1.7zM10 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/></svg>
                        Settings
                    </a>
                </nav>
            </div>

            <div class="w-4/5"></div>
        </div>
    </body>
</html>
