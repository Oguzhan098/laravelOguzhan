<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidEmailDomain implements Rule
{
    /**
     * Geçerli domain listesi
     * Dilersen .env'den de çekebilirsin.
     */
    protected $allowedDomains = [
        'gmail.com',
        'outlook.com',
        'hotmail.com',
        'edu.tr',
        'gov.tr',
        'kendi-domainin.com',
    ];

    public function passes($attribute, $value)
    {
        $domain = strtolower(substr(strrchr($value, "@"), 1));


        if (!preg_match('/^[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/', $domain)) {  //format kontrolü
            return false;
        }


        if (in_array($domain, $this->allowedDomains)) {     // Doğrudan tam eşleşme kontrolü
            return true;
        }

        foreach ($this->allowedDomains as $allowed) {   //Alt domain” desteği (örnek: mail.uni.edu.tr)
            if (str_ends_with($domain, $allowed)) {
                return true;
            }
        }

        return false;
    }

    public function message()
    {
        return 'Bu e-posta alan adı kabul edilmiyor. Lütfen güvenilir bir e-posta sağlayıcısı kullanın.';
    }
}
