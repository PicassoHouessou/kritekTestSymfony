<?php

namespace App\Entity;

use App\Repository\InvoiceLineRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: InvoiceLineRepository::class)]
class InvoiceLine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Invoice::class, inversedBy: 'invoiceLines')]
    #[ORM\JoinColumn(nullable: false)]
    private $invoice;

    #[ORM\Column(type: 'text')]
    /**
     * @Assert\Sequentially({
     *     @Assert\NotBlank,
     *     @Assert\Length(max=5000)
     * })
     */
    private $description;

    #[ORM\Column(type: 'integer')]
    /**
     * @Assert\Sequentially({
     *     @Assert\NotBlank,
     *     @Assert\Positive
     * })
     */
    private $quantity;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 2)]
    /**
     * @Assert\Sequentially({
     *     @Assert\NotBlank,
     *     @Assert\Positive
     * })
     */
    private $amount;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 2)]
    /**
     * @Assert\Sequentially({
     *     @Assert\NotBlank,
     *     @Assert\Positive
     * })
     */
    private $vat;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 2)]
    /**
     * @Assert\Sequentially({
     *     @Assert\NotBlank,
     *     @Assert\Positive
     * })
     */
    private $total;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(?Invoice $invoice): self
    {
        $this->invoice = $invoice;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getVat(): ?string
    {
        return $this->vat;
    }

    public function setVat(string $vat): self
    {
        $this->vat = $vat;

        return $this;
    }

    public function getTotal(): ?string
    {
        return $this->total;
    }

    public function setTotal(string $total): self
    {
        $this->total = $total;

        return $this;
    }
}
