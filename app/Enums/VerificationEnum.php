<?php
namespace App\Enums;

use Konekt\Enum\Enum;

class VerificationEnum extends  Enum {

    const Email = 'email';
    const PASSWORD = 'password';
    const TENANT = 'tenant';
    const MOBILE = 'mobile';
}
