<?php

namespace App\Controller\Pages;

use App\Model\Entity\Organization;
use App\Utils\View;

class AboutController extends PageController
{
    public static function getAbout()
    {
        $obOrganization = new Organization;
        $content = View::render('pages/about', [
            'name' => $obOrganization->name,
            'description' => $obOrganization->description
        ]);

        return parent::getPage('SOBRE', $content);
    }
}
