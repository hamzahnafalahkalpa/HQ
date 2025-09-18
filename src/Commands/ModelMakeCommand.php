<?php

namespace Projects\HQ\Commands;

use Hanafalah\LaravelPackageGenerator\Commands\ModelMakeCommand as CommandsModelMakeCommand;

class ModelMakeCommand extends CommandsModelMakeCommand
{
    protected $signature = 'h-q:make-model 
                {name}
                {--pattern= : Pattern yang digunakan}
                {--class-basename= : Nama class yang digunakan}';
}