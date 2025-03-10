<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use DateTime;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID')->hideOnForm(),
            TextField::new('title', 'Titre'),
            TextField::new('content', 'Description'),
            DateTimeField::new('createAt', 'Date de création'),
            TextField::new('author', 'Auteur')->hideOnIndex(),
            TextField::new('categories', 'Categories')->hideOnIndex(),
        ];
    }
    
}
