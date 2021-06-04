<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\noticia;

class NoticiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        noticia::truncate();
        
        noticia::create([
            'idJuego' => 1,
            'noticia' => 'Kiimpy se pone a mandos de Syndra, pero no consigue nada, ¿por que? Dicen por ahí que el jungla del equipo Marpe, le hace mas KS con su Nocturne "Terror helado" que un Maestro Yi dandole a la Q. En su ulti esconde más daño que la ulti del Mordekaiser. La estela de su Q le da más velocidad de movimiento que el cañon de Jinx, es una bala.',
            'ultima' => 1,
        ],);
        noticia::create([
            'idJuego' => 2,
            'noticia' => 'Última Hora. Camikaze readmitido en el equipo de Valorant de Glitch Gaming debido a que ha pedido disculpas al fundador Kiimpy, tras el envío de un mensaje ofensivo. El jugador está en su momento crítico, ya que si continua haciendo el gamberro, será expulsado permanentemente del club de eSports.',
            'ultima' => 1,
        ],);
    }
}
