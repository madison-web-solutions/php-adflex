<?php

namespace MadisonSolutions\Adflex;

class Country
{
    protected static $defns;

    public static function parse(?string $country_name)
    {
        $country_name = mb_strtolower($country_name);
        if (empty($country_name)) {
            return null;
        }
        if (in_array($country_name, ['uk', 'united kingdom'])) {
            $country_name = 'GB';
        }
        $len = strlen($country_name);
        foreach (self::getDefns() as $country) {
            if (mb_strtolower($country['label']) == $country_name) {
                return $country;
            }
            if ($len == 3 && mb_strtolower($country['iso3']) == $country_name) {
                return $country;
            }
            if ($len == 2 && mb_strtolower($country['iso2']) == $country_name) {
                return $country;
            }
        }
        return null;
    }

    public static function allIso2Codes()
    {
        return array_keys(self::getDefns());
    }

    public static function allIso3Codes()
    {
        $codes = [];
        foreach (self::getDefns() as $country) {
            $codes[] = $country['iso3'];
        }
        return $codes;
    }

    public static function getDefns()
    {
        if (! is_null(self::$defns)) {
            return self::$defns;
        }

        $eu = [
            'AT', // Austria
            'BE', // Belgium
            'BG', // Bulgaria
            'HR', // Croatia
            'CY', // Cyprus
            'CZ', // Czhechia
            'DK', // Denmark
            'EE', // Estonia
            'FI', // Finland
            'FR', // France
            'DE', // Germany
            'GR', // Greece
            'HU', // Hungary
            'IE', // Ireland
            'IT', // Italy
            'LV', // Latvia
            'LT', // Lithuania
            'LU', // Luxembourg
            'MT', // Malta
            'NL', // Netherlands
            'PL', // Poland
            'PT', // Portugal
            'RO', // Romania
            'SK', // Slovakia
            'SI', // Slovenia
            'ES', // Spain
            'SE', // Sweden
        ];

        self::$defns = [
            'AF' => [
                'label' => 'Afghanistan',
                'iso2' => 'AF',
                'iso3' => 'AFG',
                'num' => '004',
            ],
            'AL' => [
                'label' => 'Albania',
                'iso2' => 'AL',
                'iso3' => 'ALB',
                'num' => '008',
            ],
            'DZ' => [
                'label' => 'Algeria',
                'iso2' => 'DZ',
                'iso3' => 'DZA',
                'num' => '012',
            ],
            'AS' => [
                'label' => 'American Samoa',
                'iso2' => 'AS',
                'iso3' => 'ASM',
                'num' => '016',
            ],
            'AD' => [
                'label' => 'Andorra',
                'iso2' => 'AD',
                'iso3' => 'AND',
                'num' => '020',
            ],
            'AO' => [
                'label' => 'Angola',
                'iso2' => 'AO',
                'iso3' => 'AGO',
                'num' => '024',
            ],
            'AI' => [
                'label' => 'Anguilla',
                'iso2' => 'AI',
                'iso3' => 'AIA',
                'num' => '660',
            ],
            'AQ' => [
                'label' => 'Antarctica',
                'iso2' => 'AQ',
                'iso3' => 'ATA',
                'num' => '010',
            ],
            'AG' => [
                'label' => 'Antigua and Barbuda',
                'iso2' => 'AG',
                'iso3' => 'ATG',
                'num' => '028',
            ],
            'AR' => [
                'label' => 'Argentina',
                'iso2' => 'AR',
                'iso3' => 'ARG',
                'num' => '032',
            ],
            'AM' => [
                'label' => 'Armenia',
                'iso2' => 'AM',
                'iso3' => 'ARM',
                'num' => '051',
            ],
            'AW' => [
                'label' => 'Aruba',
                'iso2' => 'AW',
                'iso3' => 'ABW',
                'num' => '533',
            ],
            'AU' => [
                'label' => 'Australia',
                'iso2' => 'AU',
                'iso3' => 'AUS',
                'num' => '036',
            ],
            'AT' => [
                'label' => 'Austria',
                'iso2' => 'AT',
                'iso3' => 'AUT',
                'num' => '040',
            ],
            'AZ' => [
                'label' => 'Azerbaijan',
                'iso2' => 'AZ',
                'iso3' => 'AZE',
                'num' => '031',
            ],
            'BS' => [
                'label' => 'Bahamas',
                'iso2' => 'BS',
                'iso3' => 'BHS',
                'num' => '044',
            ],
            'BH' => [
                'label' => 'Bahrain',
                'iso2' => 'BH',
                'iso3' => 'BHR',
                'num' => '048',
            ],
            'BD' => [
                'label' => 'Bangladesh',
                'iso2' => 'BD',
                'iso3' => 'BGD',
                'num' => '050',
            ],
            'BB' => [
                'label' => 'Barbados',
                'iso2' => 'BB',
                'iso3' => 'BRB',
                'num' => '052',
            ],
            'BY' => [
                'label' => 'Belarus',
                'iso2' => 'BY',
                'iso3' => 'BLR',
                'num' => '112',
            ],
            'BE' => [
                'label' => 'Belgium',
                'iso2' => 'BE',
                'iso3' => 'BEL',
                'num' => '056',
            ],
            'BZ' => [
                'label' => 'Belize',
                'iso2' => 'BZ',
                'iso3' => 'BLZ',
                'num' => '084',
            ],
            'BJ' => [
                'label' => 'Benin',
                'iso2' => 'BJ',
                'iso3' => 'BEN',
                'num' => '204',
            ],
            'BM' => [
                'label' => 'Bermuda',
                'iso2' => 'BM',
                'iso3' => 'BMU',
                'num' => '060',
            ],
            'BT' => [
                'label' => 'Bhutan',
                'iso2' => 'BT',
                'iso3' => 'BTN',
                'num' => '064',
            ],
            'BO' => [
                'label' => 'Bolivia (Plurinational State of)',
                'iso2' => 'BO',
                'iso3' => 'BOL',
                'num' => '068',
            ],
            'BQ' => [
                'label' => 'Bonaire, Sint Eustatius and Saba',
                'iso2' => 'BQ',
                'iso3' => 'BES',
                'num' => '535',
            ],
            'BA' => [
                'label' => 'Bosnia and Herzegovina',
                'iso2' => 'BA',
                'iso3' => 'BIH',
                'num' => '070',
            ],
            'BW' => [
                'label' => 'Botswana',
                'iso2' => 'BW',
                'iso3' => 'BWA',
                'num' => '072',
            ],
            'BV' => [
                'label' => 'Bouvet Island',
                'iso2' => 'BV',
                'iso3' => 'BVT',
                'num' => '074',
            ],
            'BR' => [
                'label' => 'Brazil',
                'iso2' => 'BR',
                'iso3' => 'BRA',
                'num' => '076',
            ],
            'IO' => [
                'label' => 'British Indian Ocean Territory',
                'iso2' => 'IO',
                'iso3' => 'IOT',
                'num' => '086',
            ],
            'BN' => [
                'label' => 'Brunei Darussalam',
                'iso2' => 'BN',
                'iso3' => 'BRN',
                'num' => '096',
            ],
            'BG' => [
                'label' => 'Bulgaria',
                'iso2' => 'BG',
                'iso3' => 'BGR',
                'num' => '100',
            ],
            'BF' => [
                'label' => 'Burkina Faso',
                'iso2' => 'BF',
                'iso3' => 'BFA',
                'num' => '854',
            ],
            'BI' => [
                'label' => 'Burundi',
                'iso2' => 'BI',
                'iso3' => 'BDI',
                'num' => '108',
            ],
            'CV' => [
                'label' => 'Cabo Verde',
                'iso2' => 'CV',
                'iso3' => 'CPV',
                'num' => '132',
            ],
            'KH' => [
                'label' => 'Cambodia',
                'iso2' => 'KH',
                'iso3' => 'KHM',
                'num' => '116',
            ],
            'CM' => [
                'label' => 'Cameroon',
                'iso2' => 'CM',
                'iso3' => 'CMR',
                'num' => '120',
            ],
            'CA' => [
                'label' => 'Canada',
                'iso2' => 'CA',
                'iso3' => 'CAN',
                'num' => '124',
            ],
            'KY' => [
                'label' => 'Cayman Islands',
                'iso2' => 'KY',
                'iso3' => 'CYM',
                'num' => '136',
            ],
            'CF' => [
                'label' => 'Central African Republic',
                'iso2' => 'CF',
                'iso3' => 'CAF',
                'num' => '140',
            ],
            'TD' => [
                'label' => 'Chad',
                'iso2' => 'TD',
                'iso3' => 'TCD',
                'num' => '148',
            ],
            'CL' => [
                'label' => 'Chile',
                'iso2' => 'CL',
                'iso3' => 'CHL',
                'num' => '152',
            ],
            'CN' => [
                'label' => 'China',
                'iso2' => 'CN',
                'iso3' => 'CHN',
                'num' => '156',
            ],
            'CX' => [
                'label' => 'Christmas Island',
                'iso2' => 'CX',
                'iso3' => 'CXR',
                'num' => '162',
            ],
            'CC' => [
                'label' => 'Cocos (Keeling) Islands',
                'iso2' => 'CC',
                'iso3' => 'CCK',
                'num' => '166',
            ],
            'CO' => [
                'label' => 'Colombia',
                'iso2' => 'CO',
                'iso3' => 'COL',
                'num' => '170',
            ],
            'KM' => [
                'label' => 'Comoros',
                'iso2' => 'KM',
                'iso3' => 'COM',
                'num' => '174',
            ],
            'CD' => [
                'label' => 'Congo (the Democratic Republic of the)',
                'iso2' => 'CD',
                'iso3' => 'COD',
                'num' => '180',
            ],
            'CG' => [
                'label' => 'Congo',
                'iso2' => 'CG',
                'iso3' => 'COG',
                'num' => '178',
            ],
            'CK' => [
                'label' => 'Cook Islands',
                'iso2' => 'CK',
                'iso3' => 'COK',
                'num' => '184',
            ],
            'CR' => [
                'label' => 'Costa Rica',
                'iso2' => 'CR',
                'iso3' => 'CRI',
                'num' => '188',
            ],
            'HR' => [
                'label' => 'Croatia',
                'iso2' => 'HR',
                'iso3' => 'HRV',
                'num' => '191',
            ],
            'CU' => [
                'label' => 'Cuba',
                'iso2' => 'CU',
                'iso3' => 'CUB',
                'num' => '192',
            ],
            'CW' => [
                'label' => 'Curaçao',
                'iso2' => 'CW',
                'iso3' => 'CUW',
                'num' => '531',
            ],
            'CY' => [
                'label' => 'Cyprus',
                'iso2' => 'CY',
                'iso3' => 'CYP',
                'num' => '196',
            ],
            'CZ' => [
                'label' => 'Czechia',
                'iso2' => 'CZ',
                'iso3' => 'CZE',
                'num' => '203',
            ],
            'CI' => [
                'label' => 'Côte d\'Ivoire',
                'iso2' => 'CI',
                'iso3' => 'CIV',
                'num' => '384',
            ],
            'DK' => [
                'label' => 'Denmark',
                'iso2' => 'DK',
                'iso3' => 'DNK',
                'num' => '208',
            ],
            'DJ' => [
                'label' => 'Djibouti',
                'iso2' => 'DJ',
                'iso3' => 'DJI',
                'num' => '262',
            ],
            'DM' => [
                'label' => 'Dominica',
                'iso2' => 'DM',
                'iso3' => 'DMA',
                'num' => '212',
            ],
            'DO' => [
                'label' => 'Dominican Republic',
                'iso2' => 'DO',
                'iso3' => 'DOM',
                'num' => '214',
            ],
            'EC' => [
                'label' => 'Ecuador',
                'iso2' => 'EC',
                'iso3' => 'ECU',
                'num' => '218',
            ],
            'EG' => [
                'label' => 'Egypt',
                'iso2' => 'EG',
                'iso3' => 'EGY',
                'num' => '818',
            ],
            'SV' => [
                'label' => 'El Salvador',
                'iso2' => 'SV',
                'iso3' => 'SLV',
                'num' => '222',
            ],
            'GQ' => [
                'label' => 'Equatorial Guinea',
                'iso2' => 'GQ',
                'iso3' => 'GNQ',
                'num' => '226',
            ],
            'ER' => [
                'label' => 'Eritrea',
                'iso2' => 'ER',
                'iso3' => 'ERI',
                'num' => '232',
            ],
            'EE' => [
                'label' => 'Estonia',
                'iso2' => 'EE',
                'iso3' => 'EST',
                'num' => '233',
            ],
            'SZ' => [
                'label' => 'Eswatini',
                'iso2' => 'SZ',
                'iso3' => 'SWZ',
                'num' => '748',
            ],
            'ET' => [
                'label' => 'Ethiopia',
                'iso2' => 'ET',
                'iso3' => 'ETH',
                'num' => '231',
            ],
            'FK' => [
                'label' => 'Falkland Islands [Malvinas]',
                'iso2' => 'FK',
                'iso3' => 'FLK',
                'num' => '238',
            ],
            'FO' => [
                'label' => 'Faroe Islands',
                'iso2' => 'FO',
                'iso3' => 'FRO',
                'num' => '234',
            ],
            'FJ' => [
                'label' => 'Fiji',
                'iso2' => 'FJ',
                'iso3' => 'FJI',
                'num' => '242',
            ],
            'FI' => [
                'label' => 'Finland',
                'iso2' => 'FI',
                'iso3' => 'FIN',
                'num' => '246',
            ],
            'FR' => [
                'label' => 'France',
                'iso2' => 'FR',
                'iso3' => 'FRA',
                'num' => '250',
            ],
            'GF' => [
                'label' => 'French Guiana',
                'iso2' => 'GF',
                'iso3' => 'GUF',
                'num' => '254',
            ],
            'PF' => [
                'label' => 'French Polynesia',
                'iso2' => 'PF',
                'iso3' => 'PYF',
                'num' => '258',
            ],
            'TF' => [
                'label' => 'French Southern Territories',
                'iso2' => 'TF',
                'iso3' => 'ATF',
                'num' => '260',
            ],
            'GA' => [
                'label' => 'Gabon',
                'iso2' => 'GA',
                'iso3' => 'GAB',
                'num' => '266',
            ],
            'GM' => [
                'label' => 'Gambia',
                'iso2' => 'GM',
                'iso3' => 'GMB',
                'num' => '270',
            ],
            'GE' => [
                'label' => 'Georgia',
                'iso2' => 'GE',
                'iso3' => 'GEO',
                'num' => '268',
            ],
            'DE' => [
                'label' => 'Germany',
                'iso2' => 'DE',
                'iso3' => 'DEU',
                'num' => '276',
            ],
            'GH' => [
                'label' => 'Ghana',
                'iso2' => 'GH',
                'iso3' => 'GHA',
                'num' => '288',
            ],
            'GI' => [
                'label' => 'Gibraltar',
                'iso2' => 'GI',
                'iso3' => 'GIB',
                'num' => '292',
            ],
            'GR' => [
                'label' => 'Greece',
                'iso2' => 'GR',
                'iso3' => 'GRC',
                'num' => '300',
            ],
            'GL' => [
                'label' => 'Greenland',
                'iso2' => 'GL',
                'iso3' => 'GRL',
                'num' => '304',
            ],
            'GD' => [
                'label' => 'Grenada',
                'iso2' => 'GD',
                'iso3' => 'GRD',
                'num' => '308',
            ],
            'GP' => [
                'label' => 'Guadeloupe',
                'iso2' => 'GP',
                'iso3' => 'GLP',
                'num' => '312',
            ],
            'GU' => [
                'label' => 'Guam',
                'iso2' => 'GU',
                'iso3' => 'GUM',
                'num' => '316',
            ],
            'GT' => [
                'label' => 'Guatemala',
                'iso2' => 'GT',
                'iso3' => 'GTM',
                'num' => '320',
            ],
            'GG' => [
                'label' => 'Guernsey',
                'iso2' => 'GG',
                'iso3' => 'GGY',
                'num' => '831',
            ],
            'GN' => [
                'label' => 'Guinea',
                'iso2' => 'GN',
                'iso3' => 'GIN',
                'num' => '324',
            ],
            'GW' => [
                'label' => 'Guinea-Bissau',
                'iso2' => 'GW',
                'iso3' => 'GNB',
                'num' => '624',
            ],
            'GY' => [
                'label' => 'Guyana',
                'iso2' => 'GY',
                'iso3' => 'GUY',
                'num' => '328',
            ],
            'HT' => [
                'label' => 'Haiti',
                'iso2' => 'HT',
                'iso3' => 'HTI',
                'num' => '332',
            ],
            'HM' => [
                'label' => 'Heard Island and McDonald Islands',
                'iso2' => 'HM',
                'iso3' => 'HMD',
                'num' => '334',
            ],
            'VA' => [
                'label' => 'Holy See',
                'iso2' => 'VA',
                'iso3' => 'VAT',
                'num' => '336',
            ],
            'HN' => [
                'label' => 'Honduras',
                'iso2' => 'HN',
                'iso3' => 'HND',
                'num' => '340',
            ],
            'HK' => [
                'label' => 'Hong Kong',
                'iso2' => 'HK',
                'iso3' => 'HKG',
                'num' => '344',
            ],
            'HU' => [
                'label' => 'Hungary',
                'iso2' => 'HU',
                'iso3' => 'HUN',
                'num' => '348',
            ],
            'IS' => [
                'label' => 'Iceland',
                'iso2' => 'IS',
                'iso3' => 'ISL',
                'num' => '352',
            ],
            'IN' => [
                'label' => 'India',
                'iso2' => 'IN',
                'iso3' => 'IND',
                'num' => '356',
            ],
            'ID' => [
                'label' => 'Indonesia',
                'iso2' => 'ID',
                'iso3' => 'IDN',
                'num' => '360',
            ],
            'IR' => [
                'label' => 'Iran (Islamic Republic of)',
                'iso2' => 'IR',
                'iso3' => 'IRN',
                'num' => '364',
            ],
            'IQ' => [
                'label' => 'Iraq',
                'iso2' => 'IQ',
                'iso3' => 'IRQ',
                'num' => '368',
            ],
            'IE' => [
                'label' => 'Ireland',
                'iso2' => 'IE',
                'iso3' => 'IRL',
                'num' => '372',
            ],
            'IM' => [
                'label' => 'Isle of Man',
                'iso2' => 'IM',
                'iso3' => 'IMN',
                'num' => '833',
            ],
            'IL' => [
                'label' => 'Israel',
                'iso2' => 'IL',
                'iso3' => 'ISR',
                'num' => '376',
            ],
            'IT' => [
                'label' => 'Italy',
                'iso2' => 'IT',
                'iso3' => 'ITA',
                'num' => '380',
            ],
            'JM' => [
                'label' => 'Jamaica',
                'iso2' => 'JM',
                'iso3' => 'JAM',
                'num' => '388',
            ],
            'JP' => [
                'label' => 'Japan',
                'iso2' => 'JP',
                'iso3' => 'JPN',
                'num' => '392',
            ],
            'JE' => [
                'label' => 'Jersey',
                'iso2' => 'JE',
                'iso3' => 'JEY',
                'num' => '832',
            ],
            'JO' => [
                'label' => 'Jordan',
                'iso2' => 'JO',
                'iso3' => 'JOR',
                'num' => '400',
            ],
            'KZ' => [
                'label' => 'Kazakhstan',
                'iso2' => 'KZ',
                'iso3' => 'KAZ',
                'num' => '398',
            ],
            'KE' => [
                'label' => 'Kenya',
                'iso2' => 'KE',
                'iso3' => 'KEN',
                'num' => '404',
            ],
            'KI' => [
                'label' => 'Kiribati',
                'iso2' => 'KI',
                'iso3' => 'KIR',
                'num' => '296',
            ],
            'KP' => [
                'label' => 'Korea (the Democratic People\'s Republic of)',
                'iso2' => 'KP',
                'iso3' => 'PRK',
                'num' => '408',
            ],
            'KR' => [
                'label' => 'Korea (the Republic of)',
                'iso2' => 'KR',
                'iso3' => 'KOR',
                'num' => '410',
            ],
            'KW' => [
                'label' => 'Kuwait',
                'iso2' => 'KW',
                'iso3' => 'KWT',
                'num' => '414',
            ],
            'KG' => [
                'label' => 'Kyrgyzstan',
                'iso2' => 'KG',
                'iso3' => 'KGZ',
                'num' => '417',
            ],
            'LA' => [
                'label' => 'Lao People\'s Democratic Republic',
                'iso2' => 'LA',
                'iso3' => 'LAO',
                'num' => '418',
            ],
            'LV' => [
                'label' => 'Latvia',
                'iso2' => 'LV',
                'iso3' => 'LVA',
                'num' => '428',
            ],
            'LB' => [
                'label' => 'Lebanon',
                'iso2' => 'LB',
                'iso3' => 'LBN',
                'num' => '422',
            ],
            'LS' => [
                'label' => 'Lesotho',
                'iso2' => 'LS',
                'iso3' => 'LSO',
                'num' => '426',
            ],
            'LR' => [
                'label' => 'Liberia',
                'iso2' => 'LR',
                'iso3' => 'LBR',
                'num' => '430',
            ],
            'LY' => [
                'label' => 'Libya',
                'iso2' => 'LY',
                'iso3' => 'LBY',
                'num' => '434',
            ],
            'LI' => [
                'label' => 'Liechtenstein',
                'iso2' => 'LI',
                'iso3' => 'LIE',
                'num' => '438',
            ],
            'LT' => [
                'label' => 'Lithuania',
                'iso2' => 'LT',
                'iso3' => 'LTU',
                'num' => '440',
            ],
            'LU' => [
                'label' => 'Luxembourg',
                'iso2' => 'LU',
                'iso3' => 'LUX',
                'num' => '442',
            ],
            'MO' => [
                'label' => 'Macao',
                'iso2' => 'MO',
                'iso3' => 'MAC',
                'num' => '446',
            ],
            'MG' => [
                'label' => 'Madagascar',
                'iso2' => 'MG',
                'iso3' => 'MDG',
                'num' => '450',
            ],
            'MW' => [
                'label' => 'Malawi',
                'iso2' => 'MW',
                'iso3' => 'MWI',
                'num' => '454',
            ],
            'MY' => [
                'label' => 'Malaysia',
                'iso2' => 'MY',
                'iso3' => 'MYS',
                'num' => '458',
            ],
            'MV' => [
                'label' => 'Maldives',
                'iso2' => 'MV',
                'iso3' => 'MDV',
                'num' => '462',
            ],
            'ML' => [
                'label' => 'Mali',
                'iso2' => 'ML',
                'iso3' => 'MLI',
                'num' => '466',
            ],
            'MT' => [
                'label' => 'Malta',
                'iso2' => 'MT',
                'iso3' => 'MLT',
                'num' => '470',
            ],
            'MH' => [
                'label' => 'Marshall Islands',
                'iso2' => 'MH',
                'iso3' => 'MHL',
                'num' => '584',
            ],
            'MQ' => [
                'label' => 'Martinique',
                'iso2' => 'MQ',
                'iso3' => 'MTQ',
                'num' => '474',
            ],
            'MR' => [
                'label' => 'Mauritania',
                'iso2' => 'MR',
                'iso3' => 'MRT',
                'num' => '478',
            ],
            'MU' => [
                'label' => 'Mauritius',
                'iso2' => 'MU',
                'iso3' => 'MUS',
                'num' => '480',
            ],
            'YT' => [
                'label' => 'Mayotte',
                'iso2' => 'YT',
                'iso3' => 'MYT',
                'num' => '175',
            ],
            'MX' => [
                'label' => 'Mexico',
                'iso2' => 'MX',
                'iso3' => 'MEX',
                'num' => '484',
            ],
            'FM' => [
                'label' => 'Micronesia',
                'iso2' => 'FM',
                'iso3' => 'FSM',
                'num' => '583',
            ],
            'MD' => [
                'label' => 'Moldova',
                'iso2' => 'MD',
                'iso3' => 'MDA',
                'num' => '498',
            ],
            'MC' => [
                'label' => 'Monaco',
                'iso2' => 'MC',
                'iso3' => 'MCO',
                'num' => '492',
            ],
            'MN' => [
                'label' => 'Mongolia',
                'iso2' => 'MN',
                'iso3' => 'MNG',
                'num' => '496',
            ],
            'ME' => [
                'label' => 'Montenegro',
                'iso2' => 'ME',
                'iso3' => 'MNE',
                'num' => '499',
            ],
            'MS' => [
                'label' => 'Montserrat',
                'iso2' => 'MS',
                'iso3' => 'MSR',
                'num' => '500',
            ],
            'MA' => [
                'label' => 'Morocco',
                'iso2' => 'MA',
                'iso3' => 'MAR',
                'num' => '504',
            ],
            'MZ' => [
                'label' => 'Mozambique',
                'iso2' => 'MZ',
                'iso3' => 'MOZ',
                'num' => '508',
            ],
            'MM' => [
                'label' => 'Myanmar',
                'iso2' => 'MM',
                'iso3' => 'MMR',
                'num' => '104',
            ],
            'NA' => [
                'label' => 'Namibia',
                'iso2' => 'NA',
                'iso3' => 'NAM',
                'num' => '516',
            ],
            'NR' => [
                'label' => 'Nauru',
                'iso2' => 'NR',
                'iso3' => 'NRU',
                'num' => '520',
            ],
            'NP' => [
                'label' => 'Nepal',
                'iso2' => 'NP',
                'iso3' => 'NPL',
                'num' => '524',
            ],
            'NL' => [
                'label' => 'Netherlands',
                'iso2' => 'NL',
                'iso3' => 'NLD',
                'num' => '528',
            ],
            'NC' => [
                'label' => 'New Caledonia',
                'iso2' => 'NC',
                'iso3' => 'NCL',
                'num' => '540',
            ],
            'NZ' => [
                'label' => 'New Zealand',
                'iso2' => 'NZ',
                'iso3' => 'NZL',
                'num' => '554',
            ],
            'NI' => [
                'label' => 'Nicaragua',
                'iso2' => 'NI',
                'iso3' => 'NIC',
                'num' => '558',
            ],
            'NE' => [
                'label' => 'Niger',
                'iso2' => 'NE',
                'iso3' => 'NER',
                'num' => '562',
            ],
            'NG' => [
                'label' => 'Nigeria',
                'iso2' => 'NG',
                'iso3' => 'NGA',
                'num' => '566',
            ],
            'NU' => [
                'label' => 'Niue',
                'iso2' => 'NU',
                'iso3' => 'NIU',
                'num' => '570',
            ],
            'NF' => [
                'label' => 'Norfolk Island',
                'iso2' => 'NF',
                'iso3' => 'NFK',
                'num' => '574',
            ],
            'MP' => [
                'label' => 'Northern Mariana Islands',
                'iso2' => 'MP',
                'iso3' => 'MNP',
                'num' => '580',
            ],
            'NO' => [
                'label' => 'Norway',
                'iso2' => 'NO',
                'iso3' => 'NOR',
                'num' => '578',
            ],
            'OM' => [
                'label' => 'Oman',
                'iso2' => 'OM',
                'iso3' => 'OMN',
                'num' => '512',
            ],
            'PK' => [
                'label' => 'Pakistan',
                'iso2' => 'PK',
                'iso3' => 'PAK',
                'num' => '586',
            ],
            'PW' => [
                'label' => 'Palau',
                'iso2' => 'PW',
                'iso3' => 'PLW',
                'num' => '585',
            ],
            'PS' => [
                'label' => 'Palestine, State of',
                'iso2' => 'PS',
                'iso3' => 'PSE',
                'num' => '275',
            ],
            'PA' => [
                'label' => 'Panama',
                'iso2' => 'PA',
                'iso3' => 'PAN',
                'num' => '591',
            ],
            'PG' => [
                'label' => 'Papua New Guinea',
                'iso2' => 'PG',
                'iso3' => 'PNG',
                'num' => '598',
            ],
            'PY' => [
                'label' => 'Paraguay',
                'iso2' => 'PY',
                'iso3' => 'PRY',
                'num' => '600',
            ],
            'PE' => [
                'label' => 'Peru',
                'iso2' => 'PE',
                'iso3' => 'PER',
                'num' => '604',
            ],
            'PH' => [
                'label' => 'Philippines',
                'iso2' => 'PH',
                'iso3' => 'PHL',
                'num' => '608',
            ],
            'PN' => [
                'label' => 'Pitcairn',
                'iso2' => 'PN',
                'iso3' => 'PCN',
                'num' => '612',
            ],
            'PL' => [
                'label' => 'Poland',
                'iso2' => 'PL',
                'iso3' => 'POL',
                'num' => '616',
            ],
            'PT' => [
                'label' => 'Portugal',
                'iso2' => 'PT',
                'iso3' => 'PRT',
                'num' => '620',
            ],
            'PR' => [
                'label' => 'Puerto Rico',
                'iso2' => 'PR',
                'iso3' => 'PRI',
                'num' => '630',
            ],
            'QA' => [
                'label' => 'Qatar',
                'iso2' => 'QA',
                'iso3' => 'QAT',
                'num' => '634',
            ],
            'MK' => [
                'label' => 'Republic of North Macedonia',
                'iso2' => 'MK',
                'iso3' => 'MKD',
                'num' => '807',
            ],
            'RO' => [
                'label' => 'Romania',
                'iso2' => 'RO',
                'iso3' => 'ROU',
                'num' => '642',
            ],
            'RU' => [
                'label' => 'Russian Federation',
                'iso2' => 'RU',
                'iso3' => 'RUS',
                'num' => '643',
            ],
            'RW' => [
                'label' => 'Rwanda',
                'iso2' => 'RW',
                'iso3' => 'RWA',
                'num' => '646',
            ],
            'RE' => [
                'label' => 'Réunion',
                'iso2' => 'RE',
                'iso3' => 'REU',
                'num' => '638',
            ],
            'BL' => [
                'label' => 'Saint Barthélemy',
                'iso2' => 'BL',
                'iso3' => 'BLM',
                'num' => '652',
            ],
            'SH' => [
                'label' => 'Saint Helena, Ascension and Tristan da Cunha',
                'iso2' => 'SH',
                'iso3' => 'SHN',
                'num' => '654',
            ],
            'KN' => [
                'label' => 'Saint Kitts and Nevis',
                'iso2' => 'KN',
                'iso3' => 'KNA',
                'num' => '659',
            ],
            'LC' => [
                'label' => 'Saint Lucia',
                'iso2' => 'LC',
                'iso3' => 'LCA',
                'num' => '662',
            ],
            'MF' => [
                'label' => 'Saint Martin (French part)',
                'iso2' => 'MF',
                'iso3' => 'MAF',
                'num' => '663',
            ],
            'PM' => [
                'label' => 'Saint Pierre and Miquelon',
                'iso2' => 'PM',
                'iso3' => 'SPM',
                'num' => '666',
            ],
            'VC' => [
                'label' => 'Saint Vincent and the Grenadines',
                'iso2' => 'VC',
                'iso3' => 'VCT',
                'num' => '670',
            ],
            'WS' => [
                'label' => 'Samoa',
                'iso2' => 'WS',
                'iso3' => 'WSM',
                'num' => '882',
            ],
            'SM' => [
                'label' => 'San Marino',
                'iso2' => 'SM',
                'iso3' => 'SMR',
                'num' => '674',
            ],
            'ST' => [
                'label' => 'Sao Tome and Principe',
                'iso2' => 'ST',
                'iso3' => 'STP',
                'num' => '678',
            ],
            'SA' => [
                'label' => 'Saudi Arabia',
                'iso2' => 'SA',
                'iso3' => 'SAU',
                'num' => '682',
            ],
            'SN' => [
                'label' => 'Senegal',
                'iso2' => 'SN',
                'iso3' => 'SEN',
                'num' => '686',
            ],
            'RS' => [
                'label' => 'Serbia',
                'iso2' => 'RS',
                'iso3' => 'SRB',
                'num' => '688',
            ],
            'SC' => [
                'label' => 'Seychelles',
                'iso2' => 'SC',
                'iso3' => 'SYC',
                'num' => '690',
            ],
            'SL' => [
                'label' => 'Sierra Leone',
                'iso2' => 'SL',
                'iso3' => 'SLE',
                'num' => '694',
            ],
            'SG' => [
                'label' => 'Singapore',
                'iso2' => 'SG',
                'iso3' => 'SGP',
                'num' => '702',
            ],
            'SX' => [
                'label' => 'Sint Maarten (Dutch part)',
                'iso2' => 'SX',
                'iso3' => 'SXM',
                'num' => '534',
            ],
            'SK' => [
                'label' => 'Slovakia',
                'iso2' => 'SK',
                'iso3' => 'SVK',
                'num' => '703',
            ],
            'SI' => [
                'label' => 'Slovenia',
                'iso2' => 'SI',
                'iso3' => 'SVN',
                'num' => '705',
            ],
            'SB' => [
                'label' => 'Solomon Islands',
                'iso2' => 'SB',
                'iso3' => 'SLB',
                'num' => '090',
            ],
            'SO' => [
                'label' => 'Somalia',
                'iso2' => 'SO',
                'iso3' => 'SOM',
                'num' => '706',
            ],
            'ZA' => [
                'label' => 'South Africa',
                'iso2' => 'ZA',
                'iso3' => 'ZAF',
                'num' => '710',
            ],
            'GS' => [
                'label' => 'South Georgia and the South Sandwich Islands',
                'iso2' => 'GS',
                'iso3' => 'SGS',
                'num' => '239',
            ],
            'SS' => [
                'label' => 'South Sudan',
                'iso2' => 'SS',
                'iso3' => 'SSD',
                'num' => '728',
            ],
            'ES' => [
                'label' => 'Spain',
                'iso2' => 'ES',
                'iso3' => 'ESP',
                'num' => '724',
            ],
            'LK' => [
                'label' => 'Sri Lanka',
                'iso2' => 'LK',
                'iso3' => 'LKA',
                'num' => '144',
            ],
            'SD' => [
                'label' => 'Sudan',
                'iso2' => 'SD',
                'iso3' => 'SDN',
                'num' => '729',
            ],
            'SR' => [
                'label' => 'Suriname',
                'iso2' => 'SR',
                'iso3' => 'SUR',
                'num' => '740',
            ],
            'SJ' => [
                'label' => 'Svalbard and Jan Mayen',
                'iso2' => 'SJ',
                'iso3' => 'SJM',
                'num' => '744',
            ],
            'SE' => [
                'label' => 'Sweden',
                'iso2' => 'SE',
                'iso3' => 'SWE',
                'num' => '752',
            ],
            'CH' => [
                'label' => 'Switzerland',
                'iso2' => 'CH',
                'iso3' => 'CHE',
                'num' => '756',
            ],
            'SY' => [
                'label' => 'Syrian Arab Republic',
                'iso2' => 'SY',
                'iso3' => 'SYR',
                'num' => '760',
            ],
            'TW' => [
                'label' => 'Taiwan (Province of China)',
                'iso2' => 'TW',
                'iso3' => 'TWN',
                'num' => '158',
            ],
            'TJ' => [
                'label' => 'Tajikistan',
                'iso2' => 'TJ',
                'iso3' => 'TJK',
                'num' => '762',
            ],
            'TZ' => [
                'label' => 'Tanzania, United Republic of',
                'iso2' => 'TZ',
                'iso3' => 'TZA',
                'num' => '834',
            ],
            'TH' => [
                'label' => 'Thailand',
                'iso2' => 'TH',
                'iso3' => 'THA',
                'num' => '764',
            ],
            'TL' => [
                'label' => 'Timor-Leste',
                'iso2' => 'TL',
                'iso3' => 'TLS',
                'num' => '626',
            ],
            'TG' => [
                'label' => 'Togo',
                'iso2' => 'TG',
                'iso3' => 'TGO',
                'num' => '768',
            ],
            'TK' => [
                'label' => 'Tokelau',
                'iso2' => 'TK',
                'iso3' => 'TKL',
                'num' => '772',
            ],
            'TO' => [
                'label' => 'Tonga',
                'iso2' => 'TO',
                'iso3' => 'TON',
                'num' => '776',
            ],
            'TT' => [
                'label' => 'Trinidad and Tobago',
                'iso2' => 'TT',
                'iso3' => 'TTO',
                'num' => '780',
            ],
            'TN' => [
                'label' => 'Tunisia',
                'iso2' => 'TN',
                'iso3' => 'TUN',
                'num' => '788',
            ],
            'TR' => [
                'label' => 'Turkey',
                'iso2' => 'TR',
                'iso3' => 'TUR',
                'num' => '792',
            ],
            'TM' => [
                'label' => 'Turkmenistan',
                'iso2' => 'TM',
                'iso3' => 'TKM',
                'num' => '795',
            ],
            'TC' => [
                'label' => 'Turks and Caicos Islands',
                'iso2' => 'TC',
                'iso3' => 'TCA',
                'num' => '796',
            ],
            'TV' => [
                'label' => 'Tuvalu',
                'iso2' => 'TV',
                'iso3' => 'TUV',
                'num' => '798',
            ],
            'UG' => [
                'label' => 'Uganda',
                'iso2' => 'UG',
                'iso3' => 'UGA',
                'num' => '800',
            ],
            'UA' => [
                'label' => 'Ukraine',
                'iso2' => 'UA',
                'iso3' => 'UKR',
                'num' => '804',
            ],
            'AE' => [
                'label' => 'United Arab Emirates',
                'iso2' => 'AE',
                'iso3' => 'ARE',
                'num' => '784',
            ],
            'GB' => [
                'label' => 'United Kingdom',
                'iso2' => 'GB',
                'iso3' => 'GBR',
                'num' => '826',
            ],
            'UM' => [
                'label' => 'United States Minor Outlying Islands',
                'iso2' => 'UM',
                'iso3' => 'UMI',
                'num' => '581',
            ],
            'US' => [
                'label' => 'United States of America',
                'iso2' => 'US',
                'iso3' => 'USA',
                'num' => '840',
            ],
            'UY' => [
                'label' => 'Uruguay',
                'iso2' => 'UY',
                'iso3' => 'URY',
                'num' => '858',
            ],
            'UZ' => [
                'label' => 'Uzbekistan',
                'iso2' => 'UZ',
                'iso3' => 'UZB',
                'num' => '860',
            ],
            'VU' => [
                'label' => 'Vanuatu',
                'iso2' => 'VU',
                'iso3' => 'VUT',
                'num' => '548',
            ],
            'VE' => [
                'label' => 'Venezuela',
                'iso2' => 'VE',
                'iso3' => 'VEN',
                'num' => '862',
            ],
            'VN' => [
                'label' => 'Viet Nam',
                'iso2' => 'VN',
                'iso3' => 'VNM',
                'num' => '704',
            ],
            'VG' => [
                'label' => 'Virgin Islands (British)',
                'iso2' => 'VG',
                'iso3' => 'VGB',
                'num' => '092',
            ],
            'VI' => [
                'label' => 'Virgin Islands (U.S.)',
                'iso2' => 'VI',
                'iso3' => 'VIR',
                'num' => '850',
            ],
            'WF' => [
                'label' => 'Wallis and Futuna',
                'iso2' => 'WF',
                'iso3' => 'WLF',
                'num' => '876',
            ],
            'EH' => [
                'label' => 'Western Sahara',
                'iso2' => 'EH',
                'iso3' => 'ESH',
                'num' => '732',
            ],
            'YE' => [
                'label' => 'Yemen',
                'iso2' => 'YE',
                'iso3' => 'YEM',
                'num' => '887',
            ],
            'ZM' => [
                'label' => 'Zambia',
                'iso2' => 'ZM',
                'iso3' => 'ZMB',
                'num' => '894',
            ],
            'ZW' => [
                'label' => 'Zimbabwe',
                'iso2' => 'ZW',
                'iso3' => 'ZWE',
                'num' => '716',
            ],
            'AX' => [
                'label' => 'Åland Islands',
                'iso2' => 'AX',
                'iso3' => 'ALA',
                'num' => '248',
            ],
        ];

        foreach (array_keys(self::$defns) as $iso2) {
            self::$defns[$iso2]['eu'] = in_array($iso2, $eu);
        }

        return self::$defns;
    }
}
