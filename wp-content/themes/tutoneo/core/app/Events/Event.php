<?php

namespace App\Events;

abstract class Event
{
    abstract protected function fire();
}
