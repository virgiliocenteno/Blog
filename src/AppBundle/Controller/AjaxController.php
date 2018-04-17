<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Ajax controller.
 *
 * @Route("ajax")
 */
class AjaxController extends Controller
{
    /**
     * 
     *
     * @Route("/municipality", name="ajax_municipality")
     * @Method({"POST"})
     */
    public function municipalityAction(Request $request) {
        $id = $request->request->get('id');
        $em = $this->getDoctrine()->getManager();
        $municipality = $em->getRepository('AppBundle:Municipality')->findByState($id);
        $valores = '<option value="" selected="selected">Seleccione</option> ';
        foreach ($municipality as $valor) {
            $valores = $valores . ' <option value=' . $valor->getId() . '>' . $valor->getName() . '</option> ';
        }
        return $this->render('ajax/municipality.html.twig', array(
                    'municipality' => $valores,
        ));
    }
}
