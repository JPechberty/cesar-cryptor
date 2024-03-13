<?php

namespace Controller;

use Studoo\EduFramework\Core\Controller\ControllerInterface;
use Studoo\EduFramework\Core\Controller\Request;
use Studoo\EduFramework\Core\View\TwigCore;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class DecodeController implements ControllerInterface
{
    /**
     * @param Request $request Requête HTTP
     * @return string|null
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function execute(Request $request): string|null
    {
        if ($request->getHttpMethod() === "POST" && $request->getVars() !== []) {
            $inputs = $request->getVars();
            $message = $inputs["message"];

            $decoded = base64_decode($message);

        }

        return TwigCore::getEnvironment()->render('decode/home.html.twig',
            [
                'titre' => 'Decrypt',
                'requete' => $request,
                'message' => $message ?? "",
                'decoded' => $decoded ?? "",
            ]
        );
    }

}

