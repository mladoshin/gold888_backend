<?php

namespace App\Models;

class OverdueStatus
{
    const TRANSFERRED_TO_A_LAWYER="Переданные юристу";
    const SUSPENDED="Приостановленные";
    const WITHOUT_DOCUMENTS="Дело у ЧСИ";
    const TRANSFERRED_TO_NOTARY="Дело у нотариуса";


    public static function getStatusList(): array
    {
        return [
            self::TRANSFERRED_TO_A_LAWYER,
            self::SUSPENDED,
            self::WITHOUT_DOCUMENTS,
            self::TRANSFERRED_TO_NOTARY
        ];
    }
}
