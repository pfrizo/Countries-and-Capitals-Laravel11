<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class MainController extends Controller
{
    private $app_data;

    public function __construct(){
        $this->app_data = require(app_path('app_data.php'));
    }

    public function showData(){
        return response()->json($this->app_data);
    }

    public function startGame(): View
    {
        return view('home');
    }

    public function prepareGame(Request $request)
    {
        $request->validate(
            [
                'total_questions' => 'required|integer|min:3|max:30'
            ],
            [
                'total_questions.required' => 'O número de perguntas é obrigatório!',
                'total_questions.integer' => 'O número de perguntas deve ser um valor inteiro!',
                'total_questions.min' => 'No mínimo :min questões!',
                'total_questions.max' => 'No máximo :max questões!',
            ]
        );

        $total_questions = intval($request->input('total_questions'));

        $quiz = $this->prepareQuiz($total_questions);
    }

    private function prepareQuiz($total_questions){
        $questions = [];
        $total_countries = count($this->app_data);

        $indexes = range(0, $total_countries - 1);
        shuffle($indexes);

        $indexes = array_slice($indexes, 0, $total_questions);

        $question_number = 1;
        foreach($indexes as $i){

            $question['question_number'] = $question_number++;
            $question['country'] = $this->app_data[$i]['country'];
            $question['correct_answer'] = $this->app_data[$i]['capital'];

            $other_capitals = array_column($this->app_data, 'capital');
            $other_capitals = array_diff($other_capitals, [$question['correct_answer']]);

            shuffle($other_capitals);
            $question['wrong_answers'] = array_slice($other_capitals, 0, 3);

            $question['correct'] = null;

            $questions[] = $question;
        }

        return $questions;
    }
}
