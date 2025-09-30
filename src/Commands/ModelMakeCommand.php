<?php

namespace Projects\Hq\Commands;

use Hanafalah\LaravelPackageGenerator\Commands\ModelMakeCommand as CommandsModelMakeCommand;

class ModelMakeCommand extends CommandsModelMakeCommand
{
    protected $signature = 'hq:make-model 
                {name}
                {--pattern= : Pattern yang digunakan}
                {--class-basename= : Nama class yang digunakan}';
}