<?php
namespace App\Console\Commands;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CheckStatusCommand extends Command {

	protected function configure()
	{
		$this->setName('checkstatus')->setDescription('CheckStatusCommand description');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		// TODO: Check status
		$output->writeln('Hello world!');
	}
}