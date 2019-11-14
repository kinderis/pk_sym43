<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Entity\WebUser;
use App\Repository\RoleRepository;

class CreateSuperUserCommand extends Command
{
    protected static $defaultName = 'app:create-super-user';

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var RoleRepository
     */
    private $roleRepo;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(
        EntityManagerInterface $entityManager,
        RoleRepository $roleRepo,
        UserPasswordEncoderInterface $encoder
    ) {
        $this->entityManager = $entityManager;
        $this->roleRepo = $roleRepo;
        $this->encoder = $encoder;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Create super user and assign all the roles to her.')
            ->addArgument('email', InputArgument::REQUIRED, 'Email to login with.')
            ->addArgument('password', InputArgument::REQUIRED, 'Password to login with.')
            ->addArgument('receiverAccount', InputArgument::REQUIRED, 'Password to login with.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');
        $receiverAccount = $input->getArgument('receiverAccount');

        $user = new WebUser();
        $encodedPassword = $this->encoder->encodePassword($user, $password);
        $user->setPassword($encodedPassword);
        $user->setEmail($email);
        $user->setReceiverAccount($receiverAccount);

        $this->entityManager->persist($user);
        $this->entityManager->flush($user);

        $allRoles = $this->roleRepo->findAll();
        foreach ($allRoles as $role) {
            $user->addRole($role);
        }

        $this->entityManager->flush($user);

        $roleCount = count($user->getRoles());

        $io->success('Super user "'.$email.'" was created with total of '.$roleCount.' roles.');
    }
}
