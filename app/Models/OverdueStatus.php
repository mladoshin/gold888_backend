<?php

namespace App\Models;

class OverdueStatus
{
    const TRANSFERRED_TO_A_LAWYER="Переданные юристу";
    const SUSPENDED="Приостановленные";
    const WITHOUT_DOCUMENTS="Без документов";

    public static function getStatusList(): array
    {
        return [
            self::TRANSFERRED_TO_A_LAWYER,
            self::SUSPENDED,
            self::WITHOUT_DOCUMENTS,
        ];
    }
}
