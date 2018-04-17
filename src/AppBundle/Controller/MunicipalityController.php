<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Municipality;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Municipality controller.
 *
 * @Route("municipality")
 */
class MunicipalityController extends Controller
{
    /**
     * Lists all municipality entities.
     *
     * @Route("/", name="municipality_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $municipalities = $em->getRepository('AppBundle:Municipality')->findAll();

        return $this->render('municipality/index.html.twig', array(
            'municipalities' => $municipalities,
        ));
    }

    /**
     * Creates a new municipality entity.
     *
     * @Route("/new", name="municipality_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $municipality = new Municipality();
        $form = $this->createForm('AppBundle\Form\MunicipalityType', $municipality);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($municipality);
            $em->flush();

            return $this->redirectToRoute('municipality_show', array('id' => $municipality->getId()));
        }

        return $this->render('municipality/new.html.twig', array(
            'municipality' => $municipality,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a municipality entity.
     *
     * @Route("/{id}", name="municipality_show")
     * @Method("GET")
     */
    public function showAction(Municipality $municipality)
    {
        $deleteForm = $this->createDeleteForm($municipality);

        return $this->render('municipality/show.html.twig', array(
            'municipality' => $municipality,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing municipality entity.
     *
     * @Route("/{id}/edit", name="municipality_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Municipality $municipality)
    {
        $deleteForm = $this->createDeleteForm($municipality);
        $editForm = $this->createForm('AppBundle\Form\MunicipalityType', $municipality);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('municipality_edit', array('id' => $municipality->getId()));
        }

        return $this->render('municipality/edit.html.twig', array(
            'municipality' => $municipality,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a municipality entity.
     *
     * @Route("/{id}", name="municipality_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Municipality $municipality)
    {
        $form = $this->createDeleteForm($municipality);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($municipality);
            $em->flush();
        }

        return $this->redirectToRoute('municipality_index');
    }

    /**
     * Creates a form to delete a municipality entity.
     *
     * @param Municipality $municipality The municipality entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Municipality $municipality)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('municipality_delete', array('id' => $municipality->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
