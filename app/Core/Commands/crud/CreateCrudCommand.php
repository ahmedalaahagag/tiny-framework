<?php

namespace App\Core\Commands\Crud;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CreateCrudCommand
 * @package App\Core\Commands
 */
class CreateCrudCommand extends Command
{
    /**
     * Configures CreateCrudCommand
     * Gets the name of the needed CRUD Controller / Model / Routes
     */
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('crud:make')
            // the short description shown while running "php bin/console list"
            ->setDescription('Creates a new crud.')
            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to create a crud controllers and model...')
            // configure an argument
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the module.');


    }

    /**
     * Executes Create CRUD Command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->buildClass($input->getArgument('name'));
        $this->updateRoutes($input->getArgument('name'));
    }

    /**
     * Builds Controller and model class using the given name and stub template
     * @param $name
     */
    protected function buildClass($name)
    {
        // Creates Controller
        file_put_contents('app/Controllers/' . $name . 'Controller.php',
            $this->replaceClass(getFileContents(__DIR__ . '/stubs/controller.stub'), $name));

        // Creates Model
        file_put_contents('app/Models/' . $name . '.php',
            $this->replaceClass(getFileContents(__DIR__ . '/stubs/model.stub'), $name));
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

    /**
     * Appends the new routes to routes file
     * @param $name
     */
    protected function updateRoutes($name)
    {
        // Routes Append
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . 'routes.php',
            getFileContents($_SERVER['DOCUMENT_ROOT'] . 'routes.php') .
            $this->replaceClass(getFileContents(__DIR__ . '/stubs/routes.stub'), $name));
    }


}