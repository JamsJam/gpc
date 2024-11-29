<?php

namespace App\Twig\Components;

use App\Entity\Activites;
use App\Entity\Excursions;
use App\Repository\ActivitesRepository;
use App\Repository\ExcursionsRepository;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent]
final class ModalContainer
{

    public function __construct(
        public ActivitesRepository $ar,
        public ExcursionsRepository $er
    ){}

    use DefaultActionTrait;

    #[LiveProp(writable:true)]
    public ?bool $modal_isOpen = false;
    
    #[LiveProp(writable:true)]
    public ?string $modal = null;
    
    #[LiveProp(writable:true)]
    public ?array $data = null;
    
    // public function mount(){
    //     $this->modal_isOpen = false;
    // }

    #[LiveAction]
    public function openModal(
        #[LiveArg()] string $modalType,
        #[LiveArg()] ?string $data
    ){
        $this->modal_isOpen = true;

        switch ($modalType) {
            case 'product_modal':
                $this->openProductMobal($data);
                $this->modal = $modalType;
                break;
            
            default:
                # code...
                break;
        }
    }
    
    private function openProductMobal(string $productData){
        
        $decodedData = json_decode($productData);

        $repo = match ($decodedData[0]) {
            'activites' => $this->ar,
            'excursions' => $this->er,
            default => 'undefined'
        };

        $dataProduct = $repo->findOneBy(['id' => $decodedData[1]]);

        $this->data = [
            "id"=>$dataProduct->getId(),
            "image"=>$dataProduct->getImage(),
            "description"=>$dataProduct->getDescription(),
            "titre"=>$dataProduct->getTitre(),
            "mode"=>$decodedData[0],
        ];

    }




    
    #[LiveAction]
    public function closeModal(){

        $this->modal_isOpen = false;
        $this->modal = null;
        $this->data = null;
    }







}
