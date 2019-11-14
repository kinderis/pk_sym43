<?php

namespace App\EventSubscriber;

use App\Exception\JWTAuthException;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTAuthenticatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTInvalidEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTExpiredEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Events;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class LexikJWTSubscriber implements EventSubscriberInterface
{

    /**
     * @var ParameterBagInterface
     */
    private $params;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(ParameterBagInterface $params, EntityManagerInterface $em)
    {
        $this->params = $params;
        $this->em = $em;
    }

    public function onJWTInvalid(JWTInvalidEvent $event)
    {

        throw new JWTAuthException("JWT Token is invalid.");
    }

    public function onJWTNotFound(JWTNotFoundEvent $event)
    {
        throw new JWTAuthException("JWT Token is not found.");
    }

    public function onJWTExpired(JWTExpiredEvent $event)
    {

        throw new JWTAuthException("JWT Token is expired.");
    }

    public function onJWTAuthenticated(JWTAuthenticatedEvent $event)
    {
        if(!$event->getToken()->getUser()->getIsActive()) {
            throw new JWTAuthException("User blocked.");
        }
    }

    public function onAuthenticationSuccess(AuthenticationSuccessEvent $event)
    {
        # Reformat payload to OAuth2 spec.

        # $data contains key `token`.
        $data = $event->getData();
        $token = $data["token"];

        $event->setData([
            "access_token" => $token,
            "token_type" => "Bearer",
            "expires_in" => $this->params->get("lexik_jwt_authentication.token_ttl"),
        ]);
    }

    public function onJWTCreated(JWTCreatedEvent $event)
    {
        # Remove roles from JWT payload.

        $data = $event->getData();

        if (\array_key_exists("roles", $data)) {
            unset($data["roles"]);
        }
        return $event->setData($data);
    }

    public static function getSubscribedEvents()
    {
        return [
            Events::AUTHENTICATION_SUCCESS => 'onAuthenticationSuccess',
            Events::JWT_EXPIRED => 'onJWTExpired',
            Events::JWT_NOT_FOUND => 'onJWTNotFound',
            Events::JWT_INVALID => 'onJWTInvalid',
            Events::JWT_CREATED => 'onJWTCreated',
            Events::JWT_AUTHENTICATED => 'onJWTAuthenticated',
        ];
    }
}
