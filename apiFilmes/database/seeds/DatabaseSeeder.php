<?php

use Illuminate\Database\Seeder;
use App\Http\Models\Usuario;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usuario')->delete();

        Usuario::create([
            'nmUsuario'=>'admin',
            'dsSenha'=> sha1( env('KEY_APP_API') . 'admin'),
            'email'=>env('MAIL_USERNAME'),
            'confirmado'=>1,
            'tokenCompleto'=>sha1('admin'. env('MAIL_USERNAME') ) . env('KEY_APP_API'),
            'tokenUsuario'=>sha1('admin'. env('MAIL_USERNAME') ),
            'cdPermissao'=>1
        ]);
    }
}