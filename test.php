<?php

class MyClassOne {

    public array $_number;
    public int $_index;
    public string $_from;

    public function __construct(array $number, int $index, string $from = 'end') {
        $this->_number = $number;

        if ($index > count($this->_number) ||
            $index < 0) {
            exit('Number is out of the range');
        }

        $this->_index = $index;
        $this->_from = $from;
    }

    public function getNth(): int {
        sort($this->_number);

        if ($this->_from == 'start') {
            $n = array_slice($this->_number, $this->_index, 1);
        } else {
            $n = array_slice($this->_number, ($this->_index * -1), 1);
        }

        $n = array_values($n);

        return $n[0];
    }
}

$myNumber = [3,2,1,5,6,4];
$myClassOne = new MyClassOne($myNumber, -1);

echo $myClassOne->getNth();
