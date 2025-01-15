<?php
function Quiz()
{
    $quiz = [
        [
            'text' => 'Вопрос 1',
            'answers' => [
                1 => "Ответ 1",
                2 => "Ответ 2 (правильный)",
                3 => "Ответ 3",
            ],
            'correct' => 2,
        ],
        [
            'text' => 'Вопрос 2',
            'answers' => [
                1 => "Ответ 1",
                2 => "Ответ 2",
                3 => "Ответ 3 (правильный)",
                4 => "Ответ 4",
            ],
            'correct' => 3,
        ],
        [
            'text' => 'Вопрос 3',
            'answers' => [
                1 => "Ответ 1",
                2 => "Ответ 2 ",
                3 => "Ответ 3",
                4 => "Ответ 4 (правильный)",
                5 => "Ответ 5",
            ],
            'correct' => 4,
        ]
    ];

    echo "Викторина !" . PHP_EOL;

    foreach ($quiz as $question) {

        $countAnswers = count($question['answers']);

        do {
            echo "--------------------------\n";
            echo $question['text'] . PHP_EOL;
            echo "--------------------------\n";
            echo "Выберите вариант ответа: (число):\n";

            foreach ($question['answers'] as $answer) {
                echo $answer . PHP_EOL;
            }

            $userAnswer = (int)readline("Ваш ответ:");

            $correctInput = $userAnswer >= 1 && $userAnswer <= $countAnswers;

            if (!$correctInput) {
                echo handlerError("Ошибка! Не корректный ввод!");
            }

        } while (!$correctInput);

        if ($userAnswer == $question['correct']) {
            echo "Верно!\n";
        } else {
            echo "Неверно!\n";
            return "Вы проиграли!\n";
        }
    }

    return "Поздравляю ты ответил верно на все вопросы!\n";
}