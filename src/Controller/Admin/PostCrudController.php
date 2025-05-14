<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\Security\Core\Security;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;

class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    public function __construct(private Security $security, private EntityManagerInterface $entityManager) {}

    public function persistEntity(EntityManagerInterface $entityManager, $entity): void
    {
        if ($entity instanceof Post) {
            $entity->setUser($this->security->getUser());
        }

        parent::persistEntity($entityManager, $entity);

    }

    public function createEntity(string $entityFqcn)
    {
        $post = new Post();

        $defaultCategory = $this->entityManager
            ->getRepository(Category::class)
            ->findOneBy([], ['id' => 'ASC']);

        if (!$defaultCategory) {
            throw new \RuntimeException('There is no available category, you should create at least 1 to create a post.');
        }

        $post->setCategory($defaultCategory);

        $post->setUser($this->security->getUser());

        return $post;
    }


    
    public function configureFields(string $pageName): iterable
    {
          return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            TextField::new('description'),
            TextField::new('content'),
            AssociationField::new('category')
                ->setFormTypeOption('choice_label', 'name'),
        ];
    }
    
    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('title')
            ->add('description')
            ->add('category')
        ;
    }
}
