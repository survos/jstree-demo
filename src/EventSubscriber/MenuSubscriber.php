<?php

namespace App\EventSubscriber;

use Survos\BaseBundle\Menu\BaseMenuSubscriber;
use Survos\BaseBundle\Menu\MenuBuilder;
use Survos\BaseBundle\Traits\KnpMenuHelperTrait;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use KevinPapst\AdminLTEBundle\Event\KnpMenuEvent;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Security;

class MenuSubscriber extends BaseMenuSubscriber implements EventSubscriberInterface
{
    // use KnpMenuHelperTrait; // for auth menu

    private $requestStack;
    private $authorizationChecker;
    private $security;

    /**
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct(AuthorizationCheckerInterface $authorizationChecker, Security $security, RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        $this->authorizationChecker = $authorizationChecker;
        $this->security = $security;
    }

   // use KnpMenuHelperTrait;

    public function onKnpMenuEvent(KnpMenuEvent $event)
    {

        $menu = $event->getMenu();

        $buildingMenu = $this->addMenuItem($menu, ['menu_code' => 'building_dropdown', 'label' => 'Buildings']);
        foreach (['index', 'new'] as $routeSuffix) {
            $this->addMenuItem($buildingMenu, ['route' => 'building_' . $routeSuffix]);
        }

        $this->addMenuItem($menu, ['route' => 'app_homepage', 'icon' => 'fas fa-home']);

        $menu->addChild('app_basic_ajax', ['route' => 'app_basic_ajax']);
        $menu->addChild('app_basic_html', ['route' => 'app_basic_html']);

        $adminMenu = $this->addMenuItem($menu, ['menu_code' => 'admin_dropdown']);
        $this->addMenuItem($adminMenu, ['route' => 'easyadmin']);
        $this->addMenuItem($adminMenu, ['route' => 'api_entrypoint']);
        $this->addMenuItem($adminMenu, ['route' => 'api_doc']);

        // ...
    }

    public static function getSubscribedEvents()
    {
        return [
            MenuBuilder::SIDEBAR_MENU_EVENT => 'onKnpMenuEvent',
        ];
    }
}
