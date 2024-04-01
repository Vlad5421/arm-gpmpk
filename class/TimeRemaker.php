<?php

class TimeRemaker
{
    private $bz;
    private $makingTimeId;
    private $times;

    public function __construct($bz)
    {
        $this->bz = $bz;
        $this->times = $this->makeTimeList();
    }
    function makeTimeList(): array
    {
        $times = $this->bz->query("SELECT * FROM pmpk_time");
        $times->execute();
        return $times->fetchAll();
    }
    function get_times()
    {
        return $this->times;
    }
    function getMakingTime():array
    {
        $stmt = $this->bz->prepare("SELECT * FROM pmpk_time WHERE id=?");
        $stmt->execute([$this->makingTimeId]);
        return $stmt->fetch();
    }
    function setMakingTime(string $id)
    {
        $this->makingTimeId = (int)$id;
        return $this;
    }
    function remakeTime($time1, $time2)
    {
        $stmt = $this->bz->prepare("UPDATE pmpk_time SET time_start = :time1, time_end = :time2 WHERE id = :id");
        $stmt->execute(['time1' => $time1, 'time2' => $time2, 'id' => $this->makingTimeId]);
        return $stmt;
    }
    function makeNewTime($time1, $time2)
    {
        $stmt = $this->bz->prepare("INSERT INTO pmpk_time (time_start, time_end) VALUES (:time1, :time2)");
        $stmt->execute(["time1"=>$time1, "time2"=>$time2]);
    }

}