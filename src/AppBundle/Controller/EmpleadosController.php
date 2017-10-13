<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Empleados;

class EmpleadosController extends Controller
{
    /**
     * @Route("empleados", name="empleados")
     */
    public function indexAction(Request $request)
    {
        
        $empleadores = $this->getDoctrine()->getManager()->getRepository("AppBundle:Empleados")->findAll();
        
        return $this->render('empleados/empleadosList.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'empleados' => $empleadores
        ]);
    }
    /**
     * @Route("empleados/nuevo", name="nuevo empleado")
     */
    public function nuevoAction(Request $request)
    {
        
        return $this->render('empleados/empleadosForm.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR
        ]);
    }
    
     /**
     * @Route("empleados/editar/{id}", name="editar empleado")
     */
    public function editarAction(Request $request, $id)
    {
        $empleado = $this->getDoctrine()->getManager()->getRepository("AppBundle:Empleados")->find($id);
        return $this->render('empleados/empleadosFormEdit.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'empleado' => $empleado
        ]);
    }
    
     /**
     * @Route("empleados/edit", name="update empleado")
     */
    public function editAction(Request $request)
    {
        $empleado = $this->getDoctrine()->getManager()->getRepository("AppBundle:Empleados")->find($request->request->get("id"));
        $empleado->setNombre($request->request->get("nombre"));
        $empleado->setSexo($request->request->get("sexo"));
        $empleado->setCedula($request->request->get("cedula"));
        $empleado->setTelefono($request->request->get("telefono"));
        $empleado->setTipoContrato($request->request->get("type"));
        $empleado->setCreado(date("Y-m-d H:i:s"));
        
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($empleado);
        $em->flush();
        
        return $this->redirect('/empleados', 301);
    }
    /**
     * @Route("empleados/save", name="guardar empleado")
     */
    public function saveAction(Request $request)
    {
        
        $empleado = new Empleados();
        $empleado->setNombre($request->request->get("nombre"));
        $empleado->setSexo($request->request->get("sexo"));
        $empleado->setCedula($request->request->get("cedula"));
        $empleado->setTelefono($request->request->get("telefono"));
        $empleado->setTipoContrato($request->request->get("type"));
        $empleado->setCreado(date("Y-m-d H:i:s"));
        
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($empleado);
        $em->flush();
        
        return $this->redirect('/empleados', 301);
    }
    
    /**
     * @Route("empleados/delete/{id}", name="eliminar empleado")
     */
    public function deleteAction(Request $request, $id)
    {
        
        $empleado = $this->getDoctrine()->getManager()->getRepository("AppBundle:Empleados")->find($id);
        
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($empleado);
        $em->flush();
        
        return $this->redirect('/empleados', 301);
    }
}
