<?php


namespace App\Security;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    public function handle(Request $request, AccessDeniedException $accessDeniedException)
    {
        $content = '<html><head><title>Access Denied</title></head><body>
        <h1>403 ACCESS DENIED</h1>
        <h1>You are not authorized to access this resource</h1>
        </body></html>';
        return new Response($content, 403); // send html response
    }
}