<?php

namespace App\Controller;

use App\Entity\Invoice;
use App\Entity\InvoiceLine;
use App\Form\InvoiceLineType;
use App\Form\InvoiceType;
use App\Repository\InvoiceLineRepository;
use App\Repository\InvoiceRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InvoiceController extends AbstractController
{
    #[Route('/invoice', name: 'app_invoice')]
    public function listInvoice(InvoiceRepository $invoiceRepository): Response
    {
        $invoices = $invoiceRepository->findAll();
        return $this->render('invoice/list.html.twig', [
            'invoices' => $invoices,
        ]);
    }

    #[Route('/invoice/field/{id}', name: 'app_invoice_line')]
    public function listInvoiceField(Invoice $invoice, InvoiceLineRepository $invoiceLineRepository): Response
    {
        $invoiceLines = $invoiceLineRepository->findBy([
            'invoice' => $invoice->getId(),
        ]);
        return $this->render('invoice/field_list.html.twig', [
            'invoiceLines' => $invoiceLines,
            'invoice' => $invoice,
        ]);
    }

    #[Route('/invoice/create', name: 'app_invoice_create')]
    public function create(Request $request, ObjectManager $manager): Response
    {
        $invoice = new Invoice();
        $form = $this->createForm(InvoiceType::class, $invoice);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($invoice);
            $manager->flush();

            $this->addFlash("message", "The Invoice was created. You can can now add invoice fields");
            return $this->redirectToRoute('app_invoice_line_create');
        }

        return $this->render('invoice/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/invoice/line/create', name: 'app_invoice_line_create')]
    public function addLine(Request $request, ObjectManager $manager): Response
    {
        $invoiceLine = new InvoiceLine();

        $form = $this->createForm(InvoiceLineType::class, $invoiceLine);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($invoiceLine);
            $manager->flush();

            $this->addFlash("message", "A field was added to invoice " . $invoiceLine->getInvoice()->getNumber());
            unset($invoiceLine);
            unset($form);
            $invoiceLine = new InvoiceLine();
            $form = $this->createForm(InvoiceLineType::class, $invoiceLine);
        }

        return $this->render('invoice/add_line.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
