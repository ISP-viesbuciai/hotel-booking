@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Dažniausiai Užduodami Klausimai (D.U.K.)</h1>
        
        <div class="faq-item">
            <h3>1. Kaip atlikti viešbučio rezervaciją?</h3>
            <p>Norėdami atlikti viešbučio rezervaciją, pasirinkite norimą datą, kambario tipą ir užpildykite rezervacijos formą mūsų svetainėje.</p>
        </div>

        <div class="faq-item">
            <h3>2. Ar galiu pakeisti savo rezervaciją po patvirtinimo?</h3>
            <p>Taip, jūs galite pakeisti savo rezervaciją iki 24 valandų prieš atvykimą. Jei reikia keisti datą ar kambario tipą, susisiekite su mūsų klientų aptarnavimo komanda.</p>
        </div>

        <div class="faq-item">
            <h3>3. Ar reikia sumokėti už visą rezervaciją iš anksto?</h3>
            <p>Dažniausiai už rezervaciją reikia sumokėti tik atvykimo metu. Tačiau kai kuriems pasiūlymams gali reikėti sumokėti iš anksto, priklausomai nuo viešbučio politikos.</p>
        </div>

        <div class="faq-item">
            <h3>4. Ar galiu atšaukti savo rezervaciją?</h3>
            <p>Taip, jūs galite atšaukti savo rezervaciją nemokamai iki 48 valandų prieš atvykimą. Po šio laikotarpio gali būti taikomas mažas atšaukimo mokestis.</p>
        </div>

        <div class="faq-item">
            <h3>5. Ar viešbutyje leidžiama laikyti augintinius?</h3>
            <p>Augintiniai yra leidžiami tik kai kuriuose kambariuose, todėl rekomenduojame iš anksto susisiekti su viešbučiu ir patikrinti augintinių politiką.</p>
        </div>

        <div class="faq-item">
            <h3>6. Ar galiu pasirinkti konkretaus kambario numerį?</h3>
            <p>Deja, kambario numerio pasirinkti negalima, tačiau mes garantuojame, kad gausite kambario tipą, kurį užsisakėte.</p>
        </div>

        <div class="faq-item">
            <h3>7. Ką daryti, jei nesu patenkintas savo kambariu?</h3>
            <p>Jei nesate patenkintas savo kambariu, prašome nedelsiant informuoti mūsų priimamąjį, ir mes stengsimės rasti tinkamą sprendimą arba pasiūlyti kitą kambarį.</p>
        </div>

        <div class="faq-item">
            <h3>8. Ar galiu pakeisti svečių skaičių po rezervacijos?</h3>
            <p>Taip, jei reikia pakeisti svečių skaičių, susisiekite su mūsų komanda kuo greičiau, kad galėtume atnaujinti jūsų užsakymą.</p>
        </div>

        <div class="faq-item">
            <h3>9. Ar yra nemokamas parkingas viešbutyje?</h3>
            <p>Kai kuriuose mūsų viešbučiuose yra nemokamas parkingas, tačiau kai kuriose vietose gali būti taikomas papildomas mokestis. Rekomenduojame pasitikrinti pagal vietą.</p>
        </div>

        <div class="faq-item">
            <h3>10. Ar viešbutyje yra vaikams pritaikytų paslaugų?</h3>
            <p>Taip, mes siūlome vaikams pritaikytas paslaugas, tokius kaip žaidimų kambariai, vaikų lovelės ir specialūs meniu.</p>
        </div>

        <!-- Message and Button for the next page -->
        <div class="faq-message mt-5">
            <h3>Neradote atsakymo į norimą klausimą? susisiekite su darbuotoju.</h3>
            <a href="{{ url('/chat') }}" class="btn btn-primary mt-2">Pradėti pokalbį su darbuotoju</a>
        </div>
    </div>
@endsection
