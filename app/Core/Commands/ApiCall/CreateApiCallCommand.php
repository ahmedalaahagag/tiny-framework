<?php
/**
 * Created by PhpStorm.
 * User: Ahmed
 * Date: 12/5/17
 * Time: 12:21 PM
 */

namespace App\Core\Commands\ApiCall;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateApiCallCommand extends Command
{
    protected $output;

    protected $classFolder = 'app/ApiCalls/';

    protected function configure()
    {
        $this
            ->setName('api-call:make')
            ->setDescription('Creates a new api call class.')
            ->setHelp('This command allows you to create a new api call class...')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of apiCall.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
        $this->mangeClassFolder();
        $className = $input->getArgument('name');
        $classPath = $this->classFolder . $className. ".php";

        file_put_contents($classPath,
            $this->replaceClass(getFileContents(__DIR__ . '/stubs/apicall.stub'), $className));


        $this->output->writeln('Class ' . $classPath . " generated");
    }

    /**
     * Replaces Dummy with given class name
     * @param $stub
     * @param $name
     * @return mixed
     */
    protected function replaceClass($stub, $name)
    {
        $stub = str_replace('Dummy', $name, $stub);
        $stub = str_replace('dummy', lcfirst($name), $stub);
        return $stub;
    }

    public function checkIfFolderExists()
    {
        return $check = checkIfFileExists($this->classFolder);
    }

    public function createClassFolder()
    {
        return mkdir($this->classFolder);
    }


    protected function mangeClassFolder()
    {
        if (!$this->checkIfFolderExists())
            return $this->createClassFolder();
    }
}