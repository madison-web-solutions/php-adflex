<?php

namespace MadisonSolutions\Adflex;

class Currency
{
    protected static $defns;

    public static function lookup(string $code)
    {
        self::getDefns();
        return self::$defns[$code] ?? null;
    }

    public static function allCodes()
    {
        return array_keys(self::getDefns());
    }

    public static function getDefns()
    {
        if (! is_null(self::$defns)) {
            return self::$defns;
        }

        self::$defns = [
            'AFA' => [
                'label' => 'Afghan Afghani',
                'num' => '971',
                'exp' => 2,
            ],
            'AWG' => [
                'label' => 'Aruban Florin',
                'num' => '533',
                'exp' => 2,
            ],
            'AUD' => [
                'label' => 'Australian Dollars',
                'num' => '036',
                'exp' => 2,
            ],
            'ARS' => [
                'label' => 'Argentine Pes',
                'num' => '032',
                'exp' => 2,
            ],
            'AZN' => [
                'label' => 'Azerbaijanian Manat',
                'num' => '944',
                'exp' => 2,
            ],
            'BSD' => [
                'label' => 'Bahamian Dollar',
                'num' => '044',
                'exp' => 2,
            ],
            'BHD' => [
                'label' => 'Bahraini dinar',
                'num' => '048',
                'exp' => 3,
            ],
            'BDT' => [
                'label' => 'Bangladeshi Taka',
                'num' => '050',
                'exp' => 2,
            ],
            'BBD' => [
                'label' => 'Barbados Dollar',
                'num' => '052',
                'exp' => 2,
            ],
            'BYR' => [
                'label' => 'Belarussian Rouble',
                'num' => '974',
                'exp' => 2,
            ],
            'BOB' => [
                'label' => 'Bolivian Boliviano',
                'num' => '068',
                'exp' => 2,
            ],
            'BRL' => [
                'label' => 'Brazilian Real',
                'num' => '986',
                'exp' => 2,
            ],
            'GBP' => [
                'label' => 'British Pounds Sterling',
                'num' => '826',
                'exp' => 2,
            ],
            'BGN' => [
                'label' => 'Bulgarian Lev',
                'num' => '975',
                'exp' => 2,
            ],
            'BIF' => [
                'label' => 'Burundian franc',
                'num' => '108',
                'exp' => 0,
            ],
            'KHR' => [
                'label' => 'Cambodia Riel',
                'num' => '116',
                'exp' => 2,
            ],
            'CAD' => [
                'label' => 'Canadian Dollars',
                'num' => '124',
                'exp' => 2,
            ],
            'KYD' => [
                'label' => 'Cayman Islands Dollar',
                'num' => '136',
                'exp' => 2,
            ],
            'CLP' => [
                'label' => 'Chilean Peso',
                'num' => '152',
                'exp' => 0,
            ],
            'CNY' => [
                'label' => 'Chinese Renminbi Yuan',
                'num' => '156',
                'exp' => 2,
            ],
            'KMF' => [
                'label' => 'Comoro Franc',
                'num' => '174',
                'exp' => 0,
            ],
            'COP' => [
                'label' => 'Colombian Peso',
                'num' => '170',
                'exp' => 2,
            ],
            'CRC' => [
                'label' => 'Costa Rican Colon',
                'num' => '188',
                'exp' => 2,
            ],
            'HRK' => [
                'label' => 'Croatia Kuna',
                'num' => '191',
                'exp' => 2,
            ],
            'CPY' => [
                'label' => 'Cypriot Pounds',
                'num' => '196',
                'exp' => 2,
            ],
            'CZK' => [
                'label' => 'Czech Koruna',
                'num' => '203',
                'exp' => 2,
            ],
            'DKK' => [
                'label' => 'Danish Krone',
                'num' => '208',
                'exp' => 2,
            ],
            'DJF' => [
                'label' => 'Djiboutian franc',
                'num' => '262',
                'exp' => 0,
            ],
            'DOP' => [
                'label' => 'Dominican Republic Peso',
                'num' => '214',
                'exp' => 2,
            ],
            'XCD' => [
                'label' => 'East Caribbean Dollar',
                'num' => '951',
                'exp' => 2,
            ],
            'EGP' => [
                'label' => 'Egyptian Pound',
                'num' => '818',
                'exp' => 2,
            ],
            'ERN' => [
                'label' => 'Eritrean Nakfa',
                'num' => '232',
                'exp' => 2,
            ],
            'EEK' => [
                'label' => 'Estonia Kroon',
                'num' => '233',
                'exp' => 2,
            ],
            'EUR' => [
                'label' => 'Euro',
                'num' => '978',
                'exp' => 2,
            ],
            'GEL' => [
                'label' => 'Georgian Lari',
                'num' => '981',
                'exp' => 2,
            ],
            'GHC' => [
                'label' => 'Ghana Cedi',
                'num' => '288',
                'exp' => 2,
            ],
            'GIP' => [
                'label' => 'Gibraltar Pound',
                'num' => '292',
                'exp' => 2,
            ],
            'GTQ' => [
                'label' => 'Guatemala Quetzal',
                'num' => '320',
                'exp' => 2,
            ],
            'GNF' => [
                'label' => 'Guinean Franc',
                'num' => '324',
                'exp' => 0,
            ],
            'HNL' => [
                'label' => 'Honduras Lempira',
                'num' => '340',
                'exp' => 2,
            ],
            'HKD' => [
                'label' => 'Hong Kong Dollars',
                'num' => '344',
                'exp' => 2,
            ],
            'HUF' => [
                'label' => 'Hungary Forint',
                'num' => '348',
                'exp' => 2,
            ],
            'ISK' => [
                'label' => 'Icelandic Krona',
                'num' => '352',
                'exp' => 0,
            ],
            'INR' => [
                'label' => 'Indian Rupee',
                'num' => '356',
                'exp' => 2,
            ],
            'IDR' => [
                'label' => 'Indonesia Rupiah',
                'num' => '360',
                'exp' => 2,
            ],
            'IQD' => [
                'label' => 'Iraqi dinar',
                'num' => '368',
                'exp' => 3,
            ],
            'ILS' => [
                'label' => 'Israel Shekel',
                'num' => '376',
                'exp' => 2,
            ],
            'JMD' => [
                'label' => 'Jamaican Dollar',
                'num' => '388',
                'exp' => 2,
            ],
            'JPY' => [
                'label' => 'Japanese yen',
                'num' => '392',
                'exp' => 0,
            ],
            'JOD' => [
                'label' => 'Jordanian dinar',
                'num' => '400',
                'exp' => 3,
            ],
            'KZT' => [
                'label' => 'Kazakhstan Tenge',
                'num' => '368',
                'exp' => 2,
            ],
            'KES' => [
                'label' => 'Kenyan Shilling',
                'num' => '404',
                'exp' => 2,
            ],
            'KWD' => [
                'label' => 'Kuwaiti Dinar',
                'num' => '414',
                'exp' => 3,
            ],
            'LVL' => [
                'label' => 'Latvia Lat',
                'num' => '428',
                'exp' => 2,
            ],
            'LBP' => [
                'label' => 'Lebanese Pound',
                'num' => '422',
                'exp' => 2,
            ],
            'LTL' => [
                'label' => 'Lithuania Litas',
                'num' => '440',
                'exp' => 2,
            ],
            'LYD' => [
                'label' => 'Libyan Dinar',
                'num' => '434',
                'exp' => 3,
            ],
            'MOP' => [
                'label' => 'Macau Pataca',
                'num' => '446',
                'exp' => 2,
            ],
            'MKD' => [
                'label' => 'Macedonian Denar',
                'num' => '807',
                'exp' => 2,
            ],
            'MGA' => [
                'label' => 'Malagascy Ariary',
                'num' => '969',
                'exp' => 2,
            ],
            'MYR' => [
                'label' => 'Malaysian Ringgit',
                'num' => '458',
                'exp' => 2,
            ],
            'MTL' => [
                'label' => 'Maltese Lira',
                'num' => '470',
                'exp' => 2,
            ],
            'BAM' => [
                'label' => 'Marka',
                'num' => '977',
                'exp' => 2,
            ],
            'MUR' => [
                'label' => 'Mauritius Rupee',
                'num' => '480',
                'exp' => 2,
            ],
            'MXN' => [
                'label' => 'Mexican Pesos',
                'num' => '484',
                'exp' => 2,
            ],
            'MZM' => [
                'label' => 'Mozambique Metical',
                'num' => '508',
                'exp' => 2,
            ],
            'NPR' => [
                'label' => 'Nepalese Rupee',
                'num' => '524',
                'exp' => 2,
            ],
            'ANG' => [
                'label' => 'Netherlands Antilles Guilder',
                'num' => '532',
                'exp' => 2,
            ],
            'TWD' => [
                'label' => 'New Taiwanese Dollars',
                'num' => '901',
                'exp' => 2,
            ],
            'NZD' => [
                'label' => 'New Zealand Dollars',
                'num' => '554',
                'exp' => 2,
            ],
            'NIO' => [
                'label' => 'Nicaragua Cordoba',
                'num' => '558',
                'exp' => 2,
            ],
            'NGN' => [
                'label' => 'Nigeria Naira',
                'num' => '566',
                'exp' => 2,
            ],
            'KPW' => [
                'label' => 'North Korean Won',
                'num' => '408',
                'exp' => 2,
            ],
            'NOK' => [
                'label' => 'Norwegian Krone',
                'num' => '578',
                'exp' => 2,
            ],
            'OMR' => [
                'label' => 'Omani Riyal',
                'num' => '512',
                'exp' => 3,
            ],
            'PKR' => [
                'label' => 'Pakistani Rupee',
                'num' => '586',
                'exp' => 2,
            ],
            'PYG' => [
                'label' => 'Paraguay Guarani',
                'num' => '600',
                'exp' => 0,
            ],
            'PEN' => [
                'label' => 'Peru New Sol',
                'num' => '604',
                'exp' => 2,
            ],
            'PHP' => [
                'label' => 'Philippine Pesos',
                'num' => '608',
                'exp' => 2,
            ],
            'QAR' => [
                'label' => 'Qatari Riyal',
                'num' => '634',
                'exp' => 2,
            ],
            'RON' => [
                'label' => 'Romanian New Leu',
                'num' => '946',
                'exp' => 2,
            ],
            'RUB' => [
                'label' => 'Russian Federation Ruble',
                'num' => '643',
                'exp' => 2,
            ],
            'RWF' => [
                'label' => 'Rwandan Franc',
                'num' => '646',
                'exp' => 0,
            ],
            'SAR' => [
                'label' => 'Saudi Riyal',
                'num' => '682',
                'exp' => 2,
            ],
            'CSD' => [
                'label' => 'Serbian Dinar',
                'num' => '891',
                'exp' => 2,
            ],
            'SCR' => [
                'label' => 'Seychelles Rupee',
                'num' => '690',
                'exp' => 2,
            ],
            'SGD' => [
                'label' => 'Singapore Dollars',
                'num' => '702',
                'exp' => 2,
            ],
            'SKK' => [
                'label' => 'Slovak Koruna',
                'num' => '703',
                'exp' => 2,
            ],
            'SIT' => [
                'label' => 'Slovenia Tolar',
                'num' => '705',
                'exp' => 2,
            ],
            'ZAR' => [
                'label' => 'South African Rand',
                'num' => '710',
                'exp' => 2,
            ],
            'KRW' => [
                'label' => 'South Korean Won',
                'num' => '410',
                'exp' => 0,
            ],
            'LKR' => [
                'label' => 'Sri Lankan Rupee',
                'num' => '144',
                'exp' => 2,
            ],
            'SRD' => [
                'label' => 'Surinam Dollar',
                'num' => '968',
                'exp' => 2,
            ],
            'SEK' => [
                'label' => 'Swedish Krona',
                'num' => '752',
                'exp' => 2,
            ],
            'CHF' => [
                'label' => 'Swiss Francs',
                'num' => '756',
                'exp' => 2,
            ],
            'TZS' => [
                'label' => 'Tanzanian Shilling',
                'num' => '834',
                'exp' => 2,
            ],
            'THB' => [
                'label' => 'Thai Baht',
                'num' => '764',
                'exp' => 2,
            ],
            'TTD' => [
                'label' => 'Trinidad and Tobago Dollar',
                'num' => '780',
                'exp' => 2,
            ],
            'TND' => [
                'label' => 'Tunisian dinar',
                'num' => '788',
                'exp' => 3,
            ],
            'TRY' => [
                'label' => 'Turkish New Lira',
                'num' => '949',
                'exp' => 2,
            ],
            'AED' => [
                'label' => 'UAE Dirham',
                'num' => '784',
                'exp' => 2,
            ],
            'USD' => [
                'label' => 'US Dollars',
                'num' => '840',
                'exp' => 2,
            ],
            'UGX' => [
                'label' => 'Ugandian Shilling',
                'num' => '800',
                'exp' => 0,
            ],
            'UAH' => [
                'label' => 'Ukraine Hryvna',
                'num' => '980',
                'exp' => 2,
            ],
            'UYU' => [
                'label' => 'Uruguayan Peso',
                'num' => '858',
                'exp' => 2,
            ],
            'UZS' => [
                'label' => 'Uzbekistani Som',
                'num' => '860',
                'exp' => 2,
            ],
            'VUV' => [
                'label' => 'Vanuatu Vatu',
                'num' => '548',
                'exp' => 0,
            ],
            'VEB' => [
                'label' => 'Venezuela Bolivar',
                'num' => '862',
                'exp' => 2,
            ],
            'VND' => [
                'label' => 'Vietnam Dong',
                'num' => '704',
                'exp' => 0,
            ],
            'AMK' => [
                'label' => 'Zambian Kwacha',
                'num' => '894',
                'exp' => 2,
            ],
            'ZWD' => [
                'label' => 'Zimbabwe Dollar',
                'num' => '716',
                'exp' => 2,
            ],
        ];

        return self::$defns;
    }
}
