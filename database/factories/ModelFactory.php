<?php


    $factory->define(App\User::class, function (Faker\Generator $faker) {
        static $password;

        return [
            'username' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'password' => $password ?: $password = bcrypt('secret'),
            'dpi' => null,
            'nombre1' => null,
            'nombre2' => null,
            'nombre3' => null,
            'apellido1' => null,
            'apellido2' => null,
            'apellido3' => null,
            'departamento_id' => null,
            'municipio_id' => null,
            'direccion' => null,
            'fecha_nacimiento' => null,
            'fecha_ingreso' => null,
            'telefono' => null,
            //'foto' => null,
            'rol_id' => null,
            'fecha_egreso' => null,
            'estado_id' => null,
            'remember_token' => str_random(10),
        ];
    });

    $factory->define(App\Bitacora::class, function (Faker\Generator $faker) {
        static $password;

        return [
            'usuario' => null,
            'nombre_tabla' => null,
            'actividad' => null,
            'anterior' => null,
            'nuevo' => null,
            'fecha' => null,
        ];
    });

    $factory->define(App\Rol::class, function (Faker\Generator $faker) {
        static $password;

        return [
            'nombre' => null,
            'descripcion' => null,
        ];
    });

    $factory->define(App\Estado::class, function (Faker\Generator $faker) {
        static $password;

        return [
            'nombre' => null,
            'descripcion' => null,
        ];
    });

    $factory->define(App\Terapia::class, function (Faker\Generator $faker) {
        static $password;

        return [
            'nombre' => null,
            'descripcion' => null,
        ];
    });

    $factory->define(App\DiaSemana::class, function (Faker\Generator $faker) {
        static $password;

        return [
            'nombre' => null,
        ];
    });

    $factory->define(App\Departamento::class, function (Faker\Generator $faker) {
        static $password;

        return [
            'nombre' => null,
        ];
    });

    $factory->define(App\Municipio::class, function (Faker\Generator $faker) {
        static $password;

        return [
            'nombre' => null,
            'departamento_id' => null,
        ];
    });

    $factory->define(App\UsuarioTerapia::class, function (Faker\Generator $faker) {
        static $password;

        return [
            'user_id' => null,
            'terapia_id' => null,
        ];
    });

    $factory->define(App\UsuarioDia::class, function (Faker\Generator $faker) {
        static $password;

        return [
            'diasemana_id' => null,
            'user_id' => null,
        ];
    });