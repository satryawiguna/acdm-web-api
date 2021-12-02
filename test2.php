<?php

class MyClassTwo
{
    public array $_arrNumber;
    public string $_type;

    public function __construct(array $arrNumber, string $type = 'largest')
    {
        $this->_arrNumber = $arrNumber;
        $this->_type = $type;

        if ($type == 'largest') {
            $this->printLargest($this->_arrNumber);
        } else {
            $this->printSmallest($this->_arrNumber);
        }
    }

    public function compareNumber($a, $b)
    {
        // first append b & a
        $ab = $b.$a;

        // then append a & b
        $ba = $a.$b;

        // Now see which of the two formed
        // numbers is greater
        return strcmp($ab, $ba) > 0 ? 1: 0;
    }

    // The main function that prints the
    // arrangement with the largest value.
    // The function accepts a vector of strings
    public function printLargest($arrNumber)
    {
        // Sort the numbers using library sort
        // function. The function uses our
        // comparison function compareNumber() to
        // compare two strings.
        usort($arrNumber, [$this, "compareNumber"]);

        for ($i = 0; $i < count($arrNumber); $i++)
            echo $arrNumber[$i];
    }

    public function printSmallest($arrNumber) {
        // Sort the numbers using library sort
        // function. The function uses our
        // comparison function compareNumber() to
        // compare two strings.
        uasort($arrNumber, [$this, "compareNumber"]);

        for ($i = 0; $i < count($arrNumber); $i++)
            echo $arrNumber[$i];
    }
}


$myNumber = [2, 20, 24, 6, 8];
$myClassTwo = new MyClassTwo($myNumber);
