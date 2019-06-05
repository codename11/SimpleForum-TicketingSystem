<?php

namespace App\Http\Controllers;
use App\User;
use App\Roles;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index(){
        $title="Welcome to Laravel!";
        //return view("pages.index", compact("title"));
        /*Ovde se navodi kome vjuu se salje promenljiva, 
        kako ce se zvati u tom vjuu kad bude poslana 
        i sama promenljiva koja sadrzi neku vrednost.*/
        return view("pages.index")->with("title", $title);
    }

    public function about(){
        $title="About Us";
        return view("pages.about")->with("title", $title);
    }

    public function services(){
        $title="Services";

        $data = array(
            "title" => "Services",
            "services" => ["Web Design", "Programming", "SEO"]
        );

        return view("pages.services")->with($data);
    }

}
