<?php

use Illuminate\Database\Seeder;

class DictionarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('pgsql')->table('dictionaries')->insert([
            ['abbreviation' => 'aym', 'word' => 'ayam'],
            ['abbreviation' => 'baym', 'word' => 'bayam'],
            ['abbreviation' => 'byam', 'word' => 'bayam'],
            ['abbreviation' => 'bym', 'word' => 'bayam'],
            ['abbreviation' => 'bawng', 'word' => 'bawang'],
            ['abbreviation' => 'bwang', 'word' => 'bawang'],
            ['abbreviation' => 'mrah', 'word' => 'merah'],
            ['abbreviation' => 'merh', 'word' => 'merah'],
            ['abbreviation' => 'mrh', 'word' => 'merah'],
            ['abbreviation' => 'pth', 'word' => 'putih'],
            ['abbreviation' => 'puth', 'word' => 'merah'],
            ['abbreviation' => 'ptih', 'word' => 'merah'],
            ['abbreviation' => 'bwng', 'word' => 'bawang'],
            ['abbreviation' => 'bncis', 'word' => 'buncis'],
            ['abbreviation' => 'buncs', 'word' => 'buncis'],
            ['abbreviation' => 'dging', 'word' => 'daging'],
            ['abbreviation' => 'dagng', 'word' => 'daging'],
            ['abbreviation' => 'dgng', 'word' => 'daging'],
            ['abbreviation' => 'kangkng', 'word' => 'kangkung'],
            ['abbreviation' => 'kngkung', 'word' => 'kangkung'],
            ['abbreviation' => 'katk', 'word' => 'katuk'],
            ['abbreviation' => 'ktuk', 'word' => 'katuk'],
            ['abbreviation' => 'ktk', 'word' => 'katuk'],
            ['abbreviation' => 'kntang', 'word' => 'kentang'],
            ['abbreviation' => 'kentng', 'word' => 'kentang'],
            ['abbreviation' => 'kntng', 'word' => 'kentang'],
            ['abbreviation' => 'lobk', 'word' => 'lobak'],
            ['abbreviation' => 'lbak', 'word' => 'lobak'],
            ['abbreviation' => 'lbk', 'word' => 'lobak'],
            ['abbreviation' => 'tmt', 'word' => 'tomat'],
            ['abbreviation' => 'tomt', 'word' => 'tomat'],
            ['abbreviation' => 'tmat', 'word' => 'tomat'],
            ['abbreviation' => 'kcng', 'word' => 'kacang'],
            ['abbreviation' => 'kacng', 'word' => 'kacang'],
            ['abbreviation' => 'kcang', 'word' => 'kacang'],
            ['abbreviation' => 'pjg', 'word' => 'panjang'],
            ['abbreviation' => 'panjng', 'word' => 'panjang'],
            ['abbreviation' => 'pnjng', 'word' => 'panjang'],
            ['abbreviation' => 'pnjang', 'word' => 'panjang'],
            ['abbreviation' => 'kcngpjg', 'word' => 'kacang panjang'],
            ['abbreviation' => 'wrtl', 'word' => 'wortel'],
            ['abbreviation' => 'wortl','word' => 'wortel'],
            ['abbreviation' => 'kg', 'word' => 'kilogram'],
            ['abbreviation' => 'gr', 'word' => 'gram'],
            ['abbreviation' => 'ikt', 'word' => 'ikat'],
        ]);

    }
}
