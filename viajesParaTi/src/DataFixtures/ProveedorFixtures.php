<?php

// src/DataFixtures/ProveedorFixtures.php

namespace App\DataFixtures;

use App\Entity\Proveedor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProveedorFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Crear proveedores de ejemplo
        $proveedor1 = new Proveedor();
        $proveedor1->setName('Proveedor 1');
        $proveedor1->setEmail('proveedor1@example.com');
        $proveedor1->setPhone('123456789');
        $proveedor1->setType('hotel');
        $proveedor1->setActive(true);
        $proveedor1->setCreatedAt(new \DateTime()); 
        $proveedor1->setUpdatedAt(new \DateTime()); 

        $proveedor2 = new Proveedor();
        $proveedor2->setName('Proveedor 2');
        $proveedor2->setEmail('proveedor2@example.com');
        $proveedor2->setPhone('987654321');
        $proveedor2->setType('pista');
        $proveedor2->setActive(true);
        $proveedor2->setCreatedAt(new \DateTime()); 
        $proveedor2->setUpdatedAt(new \DateTime()); 

        $proveedor3 = new Proveedor();
        $proveedor3->setName('Proveedor 3');
        $proveedor3->setEmail('proveedor3@example.com');
        $proveedor3->setPhone('967654321');
        $proveedor3->setType('complemento');
        $proveedor3->setActive(false);
        $proveedor3->setCreatedAt(new \DateTime()); 
        $proveedor3->setUpdatedAt(new \DateTime()); 

        // Persistir los objetos Proveedor
        $manager->persist($proveedor1);
        $manager->persist($proveedor2);
        $manager->persist($proveedor3);

        // Ejecutar cambios en la base de datos
        $manager->flush();
    }
}
