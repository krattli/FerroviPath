<?php
namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{

    public function __construct(private UrlGeneratorInterface $urlGeneratorInterface)
    {
        
    }
    public function handle(Request $request, AccessDeniedException $accessDeniedException): ?Response
    {
        $request->getSession()->set('errorAccess', 'Accès refusé : vous n\'avez pas les permissions nécessaires.');
        return new RedirectResponse($this->urlGeneratorInterface->generate('ferrovipath_homepage'));
    }
}
?>