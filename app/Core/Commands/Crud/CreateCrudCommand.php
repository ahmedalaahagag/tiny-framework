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
    private $output;

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
        $this->output = $output;

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
        $this->createController($name);

        // Creates Model
        $this->createModel($name);
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


    protected function terminateCreate($reason)
    {

        $this->output->writeln('<error>Operation Aborted:'.$reason.'</error>');
    }

    /**
     * @param $name
     */
    protected function createController($name): void
    {
        $controllerName = 'app/Controllers/' . $name . 'Controller.php';
        if (checkIfFileExists($controllerName)) {
            $this->terminateCreate($controllerName . " already exist");
            die();
        } else
            file_put_contents($controllerName,
                $this->replaceClass(getFileContents(__DIR__ . '/stubs/controller.stub'), $name));

    }

    /**
     * @param $name
     */
    protected function createModel($name): void
    {
        $modelName = 'app/Models/' . $name . '.php';
        if (checkIfFileExists($modelName)) {
            $this->terminateCreate($modelName . " exist");
            die();
        } else
            file_put_contents($modelName,
                $this->replaceClass(getFileContents(__DIR__ . '/stubs/model.stub'), $name));

    }
}