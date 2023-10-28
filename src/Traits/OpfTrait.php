<?php

namespace Maris\Symfony\Company\Traits;

use Doctrine\ORM\Mapping\Embedded;
use Maris\Symfony\Company\Entity\Embeddable\LegalForm;

/***
 * Трейт импортируется в сущности, что имеют организационно-правовую форму.
 */
trait OpfTrait
{
    #[Embedded(class: LegalForm::class,columnPrefix: "legal_form_")]
    protected LegalForm $legalForm;

    /**
     * @return LegalForm
     */
    public function getLegalForm(): LegalForm
    {
        return $this->legalForm;
    }

    /**
     * @param LegalForm $legalForm
     * @return $this
     */
    public function setLegalForm(LegalForm $legalForm): self
    {
        $this->legalForm = $legalForm;
        return $this;
    }


}