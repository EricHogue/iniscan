<?php
namespace Psecio\Iniscan\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ListCommand extends Command
{
    protected function configure()
    {
        $this->setName('list')
            ->setDescription('Output information about the current rule checks')
            ->setHelp(
                'Output information about the current rule checks'
            );
    }

    /**
     * Execute the "list" command
     *
     * @param  InputInterface  $input  Input object
     * @param  OutputInterface $output Output object
     * @return null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $ruleFilePath = realpath(__DIR__.'/../rules.json');

        if ($ruleFilePath !== false && is_file($ruleFilePath)) {
            $rules = json_decode(file_get_contents($ruleFilePath));

            $output->writeLn("\n<fg=yellow>Current tests:</fg=yellow>");
            foreach ($rules->rules as $section => $ruleSet) {
                $output->writeLn('<info>'.$section.'</info>');
                foreach ($ruleSet as $rule) {
                    $ruleKey = (isset($rule->test->key)) ? $rule->test->key : '[custom]';
                    $output->writeLn(str_pad($ruleKey, 30).'| '.$rule->description);
                }
                $output->writeLn("\n");
            }
        }
    }
}