<?php

namespace Jikan\Model\Common;


class DateProp
{

    private $day;
    private $month;
    private $year;

    public function __construct(string $date)
    {
        $this->parse($date);
    }

    public function parse(string $date) : void
    {
        if (preg_match('/^\d{4}$/', $date)) {
            $this->set(null, null, (int) $date);
            return;
        }

        if (preg_match('~([a-zA-Z]{3})(?=(?:\s(\d{1,2}).\s(\d{4})|.\s(\d{4})))~', $date, $match)) {
            switch (count($match)) {
                case 4:
                    $this->set(
                        (int) $match[2],
                        (int) \DateTimeImmutable::createFromFormat('!M', $match[1])->format('m'),
                        (int) $match[3]
                    );
                    break;
                case 5:
                    $this->set(
                        null,
                        (int) \DateTimeImmutable::createFromFormat('!M', $match[1])->format('m'),
                        (int) $match[4]
                    );
                    break;
            }

            return;
        }

        $this->set(null, null, null);
    }

    /**
     * @param int|null $day
     * @param int|null $month
     * @param int|null $year
     */
    private function set(?int $day, ?int $month, ?int $year) : void
    {
        $this->day = $day;
        $this->month = $month;
        $this->year = $year;
    }

    /**
     * @return int|null
     */
    public function getDay() : ?int
    {
        return $this->day;
    }

    /**
     * @return int|null
     */
    public function getMonth() : ?int
    {
        return $this->month;
    }

    /**
     * @return int|null
     */
    public function getYear() : ?int
    {
        return $this->year;
    }

}