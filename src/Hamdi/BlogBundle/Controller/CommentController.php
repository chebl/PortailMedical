<?php

namespace Hamdi\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Hamdi\BlogBundle\Entity\Comment;
use Hamdi\BlogBundle\Form\CommentType;

/**
 * Comment controller.
 */
class CommentController extends Controller
{
    public function newAction($blog_id)
    {
        $blog = $this->getBlog($blog_id);

        $comment = new Comment();
        $comment->setBlog($blog);
        $form   = $this->createForm(new CommentType(), $comment);

        return $this->render('HamdiBlogBundle:Comment:form.html.twig', array(
            'comment' => $comment,
            'form'   => $form->createView()
        ));
    }

    public function createAction($blog_id)
    {
        $blog = $this->getBlog($blog_id);

        $comment  = new Comment();
        $comment->setBlog($blog);
        $request = $this->getRequest();
        $form    = $this->createForm(new CommentType(), $comment);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()
                       ->getEntityManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirect($this->generateUrl('HamdiBlogBundle_blog_show', array(
                'id' => $comment->getBlog()->getId())) .
                '#comment-' . $comment->getId()
            );
        }

        return $this->render('HamdiBlogBundle:Comment:create.html.twig', array(
            'comment' => $comment,
            'form'    => $form->createView()
        ));
    }

    protected function getBlog($blog_id)
    {
        $em = $this->getDoctrine()
                    ->getEntityManager();

        $blog = $em->getRepository('HamdiBlogBundle:Blog')->find($blog_id);

        if (!$blog) {
            throw $this->createNotFoundException('Unable to find Blog post.');
        }

        return $blog;
    }
}
?>
