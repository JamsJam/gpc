<?php

namespace App\Twig\Components;



use DateTimeZone;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent]
final class Horaires
{
    use DefaultActionTrait;


    public ?string $status = null;
    public array $open_hour = [
        "hours"=> 9,
        "minutes"=> 0
    ];
    public array $close_hour =  [
        "hours"=> 17,
        "minutes"=> 0
    ];
    public array $open_days = [
        "Monday",
        "Friday",
        "Saterday",
        "Monday", 
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Friday",
        "Saturday"
    ];
    public array $close_days = [
        "Sunday"
    ];
    public \DateTimeImmutable $today;

    public function mount(){
        $this->updateStatus();
        // dd('hello');
    }

    #[LiveAction()]
    public function updateDate(){
        $this->today = new \DateTimeImmutable('now',new DateTimeZone('America/Guadeloupe')); //? add timezone -4,5 caracasse
    }

    #[LiveAction()]
    public function setStatus(string $status){
        $this->status = $status;

    }

    #[LiveAction()]
    public function isNewStatus(string $status){
        return $status === $this->status;
    }

    #[LiveAction()]
    public function isOpenDay(){
        $day = $this->today->format('l');
        // dd($day);
        return in_array($day , $this->open_days);
    }

    #[LiveAction()]
    public function isCloseDay(){
        $day = $this->today->format('l');
        
        return in_array($day , $this->close_days);
    }

    #[LiveAction()]
    public function isOpenHour(){
        $date = $this->today;
        $openHour = $this->today->setTime($this->open_hour["hours"], $this->open_hour["minutes"]);
        $closeHour = $this->today->setTime($this->close_hour["hours"], $this->close_hour["minutes"]);
        

        return ($date > $openHour && $date < $closeHour);
    }

    #[LiveAction()]
    public function isCloseHour(){
        $date = $this->today;
        $closeHour = $this->today->setTime($this->close_hour["hours"], $this->close_hour["minutes"]);
        $closeHour = $this->today->setTime($this->close_hour["hours"], $this->close_hour["minutes"]);
        

        return ($date > $closeHour && $date < $closeHour);
    }

    #[LiveAction()]
    public function updateStatus(){
        $this->updateDate();
        // dd("hello");
        $status = null;
        if ($this->isOpenDay() && $this->isOpenHour()) {
            $status = "open";
        } else if(!$this->isOpenDay() || !$this->isOpenHour()){
            $status = "close";
        }else{
            $status = "";
        }

            $this->setStatus($status);
    }


}
