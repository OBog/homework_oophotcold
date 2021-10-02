<?php
namespace Command;

use Player\Player;
use Player\Randomize;
use Player\Validation;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;


class CreateCommand extends Command
{
    private $repeat;

    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:run-hotcold')

            // the short description shown while running "php bin/console list"
            ->setDescription('Starts the game');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->repeat = false;

        $this->startGame($input,$output);
        while(true){
            if ($this->repeat)
            {
                echo "test";
                $this->repeat = false;
                $this->startGame($input,$output);
            }
            else
                {
                    echo "break1";
                    break;
                }
            }
            return Command::SUCCESS;
        }

        private function checkGuess($input, $output,$helper,$validator,$errors,$guess) : int
        {
            while (true)
            {
                if (!empty($errors)){
                    foreach ($errors as $error)
                    {
                        echo $error.PHP_EOL;
                    }
                    $question3 = new Question('Please enter the number: ');
                    $guess = $helper->ask($input, $output, $question3);
                    $errors = $validator->getErrors($guess);
                    continue;
                }
                else
                {
                     break;
                }
            }
            //echo '$guessTEST: ' . $guess .PHP_EOL;
            return (int)$guess;
        }
        private function startGame($input, $output)
        {
            $output->writeln([
                'Game starts...',
                '============',
                '',
            ]);
            $helper = $this->getHelper('question');

            $question1 = new Question('Please enter your name: ');
            $validator = new Validation();

            $userName = $helper->ask($input, $output, $question1);
            $errors = $validator->isValidName($userName);

            while (true)
            {
                if (!empty($errors)){
                    foreach ($errors as $error)
                    {
                        echo $error.PHP_EOL;

                    }
                    $question1 = new Question('Please enter your name: ');
                    $userName = $helper->ask($input, $output, $question1);
                    $errors = $validator->isValidName($userName);
                    continue;
                }
                else{
                    break;
                }
            }

            $player = new Player($userName);
            $question2 = new Question('Please enter THE NUMBER BETWEEN 10 - 1000 ');
            $randomize = $helper->ask($input, $output, $question2);

            $answer = (new Randomize(0, $randomize))->rand();
            echo $answer.PHP_EOL;

            $output->writeln('Thnx for entering the number!');

            $question3 = new Question('Please enter the number:');
            $guess= $helper->ask($input, $output, $question3);
            $errors = $validator->getErrors($guess);
            $guess = $this->checkGuess($input, $output,$helper,$validator,$errors,$guess);


            $attemptsCount = 1;
            $player->setScore($attemptsCount);

            while (true) {
                if ($guess < $answer)
                {

//                    echo '$guess: ' . $guess .PHP_EOL;
//                    echo '$answer: ' . $answer .PHP_EOL;

                    echo "Almost. Your guess is less than my number ".PHP_EOL;
                    $attemptsCount++;
                    $player->setScore($attemptsCount);
                    $question3 = new Question('Please enter the number:');
                    $guess= $helper->ask($input, $output, $question3);
                    $errors = $validator->getErrors($guess);
                    $guess = $this->checkGuess($input, $output,$helper,$validator,$errors,$guess);
                    continue;
                }

                if ($guess > $answer)
                {

//                    echo '$guess: ' . $guess .PHP_EOL;
//                    echo '$answer: ' . $answer .PHP_EOL;

                    echo "Almost. Your guess is greater than my number ".PHP_EOL;
                    $attemptsCount++;
                    $player->setScore($attemptsCount);
                    $question3 = new Question('Please enter the number:');
                    $guess= $helper->ask($input, $output, $question3);
                    $errors = $validator->getErrors($guess);
                    $guess = $this->checkGuess($input, $output,$helper,$validator,$errors,$guess);
                    continue;
                }

                if ($guess == $answer)
                {

//                    echo '$guess: ' . $guess .PHP_EOL;
//                    echo '$answer: ' . $answer .PHP_EOL;

                    echo "You guessed correctly! Good Job".PHP_EOL;
                    echo "Correct number is: ".$answer.PHP_EOL;
                    echo $player->getName()." It took you ".$player->getScore()." attempts to guess the correct number".PHP_EOL;

                    $question4 = new ConfirmationQuestion('Continue with this action? ', true);

                    if (!$helper->ask($input, $output, $question4))
                    {
                       //echo "true";
                       $this->repeat = false;
                       // echo "break2";
                       break;

                    }
                    else
                    {
                        //echo "false";
                        $this->repeat = true;
                        //echo "break3";
                        break;
                    }
                }
            }
        }
}
