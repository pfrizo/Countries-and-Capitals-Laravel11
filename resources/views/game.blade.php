<x-main-layout pageTitle="Countries and Capitals Quiz">

    <div class="container">

        <x-question :$country :$currentQuestion :$totalQuestions></x-question>

        <div class="row">

            @foreach ($answers as $answer)
                <x-answer :capital="$answer"></x-answer>
            @endforeach

        </div>
        
    </div>

    <!-- cancel game -->
    <div class="text-center mt-5">
        <a href="{{ route('start_game') }}" class="btn btn-outline-danger mt-3 px-5">CANCELAR JOGO</a>
    </div>

</x-main-layout>
