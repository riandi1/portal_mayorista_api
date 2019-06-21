<?php

use Illuminate\Database\Seeder;
use App\Models\System\Parametrics\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [
                "name" => "AFGHANISTAN",
                "iso2" => "AF",
                "iso3" => "AFG",
                "telephone_prefix" => '93',
                "latitude" => 34,
                "longitude" => 68
            ],
            [
                "name" => "ALBANIA",
                "iso2" => "AL",
                "iso3" => "ALB",
                "telephone_prefix" => '355',
                "latitude" => 41,
                "longitude" => 20
            ],
            [
                "name" => "GERMANY",
                "iso2" => "DE",
                "iso3" => "DEU",
                "telephone_prefix" => '49',
                "latitude" => 51,
                "longitude" => 10
            ],
            [
                "name" => "ALGERIA",
                "iso2" => "DZ",
                "iso3" => "DZA",
                "telephone_prefix" => '213',
                "latitude" => 28,
                "longitude" => 2
            ],
            [
                "name" => "ANDORRA",
                "iso2" => "AD",
                "iso3" => "AND",
                "telephone_prefix" => '376',
                "latitude" => 43,
                "longitude" => 2
            ],
            [
                "name" => "ANGOLA",
                "iso2" => "AO",
                "iso3" => "AGO",
                "telephone_prefix" => '244',
                "latitude" => -11,
                "longitude" => 18
            ],
            [
                "name" => "ANGUILLA",
                "iso2" => "AI",
                "iso3" => "AIA",
                "telephone_prefix" => '264',
                "latitude" => 18,
                "longitude" => -63
            ],
            [
                "name" => "ANTARCTICA",
                "iso2" => "AQ",
                "iso3" => "ATA",
                "telephone_prefix" => '672',
                "latitude" => -75,
                "longitude" => 0
            ],
            [
                "name" => "ANTIGUA AND BARBUDA",
                "iso2" => "AG",
                "iso3" => "ATG",
                "telephone_prefix" => '268',
                "latitude" => 17,
                "longitude" => -62
            ],
            [
                "name" => "NETHERLANDS ANTILLES",
                "iso2" => "AN",
                "iso3" => "ANT",
                "telephone_prefix" => '599',
                "latitude" => 12,
                "longitude" => -69
            ],
            [
                "name" => "SAUDI ARABIA",
                "iso2" => "SA",
                "iso3" => "SAU",
                "telephone_prefix" => '966',
                "latitude" => 24,
                "longitude" => 45
            ],
            [
                "name" => "ARGENTINA",
                "iso2" => "AR",
                "iso3" => "ARG",
                "telephone_prefix" => '54',
                "latitude" => -38,
                "longitude" => -64
            ],
            [
                "name" => "ARMENIA",
                "iso2" => "AM",
                "iso3" => "ARM",
                "telephone_prefix" => '374',
                "latitude" => 40,
                "longitude" => 45
            ],
            [
                "name" => "ARUBA",
                "iso2" => "AW",
                "iso3" => "ABW",
                "telephone_prefix" => '297',
                "latitude" => 13,
                "longitude" => -70
            ],
            [
                "name" => "AUSTRALIA",
                "iso2" => "AU",
                "iso3" => "AUS",
                "telephone_prefix" => '61',
                "latitude" => -25,
                "longitude" => 134
            ],
            [
                "name" => "AUSTRIA",
                "iso2" => "AT",
                "iso3" => "AUT",
                "telephone_prefix" => '43',
                "latitude" => 48,
                "longitude" => 15
            ],
            [
                "name" => "AZERBAIJAN",
                "iso2" => "AZ",
                "iso3" => "AZE",
                "telephone_prefix" => '994',
                "latitude" => 40,
                "longitude" => 48
            ],
            [
                "name" => "BELGIUM",
                "iso2" => "BE",
                "iso3" => "BEL",
                "telephone_prefix" => '32',
                "latitude" => 51,
                "longitude" => 4
            ],
            [
                "name" => "BAHAMAS",
                "iso2" => "BS",
                "iso3" => "BHS",
                "telephone_prefix" => '242',
                "latitude" => 25,
                "longitude" => -77
            ],
            [
                "name" => "BAHRAIN",
                "iso2" => "BH",
                "iso3" => "BHR",
                "telephone_prefix" => '973',
                "latitude" => 26,
                "longitude" => 51
            ],
            [
                "name" => "BANGLADESH",
                "iso2" => "BD",
                "iso3" => "BGD",
                "telephone_prefix" => '880',
                "latitude" => 24,
                "longitude" => 90
            ],
            [
                "name" => "BARBADOS",
                "iso2" => "BB",
                "iso3" => "BRB",
                "telephone_prefix" => '246',
                "latitude" => 13,
                "longitude" => -60
            ],
            [
                "name" => "BELIZE",
                "iso2" => "BZ",
                "iso3" => "BLZ",
                "telephone_prefix" => '501',
                "latitude" => 17,
                "longitude" => -88
            ],
            [
                "name" => "BENIN",
                "iso2" => "BJ",
                "iso3" => "BEN",
                "telephone_prefix" => '229',
                "latitude" => 9,
                "longitude" => 2
            ],
            [
                "name" => "BHUTAN",
                "iso2" => "BT",
                "iso3" => "BTN",
                "telephone_prefix" => '975',
                "latitude" => 28,
                "longitude" => 90
            ],
            [
                "name" => "BELARUS",
                "iso2" => "BY",
                "iso3" => "BLR",
                "telephone_prefix" => '375',
                "latitude" => 54,
                "longitude" => 28
            ],
            [
                "name" => "MYANMAR",
                "iso2" => "MM",
                "iso3" => "MMR",
                "telephone_prefix" => '95',
                "latitude" => 22,
                "longitude" => 96
            ],
            [
                "name" => "BOLIVIA",
                "iso2" => "BO",
                "iso3" => "BOL",
                "telephone_prefix" => '591',
                "latitude" => -16,
                "longitude" => -64
            ],
            [
                "name" => "BOSNIA AND HERZEGOVINA",
                "iso2" => "BA",
                "iso3" => "BIH",
                "telephone_prefix" => '387',
                "latitude" => 44,
                "longitude" => 18
            ],
            [
                "name" => "BOTSWANA",
                "iso2" => "BW",
                "iso3" => "BWA",
                "telephone_prefix" => '267',
                "latitude" => -22,
                "longitude" => 25
            ],
            [
                "name" => "BRAZIL",
                "iso2" => "BR",
                "iso3" => "BRA",
                "telephone_prefix" => '55',
                "latitude" => -14,
                "longitude" => -52
            ],
            [
                "name" => "BRUNEI",
                "iso2" => "BN",
                "iso3" => "BRN",
                "telephone_prefix" => '673',
                "latitude" => 5,
                "longitude" => 115
            ],
            [
                "name" => "BULGARIA",
                "iso2" => "BG",
                "iso3" => "BGR",
                "telephone_prefix" => '359',
                "latitude" => 43,
                "longitude" => 25
            ],
            [
                "name" => "BURKINA FASO",
                "iso2" => "BF",
                "iso3" => "BFA",
                "telephone_prefix" => '226',
                "latitude" => 12,
                "longitude" => -2
            ],
            [
                "name" => "BURUNDI",
                "iso2" => "BI",
                "iso3" => "BDI",
                "telephone_prefix" => '257',
                "latitude" => -3,
                "longitude" => 30
            ],
            [
                "name" => "CAPE VERDE",
                "iso2" => "CV",
                "iso3" => "CPV",
                "telephone_prefix" => '238',
                "latitude" => 16,
                "longitude" => -24
            ],
            [
                "name" => "CAMBODIA",
                "iso2" => "KH",
                "iso3" => "KHM",
                "telephone_prefix" => '855',
                "latitude" => 13,
                "longitude" => 105
            ],
            [
                "name" => "CAMEROON",
                "iso2" => "CM",
                "iso3" => "CMR",
                "telephone_prefix" => '237',
                "latitude" => 7,
                "longitude" => 12
            ],
            [
                "name" => "CANADA",
                "iso2" => "CA",
                "iso3" => "CAN",
                "telephone_prefix" => '1',
                "latitude" => 56,
                "longitude" => -106
            ],
            [
                "name" => "CHAD",
                "iso2" => "TD",
                "iso3" => "TCD",
                "telephone_prefix" => '235',
                "latitude" => 15,
                "longitude" => 19
            ],
            [
                "name" => "CHILE",
                "iso2" => "CL",
                "iso3" => "CHL",
                "telephone_prefix" => '56',
                "latitude" => -36,
                "longitude" => -72
            ],
            [
                "name" => "CHINA",
                "iso2" => "CN",
                "iso3" => "CHN",
                "telephone_prefix" => '86',
                "latitude" => 36,
                "longitude" => 104
            ],
            [
                "name" => "CYPRUS",
                "iso2" => "CY",
                "iso3" => "CYP",
                "telephone_prefix" => '357',
                "latitude" => 35,
                "longitude" => 33
            ],
            [
                "name" => "VATICAN CITY STATE",
                "iso2" => "VA",
                "iso3" => "VAT",
                "telephone_prefix" => '39',
                "latitude" => 42,
                "longitude" => 12
            ],
            [
                "name" => "COLOMBIA",
                "iso2" => "CO",
                "iso3" => "COL",
                "telephone_prefix" => '57',
                "latitude" => 5,
                "longitude" => -74,
                "coint" => "Peso colombiano",
                "coint_value" =>'3000'
            ],
            [
                "name" => "COMOROS",
                "iso2" => "KM",
                "iso3" => "COM",
                "telephone_prefix" => '269',
                "latitude" => -12,
                "longitude" => 44
            ],
            [
                "name" => "CONGO",
                "iso2" => "CG",
                "iso3" => "COG",
                "telephone_prefix" => '242',
                "latitude" => 0,
                "longitude" => 16
            ],
            [
                "name" => "CONGO",
                "iso2" => "CD",
                "iso3" => "COD",
                "telephone_prefix" => '243',
                "latitude" => -4,
                "longitude" => 22
            ],
            [
                "name" => "NORTH KOREA",
                "iso2" => "KP",
                "iso3" => "PRK",
                "telephone_prefix" => '850',
                "latitude" => 40,
                "longitude" => 128
            ],
            [
                "name" => "SOUTH KOREA",
                "iso2" => "KR",
                "iso3" => "KOR",
                "telephone_prefix" => '82',
                "latitude" => 36,
                "longitude" => 128
            ],
            [
                "name" => "IVORY COAST",
                "iso2" => "CI",
                "iso3" => "CIV",
                "telephone_prefix" => '225',
                "latitude" => 8,
                "longitude" => -6
            ],
            [
                "name" => "COSTA RICA",
                "iso2" => "CR",
                "iso3" => "CRI",
                "telephone_prefix" => '506',
                "latitude" => 10,
                "longitude" => -84
            ],
            [
                "name" => "CROATIA",
                "iso2" => "HR",
                "iso3" => "HRV",
                "telephone_prefix" => '385',
                "latitude" => 45,
                "longitude" => 15
            ],
            [
                "name" => "CUBA",
                "iso2" => "CU",
                "iso3" => "CUB",
                "telephone_prefix" => '53',
                "latitude" => 22,
                "longitude" => -78
            ],
            [
                "name" => "DENMARK",
                "iso2" => "DK",
                "iso3" => "DNK",
                "telephone_prefix" => '45',
                "latitude" => 56,
                "longitude" => 10
            ],
            [
                "name" => "DOMINICA",
                "iso2" => "DM",
                "iso3" => "DMA",
                "telephone_prefix" => '767',
                "latitude" => 15,
                "longitude" => -61
            ],
            [
                "name" => "ECUADOR",
                "iso2" => "EC",
                "iso3" => "ECU",
                "telephone_prefix" => '593',
                "latitude" => -2,
                "longitude" => -78
            ],
            [
                "name" => "EGYPT",
                "iso2" => "EG",
                "iso3" => "EGY",
                "telephone_prefix" => '20',
                "latitude" => 27,
                "longitude" => 31
            ],
            [
                "name" => "EL SALVADOR",
                "iso2" => "SV",
                "iso3" => "SLV",
                "telephone_prefix" => '503',
                "latitude" => 14,
                "longitude" => -89
            ],
            [
                "name" => "UNITED ARAB EMIRATES",
                "iso2" => "AE",
                "iso3" => "ARE",
                "telephone_prefix" => '971',
                "latitude" => 23,
                "longitude" => 54
            ],
            [
                "name" => "ERITREA",
                "iso2" => "ER",
                "iso3" => "ERI",
                "telephone_prefix" => '291',
                "latitude" => 15,
                "longitude" => 40
            ],
            [
                "name" => "SLOVAKIA",
                "iso2" => "SK",
                "iso3" => "SVK",
                "telephone_prefix" => '421',
                "latitude" => 49,
                "longitude" => 20
            ],
            [
                "name" => "SLOVENIA",
                "iso2" => "SI",
                "iso3" => "SVN",
                "telephone_prefix" => '386',
                "latitude" => 46,
                "longitude" => 15
            ],
            [
                "name" => "SPAIN",
                "iso2" => "ES",
                "iso3" => "ESP",
                "telephone_prefix" => '34',
                "latitude" => 40,
                "longitude" => -4
            ],
            [
                "name" => "UNITED STATES OF AMERICA",
                "iso2" => "US",
                "iso3" => "USA",
                "telephone_prefix" => '1',
                "latitude" => 37,
                "longitude" => -96,
                "coint" => "Dólar estadounidense",
                "coint_value" =>'1'
            ],
            [
                "name" => "ESTONIA",
                "iso2" => "EE",
                "iso3" => "EST",
                "telephone_prefix" => '372',
                "latitude" => 59,
                "longitude" => 25
            ],
            [
                "name" => "ETHIOPIA",
                "iso2" => "ET",
                "iso3" => "ETH",
                "telephone_prefix" => '251',
                "latitude" => 9,
                "longitude" => 40
            ],
            [
                "name" => "PHILIPPINES",
                "iso2" => "PH",
                "iso3" => "PHL",
                "telephone_prefix" => '63',
                "latitude" => 13,
                "longitude" => 122
            ],
            [
                "name" => "FINLAND",
                "iso2" => "FI",
                "iso3" => "FIN",
                "telephone_prefix" => '358',
                "latitude" => 62,
                "longitude" => 26
            ],
            [
                "name" => "FIJI",
                "iso2" => "FJ",
                "iso3" => "FJI",
                "telephone_prefix" => '679',
                "latitude" => -17,
                "longitude" => 179
            ],
            [
                "name" => "FRANCE",
                "iso2" => "FR",
                "iso3" => "FRA",
                "telephone_prefix" => '33',
                "latitude" => 46,
                "longitude" => 2
            ],
            [
                "name" => "GABON",
                "iso2" => "GA",
                "iso3" => "GAB",
                "telephone_prefix" => '241',
                "latitude" => -1,
                "longitude" => 12
            ],
            [
                "name" => "GAMBIA",
                "iso2" => "GM",
                "iso3" => "GMB",
                "telephone_prefix" => '220',
                "latitude" => 13,
                "longitude" => -15
            ],
            [
                "name" => "GEORGIA",
                "iso2" => "GE",
                "iso3" => "GEO",
                "telephone_prefix" => '995',
                "latitude" => 42,
                "longitude" => 43
            ],
            [
                "name" => "GHANA",
                "iso2" => "GH",
                "iso3" => "GHA",
                "telephone_prefix" => '233',
                "latitude" => 8,
                "longitude" => -1
            ],
            [
                "name" => "GIBRALTAR",
                "iso2" => "GI",
                "iso3" => "GIB",
                "telephone_prefix" => '350',
                "latitude" => 36,
                "longitude" => -5
            ],
            [
                "name" => "GRENADA",
                "iso2" => "GD",
                "iso3" => "GRD",
                "telephone_prefix" => '473',
                "latitude" => 12,
                "longitude" => -62
            ],
            [
                "name" => "GREECE",
                "iso2" => "GR",
                "iso3" => "GRC",
                "telephone_prefix" => '30',
                "latitude" => 39,
                "longitude" => 22
            ],
            [
                "name" => "GREENLAND",
                "iso2" => "GL",
                "iso3" => "GRL",
                "telephone_prefix" => '299',
                "latitude" => 72,
                "longitude" => -43
            ],
            [
                "name" => "GUADELOUPE",
                "iso2" => "GP",
                "iso3" => "GLP",
                "telephone_prefix" => '0',
                "latitude" => 17,
                "longitude" => -62
            ],
            [
                "name" => "GUAM",
                "iso2" => "GU",
                "iso3" => "GUM",
                "telephone_prefix" => '671',
                "latitude" => 13,
                "longitude" => 145
            ],
            [
                "name" => "GUATEMALA",
                "iso2" => "GT",
                "iso3" => "GTM",
                "telephone_prefix" => '502',
                "latitude" => 16,
                "longitude" => -90
            ],
            [
                "name" => "FRENCH GUIANA",
                "iso2" => "GF",
                "iso3" => "GUF",
                "telephone_prefix" => '0',
                "latitude" => 4,
                "longitude" => -53
            ],
            [
                "name" => "GUERNSEY",
                "iso2" => "GG",
                "iso3" => "GGY",
                "telephone_prefix" => '0',
                "latitude" => 49,
                "longitude" => -3
            ],
            [
                "name" => "GUINEA",
                "iso2" => "GN",
                "iso3" => "GIN",
                "telephone_prefix" => '224',
                "latitude" => 10,
                "longitude" => -10
            ],
            [
                "name" => "EQUATORIAL GUINEA",
                "iso2" => "GQ",
                "iso3" => "GNQ",
                "telephone_prefix" => '240',
                "latitude" => 2,
                "longitude" => 10
            ],
            [
                "name" => "GUINEA-BISSAU",
                "iso2" => "GW",
                "iso3" => "GNB",
                "telephone_prefix" => '245',
                "latitude" => 12,
                "longitude" => -15
            ],
            [
                "name" => "GUYANA",
                "iso2" => "GY",
                "iso3" => "GUY",
                "telephone_prefix" => '592',
                "latitude" => 5,
                "longitude" => -59
            ],
            [
                "name" => "HAITI",
                "iso2" => "HT",
                "iso3" => "HTI",
                "telephone_prefix" => '509',
                "latitude" => 19,
                "longitude" => -72
            ],
            [
                "name" => "HONDURAS",
                "iso2" => "HN",
                "iso3" => "HND",
                "telephone_prefix" => '504',
                "latitude" => 15,
                "longitude" => -86
            ],
            [
                "name" => "HONG KONG",
                "iso2" => "HK",
                "iso3" => "HKG",
                "telephone_prefix" => '852',
                "latitude" => 22,
                "longitude" => 114
            ],
            [
                "name" => "HUNGARY",
                "iso2" => "HU",
                "iso3" => "HUN",
                "telephone_prefix" => '36',
                "latitude" => 47,
                "longitude" => 20
            ],
            [
                "name" => "INDIA",
                "iso2" => "IN",
                "iso3" => "IND",
                "telephone_prefix" => '91',
                "latitude" => 21,
                "longitude" => 79
            ],
            [
                "name" => "INDONESIA",
                "iso2" => "ID",
                "iso3" => "IDN",
                "telephone_prefix" => '62',
                "latitude" => -1,
                "longitude" => 114
            ],
            [
                "name" => "IRAN",
                "iso2" => "IR",
                "iso3" => "IRN",
                "telephone_prefix" => '98',
                "latitude" => 32,
                "longitude" => 54
            ],
            [
                "name" => "IRAQ",
                "iso2" => "IQ",
                "iso3" => "IRQ",
                "telephone_prefix" => '964',
                "latitude" => 33,
                "longitude" => 44
            ],
            [
                "name" => "IRELAND",
                "iso2" => "IE",
                "iso3" => "IRL",
                "telephone_prefix" => '353',
                "latitude" => 53,
                "longitude" => -8
            ],
            [
                "name" => "BOUVET ISLAND",
                "iso2" => "BV",
                "iso3" => "BVT",
                "telephone_prefix" => '0',
                "latitude" => -54,
                "longitude" => 3
            ],
            [
                "name" => "ISLE OF MAN",
                "iso2" => "IM",
                "iso3" => "IMN",
                "telephone_prefix" => '44',
                "latitude" => 54,
                "longitude" => -5
            ],
            [
                "name" => "CHRISTMAS ISLAND",
                "iso2" => "CX",
                "iso3" => "CXR",
                "telephone_prefix" => '61',
                "latitude" => -10,
                "longitude" => 106
            ],
            [
                "name" => "NORFOLK ISLAND",
                "iso2" => "NF",
                "iso3" => "NFK",
                "telephone_prefix" => '0',
                "latitude" => -29,
                "longitude" => 168
            ],
            [
                "name" => "ICELAND",
                "iso2" => "IS",
                "iso3" => "ISL",
                "telephone_prefix" => '354',
                "latitude" => 65,
                "longitude" => -19
            ],
            [
                "name" => "BERMUDA ISLANDS",
                "iso2" => "BM",
                "iso3" => "BMU",
                "telephone_prefix" => '441',
                "latitude" => 32,
                "longitude" => -65
            ],
            [
                "name" => "CAYMAN ISLANDS",
                "iso2" => "KY",
                "iso3" => "CYM",
                "telephone_prefix" => '345',
                "latitude" => 20,
                "longitude" => -81
            ],
            [
                "name" => "COCOS (KEELING) ISLANDS",
                "iso2" => "CC",
                "iso3" => "CCK",
                "telephone_prefix" => '61',
                "latitude" => -12,
                "longitude" => 97
            ],
            [
                "name" => "COOK ISLANDS",
                "iso2" => "CK",
                "iso3" => "COK",
                "telephone_prefix" => '682',
                "latitude" => -21,
                "longitude" => -160
            ],
            [
                "name" => "ALAND ISLANDS",
                "iso2" => "AX",
                "iso3" => "ALA",
                "telephone_prefix" => '0',
                "latitude" => 60,
                "longitude" => 20
            ],
            [
                "name" => "FAROE ISLANDS",
                "iso2" => "FO",
                "iso3" => "FRO",
                "telephone_prefix" => '298',
                "latitude" => 62,
                "longitude" => -7
            ],
            [
                "name" => "SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS",
                "iso2" => "GS",
                "iso3" => "SGS",
                "telephone_prefix" => '0',
                "latitude" => -54,
                "longitude" => -37
            ],
            [
                "name" => "HEARD ISLAND AND MCDONALD ISLANDS",
                "iso2" => "HM",
                "iso3" => "HMD",
                "telephone_prefix" => '0',
                "latitude" => -53,
                "longitude" => 74
            ],
            [
                "name" => "MALDIVES",
                "iso2" => "MV",
                "iso3" => "MDV",
                "telephone_prefix" => '960',
                "latitude" => 3,
                "longitude" => 73
            ],
            [
                "name" => "FALKLAND ISLANDS (MALVINAS)",
                "iso2" => "FK",
                "iso3" => "FLK",
                "telephone_prefix" => '500',
                "latitude" => -52,
                "longitude" => -60
            ],
            [
                "name" => "NORTHERN MARIANA ISLANDS",
                "iso2" => "MP",
                "iso3" => "MNP",
                "telephone_prefix" => '670',
                "latitude" => 17,
                "longitude" => 145
            ],
            [
                "name" => "MARSHALL ISLANDS",
                "iso2" => "MH",
                "iso3" => "MHL",
                "telephone_prefix" => '692',
                "latitude" => 7,
                "longitude" => 171
            ],
            [
                "name" => "PITCAIRN ISLANDS",
                "iso2" => "PN",
                "iso3" => "PCN",
                "telephone_prefix" => '870',
                "latitude" => -25,
                "longitude" => -127
            ],
            [
                "name" => "SOLOMON ISLANDS",
                "iso2" => "SB",
                "iso3" => "SLB",
                "telephone_prefix" => '677',
                "latitude" => -10,
                "longitude" => 160
            ],
            [
                "name" => "TURKS AND CAICOS ISLANDS",
                "iso2" => "TC",
                "iso3" => "TCA",
                "telephone_prefix" => '649',
                "latitude" => 22,
                "longitude" => -72
            ],
            [
                "name" => "UNITED STATES MINOR OUTLYING ISLANDS",
                "iso2" => "UM",
                "iso3" => "UMI",
                "telephone_prefix" => '0',
                "latitude" => 19,
                "longitude" => 167
            ],
            [
                "name" => "VIRGIN ISLANDS",
                "iso2" => "VG",
                "iso3" => "VG",
                "telephone_prefix" => '284',
                "latitude" => 18,
                "longitude" => -65
            ],
            [
                "name" => "UNITED STATES VIRGIN ISLANDS",
                "iso2" => "VI",
                "iso3" => "VIR",
                "telephone_prefix" => '340',
                "latitude" => 18,
                "longitude" => -65
            ],
            [
                "name" => "ISRAEL",
                "iso2" => "IL",
                "iso3" => "ISR",
                "telephone_prefix" => '972',
                "latitude" => 31,
                "longitude" => 35
            ],
            [
                "name" => "ITALY",
                "iso2" => "IT",
                "iso3" => "ITA",
                "telephone_prefix" => '39',
                "latitude" => 42,
                "longitude" => 13
            ],
            [
                "name" => "JAMAICA",
                "iso2" => "JM",
                "iso3" => "JAM",
                "telephone_prefix" => '876',
                "latitude" => 18,
                "longitude" => -77
            ],
            [
                "name" => "JAPAN",
                "iso2" => "JP",
                "iso3" => "JPN",
                "telephone_prefix" => '81',
                "latitude" => 36,
                "longitude" => 138
            ],
            [
                "name" => "JERSEY",
                "iso2" => "JE",
                "iso3" => "JEY",
                "telephone_prefix" => '0',
                "latitude" => 49,
                "longitude" => -2
            ],
            [
                "name" => "JORDAN",
                "iso2" => "JO",
                "iso3" => "JOR",
                "telephone_prefix" => '962',
                "latitude" => 31,
                "longitude" => 36
            ],
            [
                "name" => "KAZAKHSTAN",
                "iso2" => "KZ",
                "iso3" => "KAZ",
                "telephone_prefix" => '7',
                "latitude" => 48,
                "longitude" => 67
            ],
            [
                "name" => "KENYA",
                "iso2" => "KE",
                "iso3" => "KEN",
                "telephone_prefix" => '254',
                "latitude" => 0,
                "longitude" => 38
            ],
            [
                "name" => "KYRGYZSTAN",
                "iso2" => "KG",
                "iso3" => "KGZ",
                "telephone_prefix" => '996',
                "latitude" => 41,
                "longitude" => 75
            ],
            [
                "name" => "KIRIBATI",
                "iso2" => "KI",
                "iso3" => "KIR",
                "telephone_prefix" => '686',
                "latitude" => -3,
                "longitude" => -169
            ],
            [
                "name" => "KUWAIT",
                "iso2" => "KW",
                "iso3" => "KWT",
                "telephone_prefix" => '965',
                "latitude" => 29,
                "longitude" => 47
            ],
            [
                "name" => "LEBANON",
                "iso2" => "LB",
                "iso3" => "LBN",
                "telephone_prefix" => '961',
                "latitude" => 34,
                "longitude" => 36
            ],
            [
                "name" => "LAOS",
                "iso2" => "LA",
                "iso3" => "LAO",
                "telephone_prefix" => '856',
                "latitude" => 20,
                "longitude" => 102
            ],
            [
                "name" => "LESOTHO",
                "iso2" => "LS",
                "iso3" => "LSO",
                "telephone_prefix" => '266',
                "latitude" => -30,
                "longitude" => 28
            ],
            [
                "name" => "LATVIA",
                "iso2" => "LV",
                "iso3" => "LVA",
                "telephone_prefix" => '371',
                "latitude" => 57,
                "longitude" => 25
            ],
            [
                "name" => "LIBERIA",
                "iso2" => "LR",
                "iso3" => "LBR",
                "telephone_prefix" => '231',
                "latitude" => 6,
                "longitude" => -9
            ],
            [
                "name" => "LIBYA",
                "iso2" => "LY",
                "iso3" => "LBY",
                "telephone_prefix" => '218',
                "latitude" => 26,
                "longitude" => 17
            ],
            [
                "name" => "LIECHTENSTEIN",
                "iso2" => "LI",
                "iso3" => "LIE",
                "telephone_prefix" => '423',
                "latitude" => 47,
                "longitude" => 10
            ],
            [
                "name" => "LITHUANIA",
                "iso2" => "LT",
                "iso3" => "LTU",
                "telephone_prefix" => '370',
                "latitude" => 55,
                "longitude" => 24
            ],
            [
                "name" => "LUXEMBOURG",
                "iso2" => "LU",
                "iso3" => "LUX",
                "telephone_prefix" => '352',
                "latitude" => 50,
                "longitude" => 6
            ],
            [
                "name" => "MEXICO",
                "iso2" => "MX",
                "iso3" => "MEX",
                "telephone_prefix" => '52',
                "latitude" => 24,
                "longitude" => -103
            ],
            [
                "name" => "MONACO",
                "iso2" => "MC",
                "iso3" => "MCO",
                "telephone_prefix" => '377',
                "latitude" => 44,
                "longitude" => 7
            ],
            [
                "name" => "MACAO",
                "iso2" => "MO",
                "iso3" => "MAC",
                "telephone_prefix" => '853',
                "latitude" => 22,
                "longitude" => 114
            ],
            [
                "name" => "MACEDONIA",
                "iso2" => "MK",
                "iso3" => "MKD",
                "telephone_prefix" => '389',
                "latitude" => 42,
                "longitude" => 22
            ],
            [
                "name" => "MADAGASCAR",
                "iso2" => "MG",
                "iso3" => "MDG",
                "telephone_prefix" => '261',
                "latitude" => -19,
                "longitude" => 47
            ],
            [
                "name" => "MALAYSIA",
                "iso2" => "MY",
                "iso3" => "MYS",
                "telephone_prefix" => '60',
                "latitude" => 4,
                "longitude" => 102
            ],
            [
                "name" => "MALAWI",
                "iso2" => "MW",
                "iso3" => "MWI",
                "telephone_prefix" => '265',
                "latitude" => -13,
                "longitude" => 34
            ],
            [
                "name" => "MALI",
                "iso2" => "ML",
                "iso3" => "MLI",
                "telephone_prefix" => '223',
                "latitude" => 18,
                "longitude" => -4
            ],
            [
                "name" => "MALTA",
                "iso2" => "MT",
                "iso3" => "MLT",
                "telephone_prefix" => '356',
                "latitude" => 36,
                "longitude" => 14
            ],
            [
                "name" => "MOROCCO",
                "iso2" => "MA",
                "iso3" => "MAR",
                "telephone_prefix" => '212',
                "latitude" => 32,
                "longitude" => -7
            ],
            [
                "name" => "MARTINIQUE",
                "iso2" => "MQ",
                "iso3" => "MTQ",
                "telephone_prefix" => '0',
                "latitude" => 15,
                "longitude" => -61
            ],
            [
                "name" => "MAURITIUS",
                "iso2" => "MU",
                "iso3" => "MUS",
                "telephone_prefix" => '230',
                "latitude" => -20,
                "longitude" => 58
            ],
            [
                "name" => "MAURITANIA",
                "iso2" => "MR",
                "iso3" => "MRT",
                "telephone_prefix" => '222',
                "latitude" => 21,
                "longitude" => -11
            ],
            [
                "name" => "MAYOTTE",
                "iso2" => "YT",
                "iso3" => "MYT",
                "telephone_prefix" => '262',
                "latitude" => -13,
                "longitude" => 45
            ],
            [
                "name" => "ESTADOS FEDERADOS DE MICRONESIA",
                "iso2" => "FM",
                "iso3" => "FSM",
                "telephone_prefix" => '691',
                "latitude" => 7,
                "longitude" => 151
            ],
            [
                "name" => "MOLDOVA",
                "iso2" => "MD",
                "iso3" => "MDA",
                "telephone_prefix" => '373',
                "latitude" => 47,
                "longitude" => 28
            ],
            [
                "name" => "MONGOLIA",
                "iso2" => "MN",
                "iso3" => "MNG",
                "telephone_prefix" => '976',
                "latitude" => 47,
                "longitude" => 104
            ],
            [
                "name" => "MONTENEGRO",
                "iso2" => "ME",
                "iso3" => "MNE",
                "telephone_prefix" => '382',
                "latitude" => 43,
                "longitude" => 19
            ],
            [
                "name" => "MONTSERRAT",
                "iso2" => "MS",
                "iso3" => "MSR",
                "telephone_prefix" => '664',
                "latitude" => 17,
                "longitude" => -62
            ],
            [
                "name" => "MOZAMBIQUE",
                "iso2" => "MZ",
                "iso3" => "MOZ",
                "telephone_prefix" => '258',
                "latitude" => -19,
                "longitude" => 36
            ],
            [
                "name" => "NAMIBIA",
                "iso2" => "NA",
                "iso3" => "NAM",
                "telephone_prefix" => '264',
                "latitude" => -23,
                "longitude" => 18
            ],
            [
                "name" => "NAURU",
                "iso2" => "NR",
                "iso3" => "NRU",
                "telephone_prefix" => '674',
                "latitude" => -1,
                "longitude" => 167
            ],
            [
                "name" => "NEPAL",
                "iso2" => "NP",
                "iso3" => "NPL",
                "telephone_prefix" => '977',
                "latitude" => 28,
                "longitude" => 84
            ],
            [
                "name" => "NICARAGUA",
                "iso2" => "NI",
                "iso3" => "NIC",
                "telephone_prefix" => '505',
                "latitude" => 13,
                "longitude" => -85
            ],
            [
                "name" => "NIGER",
                "iso2" => "NE",
                "iso3" => "NER",
                "telephone_prefix" => '227',
                "latitude" => 18,
                "longitude" => 8
            ],
            [
                "name" => "NIGERIA",
                "iso2" => "NG",
                "iso3" => "NGA",
                "telephone_prefix" => '234',
                "latitude" => 9,
                "longitude" => 9
            ],
            [
                "name" => "NIUE",
                "iso2" => "NU",
                "iso3" => "NIU",
                "telephone_prefix" => '683',
                "latitude" => -19,
                "longitude" => -170
            ],
            [
                "name" => "NORWAY",
                "iso2" => "NO",
                "iso3" => "NOR",
                "telephone_prefix" => '47',
                "latitude" => 60,
                "longitude" => 8
            ],
            [
                "name" => "NEW CALEDONIA",
                "iso2" => "NC",
                "iso3" => "NCL",
                "telephone_prefix" => '687',
                "latitude" => -21,
                "longitude" => 166
            ],
            [
                "name" => "NEW ZEALAND",
                "iso2" => "NZ",
                "iso3" => "NZL",
                "telephone_prefix" => '64',
                "latitude" => -41,
                "longitude" => 175
            ],
            [
                "name" => "OMAN",
                "iso2" => "OM",
                "iso3" => "OMN",
                "telephone_prefix" => '968',
                "latitude" => 22,
                "longitude" => 56
            ],
            [
                "name" => "NETHERLANDS",
                "iso2" => "NL",
                "iso3" => "NLD",
                "telephone_prefix" => '31',
                "latitude" => 52,
                "longitude" => 5
            ],
            [
                "name" => "PAKISTAN",
                "iso2" => "PK",
                "iso3" => "PAK",
                "telephone_prefix" => '92',
                "latitude" => 30,
                "longitude" => 69
            ],
            [
                "name" => "PALAU",
                "iso2" => "PW",
                "iso3" => "PLW",
                "telephone_prefix" => '680',
                "latitude" => 8,
                "longitude" => 135
            ],
            [
                "name" => "PALESTINE",
                "iso2" => "PS",
                "iso3" => "PSE",
                "telephone_prefix" => '0',
                "latitude" => 32,
                "longitude" => 35
            ],
            [
                "name" => "PANAMA",
                "iso2" => "PA",
                "iso3" => "PAN",
                "telephone_prefix" => '507',
                "latitude" => 9,
                "longitude" => -81
            ],
            [
                "name" => "PAPUA NEW GUINEA",
                "iso2" => "PG",
                "iso3" => "PNG",
                "telephone_prefix" => '675',
                "latitude" => -6,
                "longitude" => 144
            ],
            [
                "name" => "PARAGUAY",
                "iso2" => "PY",
                "iso3" => "PRY",
                "telephone_prefix" => '595',
                "latitude" => -23,
                "longitude" => -58
            ],
            [
                "name" => "PERU",
                "iso2" => "PE",
                "iso3" => "PER",
                "telephone_prefix" => '51',
                "latitude" => -9,
                "longitude" => -75
            ],
            [
                "name" => "FRENCH POLYNESIA",
                "iso2" => "PF",
                "iso3" => "PYF",
                "telephone_prefix" => '689',
                "latitude" => -18,
                "longitude" => -149
            ],
            [
                "name" => "POLAND",
                "iso2" => "PL",
                "iso3" => "POL",
                "telephone_prefix" => '48',
                "latitude" => 52,
                "longitude" => 19
            ],
            [
                "name" => "PORTUGAL",
                "iso2" => "PT",
                "iso3" => "PRT",
                "telephone_prefix" => '351',
                "latitude" => 39,
                "longitude" => -8
            ],
            [
                "name" => "PUERTO RICO",
                "iso2" => "PR",
                "iso3" => "PRI",
                "telephone_prefix" => '1',
                "latitude" => 18,
                "longitude" => -67
            ],
            [
                "name" => "QATAR",
                "iso2" => "QA",
                "iso3" => "QAT",
                "telephone_prefix" => '974',
                "latitude" => 25,
                "longitude" => 51
            ],
            [
                "name" => "UNITED KINGDOM",
                "iso2" => "GB",
                "iso3" => "GBR",
                "telephone_prefix" => '44',
                "latitude" => 55,
                "longitude" => -3
            ],
            [
                "name" => "CENTRAL AFRICAN REPUBLIC",
                "iso2" => "CF",
                "iso3" => "CAF",
                "telephone_prefix" => '236',
                "latitude" => 7,
                "longitude" => 21
            ],
            [
                "name" => "CZECH REPUBLIC",
                "iso2" => "CZ",
                "iso3" => "CZE",
                "telephone_prefix" => '420',
                "latitude" => 50,
                "longitude" => 15
            ],
            [
                "name" => "DOMINICAN REPUBLIC",
                "iso2" => "DO",
                "iso3" => "DOM",
                "telephone_prefix" => '809',
                "latitude" => 19,
                "longitude" => -70
            ],
            [
                "name" => "REUNION",
                "iso2" => "RE",
                "iso3" => "REU",
                "telephone_prefix" => '0',
                "latitude" => -21,
                "longitude" => 56
            ],
            [
                "name" => "RWANDA",
                "iso2" => "RW",
                "iso3" => "RWA",
                "telephone_prefix" => '250',
                "latitude" => -2,
                "longitude" => 30
            ],
            [
                "name" => "ROMANIA",
                "iso2" => "RO",
                "iso3" => "ROU",
                "telephone_prefix" => '40',
                "latitude" => 46,
                "longitude" => 25
            ],
            [
                "name" => "RUSSIA",
                "iso2" => "RU",
                "iso3" => "RUS",
                "telephone_prefix" => '7',
                "latitude" => 62,
                "longitude" => 105
            ],
            [
                "name" => "WESTERN SAHARA",
                "iso2" => "EH",
                "iso3" => "ESH",
                "telephone_prefix" => '0',
                "latitude" => 24,
                "longitude" => -13
            ],
            [
                "name" => "SAMOA",
                "iso2" => "WS",
                "iso3" => "WSM",
                "telephone_prefix" => '685',
                "latitude" => -14,
                "longitude" => -172
            ],
            [
                "name" => "AMERICAN SAMOA",
                "iso2" => "AS",
                "iso3" => "ASM",
                "telephone_prefix" => '684',
                "latitude" => -14,
                "longitude" => -170
            ],
            [
                "name" => "SAN BARTOLOME",
                "iso2" => "BL",
                "iso3" => "BLM",
                "telephone_prefix" => '590',
                "latitude" => 29,
                "longitude" => -14
            ],
            [
                "name" => "SAINT KITTS AND NEVIS",
                "iso2" => "KN",
                "iso3" => "KNA",
                "telephone_prefix" => '869',
                "latitude" => 17,
                "longitude" => -63
            ],
            [
                "name" => "SAN MARINO",
                "iso2" => "SM",
                "iso3" => "SMR",
                "telephone_prefix" => '378',
                "latitude" => 44,
                "longitude" => 12
            ],
            [
                "name" => "SAINT MARTIN (FRENCH PART)",
                "iso2" => "MF",
                "iso3" => "MAF",
                "telephone_prefix" => '599',
                "latitude" => 18,
                "longitude" => -63
            ],
            [
                "name" => "SAINT PIERRE AND MIQUELON",
                "iso2" => "PM",
                "iso3" => "SPM",
                "telephone_prefix" => '508',
                "latitude" => 47,
                "longitude" => -56
            ],
            [
                "name" => "SAINT VINCENT AND THE GRENADINES",
                "iso2" => "VC",
                "iso3" => "VCT",
                "telephone_prefix" => '784',
                "latitude" => 13,
                "longitude" => -61
            ],
            [
                "name" => "SANTA ELENA",
                "iso2" => "SH",
                "iso3" => "SHN",
                "telephone_prefix" => '290',
                "latitude" => -24,
                "longitude" => -10
            ],
            [
                "name" => "SAINT LUCIA",
                "iso2" => "LC",
                "iso3" => "LCA",
                "telephone_prefix" => '758',
                "latitude" => 14,
                "longitude" => -61
            ],
            [
                "name" => "SAO TOME AND PRINCIPE",
                "iso2" => "ST",
                "iso3" => "STP",
                "telephone_prefix" => '239',
                "latitude" => 0,
                "longitude" => 7
            ],
            [
                "name" => "SENEGAL",
                "iso2" => "SN",
                "iso3" => "SEN",
                "telephone_prefix" => '221',
                "latitude" => 14,
                "longitude" => -14
            ],
            [
                "name" => "SERBIA",
                "iso2" => "RS",
                "iso3" => "SRB",
                "telephone_prefix" => '381',
                "latitude" => 44,
                "longitude" => 21
            ],
            [
                "name" => "SEYCHELLES",
                "iso2" => "SC",
                "iso3" => "SYC",
                "telephone_prefix" => '248',
                "latitude" => -5,
                "longitude" => 55
            ],
            [
                "name" => "SIERRA LEONE",
                "iso2" => "SL",
                "iso3" => "SLE",
                "telephone_prefix" => '232',
                "latitude" => 8,
                "longitude" => -12
            ],
            [
                "name" => "SINGAPORE",
                "iso2" => "SG",
                "iso3" => "SGP",
                "telephone_prefix" => '65',
                "latitude" => 1,
                "longitude" => 104
            ],
            [
                "name" => "SYRIA",
                "iso2" => "SY",
                "iso3" => "SYR",
                "telephone_prefix" => '963',
                "latitude" => 35,
                "longitude" => 39
            ],
            [
                "name" => "SOMALIA",
                "iso2" => "SO",
                "iso3" => "SOM",
                "telephone_prefix" => '252',
                "latitude" => 5,
                "longitude" => 46
            ],
            [
                "name" => "SRI LANKA",
                "iso2" => "LK",
                "iso3" => "LKA",
                "telephone_prefix" => '94',
                "latitude" => 8,
                "longitude" => 81
            ],
            [
                "name" => "SOUTH AFRICA",
                "iso2" => "ZA",
                "iso3" => "ZAF",
                "telephone_prefix" => '27',
                "latitude" => -31,
                "longitude" => 23
            ],
            [
                "name" => "SUDAN",
                "iso2" => "SD",
                "iso3" => "SDN",
                "telephone_prefix" => '249',
                "latitude" => 13,
                "longitude" => 30
            ],
            [
                "name" => "SWEDEN",
                "iso2" => "SE",
                "iso3" => "SWE",
                "telephone_prefix" => '46',
                "latitude" => 60,
                "longitude" => 19
            ],
            [
                "name" => "SWITZERLAND",
                "iso2" => "CH",
                "iso3" => "CHE",
                "telephone_prefix" => '41',
                "latitude" => 47,
                "longitude" => 8
            ],
            [
                "name" => "SURINAME",
                "iso2" => "SR",
                "iso3" => "SUR",
                "telephone_prefix" => '597',
                "latitude" => 4,
                "longitude" => -56
            ],
            [
                "name" => "SVALBARD AND JAN MAYEN",
                "iso2" => "SJ",
                "iso3" => "SJM",
                "telephone_prefix" => '0',
                "latitude" => 78,
                "longitude" => 24
            ],
            [
                "name" => "SWAZILAND",
                "iso2" => "SZ",
                "iso3" => "SWZ",
                "telephone_prefix" => '268',
                "latitude" => -27,
                "longitude" => 31
            ],
            [
                "name" => "TAJIKISTAN",
                "iso2" => "TJ",
                "iso3" => "TJK",
                "telephone_prefix" => '992',
                "latitude" => 39,
                "longitude" => 71
            ],
            [
                "name" => "THAILAND",
                "iso2" => "TH",
                "iso3" => "THA",
                "telephone_prefix" => '66',
                "latitude" => 16,
                "longitude" => 101
            ],
            [
                "name" => "TAIWAN",
                "iso2" => "TW",
                "iso3" => "TWN",
                "telephone_prefix" => '886',
                "latitude" => 24,
                "longitude" => 121
            ],
            [
                "name" => "TANZANIA",
                "iso2" => "TZ",
                "iso3" => "TZA",
                "telephone_prefix" => '255',
                "latitude" => -6,
                "longitude" => 35
            ],
            [
                "name" => "BRITISH INDIAN OCEAN TERRITORY",
                "iso2" => "IO",
                "iso3" => "IOT",
                "telephone_prefix" => '0',
                "latitude" => -6,
                "longitude" => 72
            ],
            [
                "name" => "FRENCH SOUTHERN TERRITORIES",
                "iso2" => "TF",
                "iso3" => "ATF",
                "telephone_prefix" => '0',
                "latitude" => -49,
                "longitude" => 69
            ],
            [
                "name" => "EAST TIMOR",
                "iso2" => "TL",
                "iso3" => "TLS",
                "telephone_prefix" => '670',
                "latitude" => -9,
                "longitude" => 126
            ],
            [
                "name" => "TOGO",
                "iso2" => "TG",
                "iso3" => "TGO",
                "telephone_prefix" => '228',
                "latitude" => 9,
                "longitude" => 1
            ],
            [
                "name" => "TOKELAU",
                "iso2" => "TK",
                "iso3" => "TKL",
                "telephone_prefix" => '690',
                "latitude" => -9,
                "longitude" => -172
            ],
            [
                "name" => "TONGA",
                "iso2" => "TO",
                "iso3" => "TON",
                "telephone_prefix" => '676',
                "latitude" => -21,
                "longitude" => -175
            ],
            [
                "name" => "TRINIDAD AND TOBAGO",
                "iso2" => "TT",
                "iso3" => "TTO",
                "telephone_prefix" => '868',
                "latitude" => 11,
                "longitude" => -61
            ],
            [
                "name" => "TUNISIA",
                "iso2" => "TN",
                "iso3" => "TUN",
                "telephone_prefix" => '216',
                "latitude" => 34,
                "longitude" => 10
            ],
            [
                "name" => "TURKMENISTAN",
                "iso2" => "TM",
                "iso3" => "TKM",
                "telephone_prefix" => '993',
                "latitude" => 39,
                "longitude" => 60
            ],
            [
                "name" => "TURKEY",
                "iso2" => "TR",
                "iso3" => "TUR",
                "telephone_prefix" => '90',
                "latitude" => 39,
                "longitude" => 35
            ],
            [
                "name" => "TUVALU",
                "iso2" => "TV",
                "iso3" => "TUV",
                "telephone_prefix" => '688',
                "latitude" => -7,
                "longitude" => 178
            ],
            [
                "name" => "UKRAINE",
                "iso2" => "UA",
                "iso3" => "UKR",
                "telephone_prefix" => '380',
                "latitude" => 48,
                "longitude" => 31
            ],
            [
                "name" => "UGANDA",
                "iso2" => "UG",
                "iso3" => "UGA",
                "telephone_prefix" => '256',
                "latitude" => 1,
                "longitude" => 32
            ],
            [
                "name" => "URUGUAY",
                "iso2" => "UY",
                "iso3" => "URY",
                "telephone_prefix" => '598',
                "latitude" => -33,
                "longitude" => -56
            ],
            [
                "name" => "UZBEKISTAN",
                "iso2" => "UZ",
                "iso3" => "UZB",
                "telephone_prefix" => '998',
                "latitude" => 41,
                "longitude" => 65
            ],
            [
                "name" => "VANUATU",
                "iso2" => "VU",
                "iso3" => "VUT",
                "telephone_prefix" => '678',
                "latitude" => -15,
                "longitude" => 167
            ],
            [
                "name" => "VENEZUELA",
                "iso2" => "VE",
                "iso3" => "VEN",
                "telephone_prefix" => '58',
                "latitude" => 6,
                "longitude" => -67,
                "coint" => "Bolívar",
                "coint_value" =>'300000'
            ],
            [
                "name" => "VIETNAM",
                "iso2" => "VN",
                "iso3" => "VNM",
                "telephone_prefix" => '84',
                "latitude" => 14,
                "longitude" => 108
            ],
            [
                "name" => "WALLIS AND FUTUNA",
                "iso2" => "WF",
                "iso3" => "WLF",
                "telephone_prefix" => '681',
                "latitude" => -14,
                "longitude" => -177
            ],
            [
                "name" => "YEMEN",
                "iso2" => "YE",
                "iso3" => "YEM",
                "telephone_prefix" => '967',
                "latitude" => 16,
                "longitude" => 49
            ],
            [
                "name" => "DJIBOUTI",
                "iso2" => "DJ",
                "iso3" => "DJI",
                "telephone_prefix" => '253',
                "latitude" => 12,
                "longitude" => 43
            ],
            [
                "name" => "ZAMBIA",
                "iso2" => "ZM",
                "iso3" => "ZMB",
                "telephone_prefix" => '260',
                "latitude" => -13,
                "longitude" => 28
            ],
            [
                "name" => "ZIMBABWE",
                "iso2" => "ZW",
                "iso3" => "ZWE",
                "telephone_prefix" => '263',
                "latitude" => -19,
                "longitude" => 29
            ]
        ];
        foreach ($datas as $data) {
            Country::create($data);
        }
    }
}
