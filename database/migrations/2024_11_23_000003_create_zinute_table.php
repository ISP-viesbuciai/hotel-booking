<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('zinute', function (Blueprint $table) {
            $table->increments('id')->primary();
            $table->string('tekstas')->nullable();
            $table->time('laikas')->nullable();
            $table->unsignedInteger('pokalbio_id')->nullable();
            $table->unsignedInteger('siuntejo_id')->nullable();
            $table->unsignedInteger('gavejo_id')->nullable();

            $table->foreign('pokalbio_id')->references('id')->on('pokalbis');
            $table->foreign('siuntejo_id')->references('id')->on('users');
            $table->foreign('gavejo_id')->references('id')->on('users');
        });

        // Insert data into zinute table
        $faqItems = [
            [
                'question' => 'Kaip atlikti viešbučio rezervaciją?',
                'answer' => 'Norėdami atlikti viešbučio rezervaciją, pasirinkite norimą datą, kambario tipą ir užpildykite rezervacijos formą mūsų svetainėje.'
            ],
            [
                'question' => 'Ar galiu pakeisti savo rezervaciją po patvirtinimo?',
                'answer' => 'Taip, jūs galite pakeisti savo rezervaciją iki 24 valandų prieš atvykimą. Jei reikia keisti datą ar kambario tipą, susisiekite su mūsų klientų aptarnavimo komanda.'
            ],
            [
                'question' => 'Ar reikia sumokėti už visą rezervaciją iš anksto?',
                'answer' => 'Dažniausiai už rezervaciją reikia sumokėti tik atvykimo metu. Tačiau kai kuriems pasiūlymams gali reikėti sumokėti iš anksto, priklausomai nuo viešbučio politikos.'
            ],
            [
                'question' => 'Ar galiu atšaukti savo rezervaciją?',
                'answer' => 'Taip, jūs galite atšaukti savo rezervaciją nemokamai iki 48 valandų prieš atvykimą. Po šio laikotarpio gali būti taikomas mažas atšaukimo mokestis.'
            ],
            [
                'question' => 'Ar viešbutyje leidžiama laikyti augintinius?',
                'answer' => 'Augintiniai yra leidžiami tik kai kuriuose kambariuose, todėl rekomenduojame iš anksto susisiekti su viešbučiu ir patikrinti augintinių politiką.'
            ],
            [
                'question' => 'Ar galiu pasirinkti konkretaus kambario numerį?',
                'answer' => 'Deja, kambario numerio pasirinkti negalima, tačiau mes garantuojame, kad gausite kambario tipą, kurį užsisakėte.'
            ],
            [
                'question' => 'Ką daryti, jei nesu patenkintas savo kambariu?',
                'answer' => 'Jei nesate patenkintas savo kambariu, prašome nedelsiant informuoti mūsų priimamąjį, ir mes stengsimės rasti tinkamą sprendimą arba pasiūlyti kitą kambarį.'
            ],
            [
                'question' => 'Ar galiu pakeisti svečių skaičių po rezervacijos?',
                'answer' => 'Taip, jei reikia pakeisti svečių skaičių, susisiekite su mūsų komanda kuo greičiau, kad galėtume atnaujinti jūsų užsakymą.'
            ],
            [
                'question' => 'Ar yra nemokamas parkingas viešbutyje?',
                'answer' => 'Kai kuriuose mūsų viešbučiuose yra nemokamas parkingas, tačiau kai kuriose vietose gali būti taikomas papildomas mokestis. Rekomenduojame pasitikrinti pagal vietą.'
            ],
            [
                'question' => 'Ar viešbutyje yra vaikams pritaikytų paslaugų?',
                'answer' => 'Taip, mes siūlome vaikams pritaikytas paslaugas, tokius kaip žaidimų kambariai, vaikų lovelės ir specialūs meniu.'
            ]
        ];

        foreach ($faqItems as $index => $faq) {
            DB::table('zinute')->insert([
                'id' => $index + 1,
                'tekstas' => $faq['question'] . ':::' . $faq['answer'],
                'laikas' => null,
                'pokalbio_id' => null,
                'siuntejo_id' => null,
                'gavejo_id' => null,
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('zinute');
    }
};
