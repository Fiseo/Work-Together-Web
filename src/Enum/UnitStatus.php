<?php

namespace App\Enum;

enum UnitStatus: string
{
    case Ok = "ok";
    case Incident = "incident";
    case Maintenance = "maintenance";
    case Null = "aucun";
}
