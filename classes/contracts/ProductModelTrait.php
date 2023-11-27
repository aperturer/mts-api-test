<?php

declare(strict_types=1);

trait ProductModelTrait
{
    protected ProductModelInterface $productModel;

    public function setProductModel(ProductModelInterface $productModel)
    {
        $this->productModel = $productModel;
    }
}
