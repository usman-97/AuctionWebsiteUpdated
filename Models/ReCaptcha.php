<?php
class ReCaptcha {

    private $uppercaseLetters, $lowercaseLetters, $numbers, $reCaptcha;

    /*
     * ReCaptcha constructor which generates array of
     * characters for reCaptcha
     */
    public function __construct()
    {

        // Array which stores uppercase alphabets A to Z
        $this->uppercaseLetters1 = range(chr(65), chr(72));
        $this->uppercaseLetters2 = range(chr(74), chr(72));
        $this->uppercaseLetters = array_merge($this->uppercaseLetters1, $this->uppercaseLetters2);
        // Array which stores lowercase alphabets a to z
        $this->lowercaseLetters1 = range(chr(97), chr(107));
        $this->lowercaseLetters2 = range(chr(109), chr(122));
        $this->lowercaseLetters = array_merge($this->lowercaseLetters1, $this->lowercaseLetters2 );
        // Array Which stores numbers 0 to 9
        $this->numbers = range(chr(48), chr(57));
        // All three above array use chr function to get specific character
        // then range function is used to set a range to get specific characters

        // All three above arrays are merged together into one array
        $this->reCaptcha = array_merge($this->uppercaseLetters, $this->lowercaseLetters, $this->numbers);
        $this->reCaptcha[count($this->reCaptcha)] = " ";
    }

    /*
     *
     */
    public function generateReCaptcha()
    {
        // Length of reCaptcha
        $length = rand(5, 8);

        // Stores final reCaptcha which will be used for anti spamming
        $finalReCaptcha = '';
        for ($i = 0; $i < $length; $i++)
        {
            $finalReCaptcha .= $this->reCaptcha[array_rand($this->reCaptcha)];
        }
        return  $finalReCaptcha;

    }
}
