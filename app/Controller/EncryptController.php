<?php

namespace Controller;

use Studoo\EduFramework\Core\Controller\ControllerInterface;
use Studoo\EduFramework\Core\Controller\Request;
use Studoo\EduFramework\Core\View\TwigCore;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class EncryptController implements ControllerInterface
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
            $offset = $inputs["offset"];
            $message = $inputs["message"];

            $encrypted = $this->encrypt($message, $offset);



            var_dump([
                "offset" => $offset,
                "message" => $message,
                "encrypted" => $encrypted
            ]);
        }

        return TwigCore::getEnvironment()->render('encrypt/home.html.twig',
            [
                'titre' => 'Encrypt',
                'requete' => $request
            ]
        );
    }


    private function encrypt($message, $offset): string
    {
        $raw = array_map(function ($char) use ($offset) {
            if ($char === " ") {
                return " ";
            } else {
                return ord($char) + $offset;
            }
        }, str_split($message));

        return join(".",$raw);
    }
}

