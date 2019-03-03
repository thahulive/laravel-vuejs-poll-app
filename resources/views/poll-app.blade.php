<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons" rel="stylesheet">
    <!-- <link href="https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.min.css" rel="stylesheet"> -->
</head>
<body>
    <div id="app">
        <v-app>
            <v-toolbar app>
                <v-toolbar-title>
                    {{ config('app.name', 'Easy Poll') }}
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-items class="hidden-sm-and-down">
                    <v-btn flat to="/">Home</v-btn>
                    <v-btn flat to="/create">Create</v-btn>
                    <v-btn flat onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">Log Out</v-btn>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </v-toolbar-items>
            </v-toolbar>
            <v-content>
                <router-view></router-view>
            </v-content>
        </v-app>
    </div>
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
