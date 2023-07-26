<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries=['Afghanistan',
        'Albania',
        'Algeria',
        'Andorra',
        'Angola',
       ' Antigua and Barbuda',
        'Argentina',
        'Armenia',
        'Australia',
        'Austria',
        'Azerbaijan',
        'Bahamas',
        'Bahrain',
        'Bangladesh',
        'Barbados',
        'Belarus',
        'Belgium',
        'Belize',
        'Benin',
        'Bhutan',
        'Bolivia',
        'Bosnia and Herzegovina',
        'Botswana',
        'Brazil',
        'Brunei',
        'Bulgaria',
        'Burkina Faso',
        'Burundi',
        'Cabo Verde',
        'Cambodia',
        'Cameroon',
        'Canada',
        'Central African Republic',
        'Chad',
        'Chile',
        'China',
        'Colombia',
        'Comoros',
        'Congo (Congo-Brazzaville)',
        'Costa Rica',
        "Côte d'Ivoire",
        'Croatia',
        'Cuba',
        'Cyprus',
        'Czechia (Czech Republic)',
       ' Democratic Republic of the Congo',
        'Denmark',
        'Djibouti',
        'Dominica',
       ' Dominican Republic',
        'Ecuador',
        'Egypt',
       ' El Salvador',
        'Equatorial Guinea',
        'Eritrea',
        'Estonia',
       ' Eswatini (fmr. "Swaziland")',
        'Ethiopiam',
        'Fiji',
        'Finland',
        'France',
        'Gabon',
        'Gambia',
        'Georgia',
        'Germany',
        'Ghana',
        'Greece',
        'Grenada',
        'Guatemala',
        'Guinea',
        'Guinea-Bissau',
        'Guyana',
        'Haiti',
        'Holy See',
        'Honduras',
        'Hungary',
        'Iceland',
        'India',
        'Indonesia',
        'Iran',
        'Iraq',
        'Ireland',
        'Israel',
        'Italy',
        'Jamaica',
        'Japan',
        'Jordan',
        'Kazakhstan',
        'Kenya',
        'Kiribati',
        'Kuwait',
        'Kyrgyzstan',
        'Laos',
        'Latvia',
        'Lebanon',
        'Lesotho',
        'Liberia',
        'Libya',
        'Liechtenstein',
        'Lithuania',
        'Luxembourg',
        'Madagascar',
        'Malawi',
        'Malaysia',
        'Maldives',
        'Mali',
        'Malta',
        'Marshall Islands',
        'Mauritania',
        'Mauritius',
        'Mexico',
        'Micronesia',
        'Moldova',
        'Monaco',
        'Mongolia',
        'Montenegro',
        'Morocco',
        'Mozambique',
        'Myanmar',
        'Namibia',
        'Nauru',
        'Nepal',
        'Netherlands',
        'New Zealand',
        'Nicaragua',
        'Niger',
        'Nigeria',
        'North Korea',
        'North Macedonia',
        'Norway',
        'Oman',
        'Pakistan',
        'Palau',
        'Palestine State',
        'Panama',
        'Papua New Guinea',
        'Paraguay',
        'Peru',
        'Philippines',
        'Poland',
        'Portugal',
        'Qatar',
        'Romania',
        'Russia',
        'Rwanda',
        'Saint Kitts and Nevis',
        'Saint Lucia',
        'Saint Vincent and the Grenadines',
        'Samoa',
        'San Marino',
        'Sao Tome and Principe',
        'Saudi Arabia',
        'Senegal',
        'Serbia',
        'Seychelles',
        'Sierra Leone',
        'Singapore',
        'Slovakia',
        'Slovenia',
        'Solomon Islands',
        'Somalia',
        'South Africa',
        'South Korea',
        'South Sudan',
        'Spain',
        'Sri Lanka',
        'Sudan',
        'Suriname',
        'Sweden',
        'Switzerland',
        'Syria',
        'Tajikistan',
        'Tanzania',
        'Thailand',
        'Timor-Leste',
        'Togo',
        'Tonga',
        'Trinidad and Tobago',
        'Tunisia',
        'Turkey',
        'Turkmenistan',
        'Tuvalu',
        'Uganda',
        'Ukraine',
        'United Arab Emirates',
        'United Kingdom',
        'United States of America',
        'Uruguay',
        'Uzbekistan',
        'Vanuatu',
        'Venezuela',
        'Vietnam',
        'Yemen',
        'Zambia',
        'Zimbabwe'];
        $languages=['en','mm'];
        foreach($countries as $c){
            $country=Country::create();
            if($country){
                foreach($languages as $l){
                    DB::table('name_translations')->insert([
                        'name'=>$l=='en' ? $c: $c,
                        'name_translationable_id'=>$country->id,
                        'name_translationable_type'=>'country',
                        'language_code'=>$l,
                    ]);
                }
            }
        }
        
        
        // DB::table('countries')->insert(['id'=>1]);
        // DB::table('name_translations')->insert(['name'=>'United States', 'name_translationable_id'=>1, 'name_translationable_type'=>'country', 'language_code'=>'en']);
        // DB::table('name_translations')->insert(['name'=>'အမေရိကန်', 'name_translationable_id'=>1, 'name_translationable_type'=>'country', 'language_code'=>'mm']);

        // DB::table('countries')->insert(['id'=>2]);
        // DB::table('name_translations')->insert(['name'=>'United Kingdom', 'name_translationable_id'=>2, 'name_translationable_type'=>'country', 'language_code'=>'en']);
        // DB::table('name_translations')->insert(['name'=>'ယူနိုက်တက်ကင်းဒမ်း', 'name_translationable_id'=>2, 'name_translationable_type'=>'country', 'language_code'=>'mm']);

        // DB::table('countries')->insert(['id'=>3]);
        // DB::table('name_translations')->insert(['name'=>'China', 'name_translationable_id'=>3, 'name_translationable_type'=>'country', 'language_code'=>'en']);
        // DB::table('name_translations')->insert(['name'=>'တရုတ်', 'name_translationable_id'=>3, 'name_translationable_type'=>'country', 'language_code'=>'mm']);

        // DB::table('countries')->insert(['id'=>4]);
        // DB::table('name_translations')->insert(['name'=>'Thailand', 'name_translationable_id'=>4, 'name_translationable_type'=>'country', 'language_code'=>'en']);
        // DB::table('name_translations')->insert(['name'=>'ထိုင်း', 'name_translationable_id'=>4, 'name_translationable_type'=>'country', 'language_code'=>'mm']);
    }
}