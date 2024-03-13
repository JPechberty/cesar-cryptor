<?php

namespace Controller;

use Studoo\EduFramework\Core\Controller\ControllerInterface;
use Studoo\EduFramework\Core\Controller\Request;
use Studoo\EduFramework\Core\View\TwigCore;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class DecryptController implements ControllerInterface
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

            $decrypted = $this->decrypt($message, $offset);

            var_dump([
                "offset" => $offset,
                "message" => $message,
                "decrypted" => $decrypted
            ]);
        }

        return TwigCore::getEnvironment()->render('decrypt/home.html.twig',
            [
                'titre' => 'Decrypt',
                'requete' => $request
            ]
        );
    }

    private function decrypt($encryptedMessage, $offset): string
    {
        $raw = array_map(function ($seq) use ($offset) {
            if ($seq === " ") {
                return " ";
            } else {
                return chr(intval($seq) - $offset);
            }
        }, explode(".",$encryptedMessage));

        return join("",$raw);
    }

}

