<?php

namespace App\Controller;

use App\Util\Validate;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * Form validation
     *
     * @Route("/registry",  methods="POST", name="registry")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function registry(Request $request, LoggerInterface $logger): JsonResponse
    {
        if (!$this->isCsrfTokenValid('registry', $request->request->get('_token'))) {
            die;
        }

        $formData = json_decode($request->request->get('formData'), false);

        $validator = new Validate([
            'email' => $formData->email,
            'password' => $formData->password,
            'password_confirm' => $formData->password_confirm,
            'description' => $formData->description,
            'age' => $formData->age,
            'city' => $formData->city
        ]);

        $validator->expect("email", "required|email");
        $validator->expect("password", "required|confirm=password_confirm|min_length=5");
        $validator->expect("age", "required|min_val=18");
        $validator->expect("description", "max_length=25");
        $validator->expect("city", "required");
        $validate = $validator->validate();

        return new JsonResponse([
            'validate' => $validate,
            'validate_errors' => $validator->getErrors()
        ]);
    }
}
