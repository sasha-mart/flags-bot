<?php
require_once "vendor/autoload.php";

try {
    $bot = new \TelegramBot\Api\Client(file_get_contents('token'));

    $bot->command('start', function ($message) use ($bot) {
        $answer = 'Добро пожаловать!';
        $bot->sendMessage($message->getChat()->getId(), $answer);
    });

    $bot->command('help', function ($message) use ($bot) {
        $answer = 'Команды:
            /help - вывод справки
            /flag *countryName* - вывод информации о стране';
        $bot->sendMessage($message->getChat()->getId(), $answer);
    });

    $bot->command('flag', function ($message) use ($bot) {
        $text = $message->getText();
        $param = str_replace('/flag ', '', $text);
        if (!empty($param)) {
            $flag = new \SashaMart\FlagsBot\Flag(trim($message));
            $emodji = $flag->getUnicode();

            if (!empty($emodji))
                $answer = $emodji . ' https://ru.wikipedia.org/wiki/' . $flag->countryName;
            else
                $answer = 'Информация о данной стране не найдена :( Попробуйте ввести другое название на английском языке';
        }
        else
            $answer = 'Введите название страны на английском языке';
        $bot->sendMessage($message->getChat()->getId(), $answer);
    });

    $bot->run();

} catch (\TelegramBot\Api\Exception $e) {
    $e->getMessage();
}