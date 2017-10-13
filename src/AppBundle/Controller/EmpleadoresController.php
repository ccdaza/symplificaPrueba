<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Empleadores;

class EmpleadoresController extends Controller
{
    /**
     * @Route("empleadores", name="empleadores")
     */
    public function indexAction(Request $request)
    {
        
        $empleadores = $this->getDoctrine()->getManager()->getRepository("AppBundle:Empleadores")->findAll();
        
        return $this->render('default/empledoresList.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'empleadores' => $empleadores
        ]);
    }
    /**
     * @Route("empleadores/nuevo", name="nuevo")
     */
    public function nuevoAction(Request $request)
    {
        
        return $this->render('default/empleadoresForm.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR
        ]);
    }
    
     /**
     * @Route("empleadores/editar/{id}", name="editar")
     */
    public function editarAction(Request $request, $id)
    {
        $empleador = $this->getDoctrine()->getManager()->getRepository("AppBundle:Empleadores")->find($id);
        return $this->render('default/empleadoresFormEdit.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'empleador' => $empleador
        ]);
    }
    
     /**
     * @Route("empleadores/edit", name="update")
     */
    public function editAction(Request $request)
    {
        $empleador = $this->getDoctrine()->getManager()->getRepository("AppBundle:Empleadores")->find($request->request->get("id"));
        $empleador->setNombre($request->request->get("nombre"));
        $empleador->setSexo($request->request->get("sexo"));
        $empleador->setCedula($request->request->get("cedula"));
        $empleador->setTelefono($request->request->get("telefono"));
        $empleador->setDireccion($request->request->get("direccion"));
        $empleador->setFechaNacimiento(date("Y-m-d H:i:s", strtotime($request->request->get("fecha"))));
        $empleador->setCreado(date("Y-m-d H:i:s"));
        $empleador->setUpdatedAt(date("Y-m-d H:i:s"));
        
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($empleador);
        $em->flush();
        
        return $this->redirect('/empleadores', 301);
    }
    /**
     * @Route("empleadores/save", name="guardar")
     */
    public function saveAction(Request $request)
    {
        
        $empleador = new Empleadores();
        $empleador->setNombre($request->request->get("nombre"));
        $empleador->setSexo($request->request->get("sexo"));
        $empleador->setCedula($request->request->get("cedula"));
        $empleador->setTelefono($request->request->get("telefono"));
        $empleador->setDireccion($request->request->get("direccion"));
        $empleador->setFechaNacimiento(date("Y-m-d H:i:s", strtotime($request->request->get("fecha"))));
        $empleador->setCreado(date("Y-m-d H:i:s"));
        $empleador->setUpdatedAt(date("Y-m-d H:i:s"));
        
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($empleador);
        $em->flush();
        
        return $this->redirect('/empleadores', 301);
    }
    
    /**
     * @Route("empleadores/delete/{id}", name="eliminar")
     */
    public function deleteAction(Request $request, $id)
    {
        
        $empleador = $this->getDoctrine()->getManager()->getRepository("AppBundle:Empleadores")->find($id);
        
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($empleador);
        $em->flush();
        
        return $this->redirect('/empleadores', 301);
    }
}
