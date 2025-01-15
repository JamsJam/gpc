<?php

namespace App\Trait;

use Symfony\Component\HttpFoundation\Request;

trait LocaleTrait{
    public function handleLocale(Request $request){
        
        $request->getSession()->set('_locale', $request->getLocale());
        if($request->query->get('_locale')){
            $request->getSession()->set('_locale',$request->query->get('_locale'));
            $routeName = $request->attributes->get('_route');
            $routeParameters = $request->attributes->get('_route_params');
            return $redirect =  $this->redirectToRoute($routeName, $routeParameters);
        }
    }
}